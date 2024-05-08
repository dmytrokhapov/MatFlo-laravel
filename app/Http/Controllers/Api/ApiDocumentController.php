<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Aws\S3\S3Client;
use Ramsey\Uuid\Uuid;
use App\Models\Document;
use App\Models\Declaration;
use FilePreviews\FilePreviews;
use Illuminate\Support\Facades\Storage;
use SWeb3\SWeb3;
use SWeb3\SWeb3_Contract;

class ApiDocumentController extends Controller
{
    public function getDocuments()
    {
        try {
            $documents = Document::get();
            return response()->json(['success' => 'success', 'documents' => $documents]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Error getting documents' . $e->getMessage()], 500);
        }
    }

    public function getDeclarations(Request $request)
    {
        try {
            $documents = Declaration::where('uploader_id', $request->keyuser->id,)->get();
            return response()->json(['success' => 'success', 'declarations' => $documents]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Error getting declarations' . $e->getMessage()], 500);
        }
    }

    private function uploadDocument($file)
    {
        try {
            $filename = time() . '_' . str_replace(" ", "_", $file->getClientOriginalName());
            $filePath = 'documents/' . $filename;

            $response = Storage::disk('s3-private')->put($filePath, file_get_contents($file));
            $fileUrl = Storage::disk('s3-private')->url($filePath);

            return $fileUrl;
        } catch (\Exception $e) {

            return response()->json(['error' => 'Error uploading file' . $e->getMessage()], 500);
        }
    }

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:1024'
            ]);
    
            // upload document to storage s3
            $fileUrl = $this->uploadDocument($request->file('file'));
    
            // Set verifier randomly
            $verifierIds = User::where('role', 'VERIFIER')->pluck('id')->toArray();
            $randomVerifierId = $verifierIds[array_rand($verifierIds)];
    
            $document = Document::create([
                'name' => $request->input('documentName'),
                'location' => $request->input('documentLocation'),
                'producer_id' => $request->keyuser->id,
                'verifier_id' => $randomVerifierId,
                'file_path' => $fileUrl,
                'document_id' => Uuid::uuid4()->toString(),
                'status' => 'Ready for preview',
            ]);

            return response()->json(['success' => 'Document uploaded successfully.', 'document' => $document]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading document: ' . $e->getMessage()], 500);
        }
    }

    public function accept(Document $document, Request $request)
    {
        try {
            // update status document
            if($document->status === "Ready for preview" && $document->verifier_id === $request->keyuser->id) {
                $document->update(['status' => 'Signing']);
                return response()->json(['success' => 'Document accepted successfully.']);
            } else {
                return response()->json(['error' => 'Document cannot be accepted'], 401);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error accepting file: ' . $e->getMessage()], 500);
        }
    }

    public function reject(Document $document, Request $request)
    {
        try {
            if($document->status !== "Signed" && $document->verifier_id === $request->keyuser->id) {
                $document->update(['status' => 'Rejected']);
                return response()->json(['success' => 'Document rejected successfully.']);
            } else {
                return response()->json(['error' => 'Document cannot be rejected'], 401);
            }
        } catch (\Exception $e) {
            // Handle errors
            return response()->json(['error' => 'Error rejecting file' . $e->getMessage()], 500);
        }
    }

    public function sign(Document $document, Request $request)
    {
        try {
            if($document->status === "Signing" && $document->verifier_id === $request->keyuser->id) {
                $request->validate([
                    'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:1024',
                ]);

                // Upload document to storage s3
                $fileUrl = $this->uploadDocument($request->file('file'));

                //Web3 operation

                $sweb3 = new SWeb3(env('RPC_URL'));
                $from_address = env('WALLET');
                $from_address_private_key = env('PRIVATE_KEY');
                $sweb3->setPersonalData($from_address, $from_address_private_key);
                $sweb3->chainId = 80002;

                $abi = '[{ "inputs": [], "stateMutability": "nonpayable", "type": "constructor" }, { "anonymous": false, "inputs": [ { "indexed": true, "internalType": "uint256", "name": "documentId", "type": "uint256" }, { "indexed": false, "internalType": "string", "name": "documentHash", "type": "string" } ], "name": "DocumentHashStored", "type": "event" }, { "inputs": [ { "internalType": "uint256", "name": "documentId", "type": "uint256" } ], "name": "getDocumentHash", "outputs": [ { "internalType": "string", "name": "", "type": "string" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "internalType": "uint256", "name": "documentId", "type": "uint256" }, { "internalType": "string", "name": "documentHash", "type": "string" } ], "name": "storeDocumentHash", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "newOwner", "type": "address" } ], "name": "transferOwnership", "outputs": [], "stateMutability": "nonpayable", "type": "function" }]';

                $extra_data = ['nonce' => $sweb3->personal->getNonce()];
                $data = [$document->id, $document->document_id];

                $contract = new SWeb3_contract($sweb3, env('CONTRACT_ADDRESS'), $abi);
                $result = $contract->send('storeDocumentHash', $data, $extra_data);

                // Assign document data has been signed
                $document->update([
                    'note' => $request->input('note'),
                    'status' => 'Signed',
                    'signed_file_path' => $fileUrl,
                    'verified_at' => now('America/Chicago'),
                    'chain_address' => $result->result
                ]);
                return response()->json(['success' => 'Document signed successfully.']);
            } else {
                return response()->json(['error' => 'Document cannot be signed'], 401);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error signing document: ' . $e->getMessage()], 500);
        }
        
    }

    public function publish(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:1024'
            ]);
    
            // upload document to storage s3
            $fileUrl = $this->uploadDocument($request->file('file'));
    
            $documentName = trim($request->input('documentName') ?? '');
            $documentLocation = trim($request->input('documentLocation') ?? '');
            $documentProducer = trim($request->input('documentProducer') ?? '');
            $documentVerifier = trim($request->input('documentVerifier') ?? '');
            $documentGWP = trim($request->input('documentGWP') ?? '');
    
            if($documentName === "" || $documentProducer === "" || $documentVerifier === "" || $documentGWP === "" || $documentLocation === "") {
                $status = 'Need Info';
            } else {
                $status = 'Under Review';
            }
    
            $declaration = Declaration::create([
                'name' => $documentName,
                'location' => $documentLocation,
                'producer' => $documentProducer,
                'verifier' => $documentVerifier,
                'uploader_id' => $request->keyuser->id,
                'gwp' => $documentGWP,
                'file_path' => $fileUrl,
                'document_id' => Uuid::uuid4()->toString(),
                'status' => $status,
            ]);

            return response()->json(['success' => 'Declaration uploaded successfully.', 'declaration' => $declaration]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error uploading declaration: ' . $e->getMessage()], 500);
        }
    }

    public function edit(Declaration $declaration, Request $request)
    {
        try {
            // update status declaration
            if($declaration->status !== "Published" && $declaration->uploader_id === $request->keyuser->id) {
                $documentName = trim($request->input('documentName') ?? '');
                $documentProducer = trim($request->input('documentProducer') ?? '');
                $documentVerifier = trim($request->input('documentVerifier') ?? '');
                $documentGWP = trim($request->input('documentGWP') ?? '');

                if($documentName === "" || $documentProducer === "" || $documentVerifier === "" || $documentGWP === "") {
                    $status = 'Need Info';
                } else {
                    $status = 'Under Review';
                }

                Declaration::where('id', $declaration->id)->update([
                    'name' => $documentName,
                    'producer' => $documentProducer,
                    'verifier' => $documentVerifier,
                    'gwp' => $documentGWP,
                    'status' => $status,
                ]);

                return response()->json(['success' => 'Declaration edited successfully.']);
            } else {
                return response()->json(['error' => 'Declaration cannot be edited'], 401);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error editing declaration: ' . $e->getMessage()], 500);
        }
    }

    public function delete(Declaration $declaration, Request $request)
    {
        try {
            // update status declaration
            if($declaration->status !== "Published" && $declaration->uploader_id === $request->keyuser->id) {
                Declaration::where('id', $declaration->id)->delete();

                return response()->json(['success' => 'Declaration deleted successfully.']);
            } else {
                return response()->json(['error' => 'Declaration cannot be deleted'], 401);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting declaration: ' . $e->getMessage()], 500);
        } 
    }
}
