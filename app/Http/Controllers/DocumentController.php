<?php

namespace App\Http\Controllers;

use App\Models\User;
use Aws\S3\S3Client;
use Ramsey\Uuid\Uuid;
use App\Models\Document;
use App\Models\Declaration;
use FilePreviews\FilePreviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SWeb3\SWeb3;
use SWeb3\SWeb3_Contract;

class DocumentController extends Controller
{
    public function accept(Document $document)
    {
        try {
            // update status document
            $document->update(['status' => 'Signing']);

            // Log the download
            \Log::info('File accepted: ' . $document->name);
            // Serve the file to the user

            return redirect()->route('dashboard')->with('success', 'Document accepted successfully.');
        } catch (\Exception $e) {
            // Handle errors
            \Log::error('Error accepting file: ' . $e->getMessage());
            return response()->json(['message' => 'Error accepting file'], 500);
        }
    }

    public function reject(Document $document)
    {
        try {
            // update status document
            $document->update(['status' => 'Rejected']);

            // Log the download
            \Log::info('File rejected: ' . $document->name);
            // Serve the file to the user

            return redirect()->route('dashboard')->with('success', 'Document rejected successfully.');
        } catch (\Exception $e) {
            // Handle errors
            \Log::error('Error rejecting file: ' . $e->getMessage());
            return response()->json(['message' => 'Error rejecting file'], 500);
        }
    }

    public function reject_publish(Declaration $document)
    {
        try {
            // update status document
            $document->update(['status' => 'Rejected']);

            // Log the download
            \Log::info('File rejected: ' . $document->name);
            // Serve the file to the user

            return redirect()->route('publish')->with('success', 'Document rejected successfully.');
        } catch (\Exception $e) {
            // Handle errors
            \Log::error('Error rejecting file: ' . $e->getMessage());
            return response()->json(['message' => 'Error rejecting file'], 500);
        }
    }

    public function preview(Document $document)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $bucket = 'matflo';
        $key = str_replace(env("AWS_URL"), "", $document->file_path);
        try {
            // $result = $s3->getObject([
            //     'Bucket' => $bucket,
            //     'Key'    => $key,
            // ]);

            // // content of file
            // $fileContent = $result['Body'];

            // // header Content-Type 
            // $contentType = $result['ContentType'];
            $cmd = $s3->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => $key
            ]);
            $result = $s3->createPresignedRequest($cmd, '+5 minutes');
            $presignedUrl = (string) $result->getUri();


            $fp = new FilePreviews([
                'api_key' => env('FILE_PREVIEWS_API_KEY'),
                'api_secret' => env('FILE_PREVIEWS_SECRET_KEY')
            ]);
            $options = [
                'format' => 'png',
                'pages' => 'all',
            ];
            $response = $fp->generate($presignedUrl, $options);

            $response = $fp->retrieve($response->id);
            while (true) {
                if ($response->status == 'success')
                    break;
                $response = $fp->retrieve($response->id);
                sleep(1);
            }

            $allpages = [];
            foreach ($response->thumbnails as $thumbnail) {
                array_push($allpages,  $thumbnail->url);
            }
            return response($allpages)->header('Content-Type', 'application/json');
            // response HTTP
            // return response($fileContent)->header('Content-Type', $contentType);
        } catch (\Exception $e) {
            // Tangani kesalahan jika gagal mengambil file
            \Log::error('Error accessing S3 file: ' . $e->getMessage());
            return response()->json(['message' => 'Error accessing S3 file' . $e->getMessage() . "AWS_URL: " . env("AWS_URL")], 500);
        }
    }

    public function preview_publish(Declaration $document)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $bucket = 'matflo';
        $key = str_replace(env("AWS_URL"), "", $document->file_path);
        try {
            // $result = $s3->getObject([
            //     'Bucket' => $bucket,
            //     'Key'    => $key,
            // ]);

            // // content of file
            // $fileContent = $result['Body'];

            // // header Content-Type 
            // $contentType = $result['ContentType'];
            $cmd = $s3->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key'    => $key
            ]);
            $result = $s3->createPresignedRequest($cmd, '+5 minutes');
            $presignedUrl = (string) $result->getUri();


            $fp = new FilePreviews([
                'api_key' => env('FILE_PREVIEWS_API_KEY'),
                'api_secret' => env('FILE_PREVIEWS_SECRET_KEY')
            ]);
            $options = [
                'format' => 'png',
                'pages' => 'all',
            ];
            $response = $fp->generate($presignedUrl, $options);

            $response = $fp->retrieve($response->id);
            while (true) {
                if ($response->status == 'success')
                    break;
                $response = $fp->retrieve($response->id);
                sleep(1);
            }

            $allpages = [];
            foreach ($response->thumbnails as $thumbnail) {
                array_push($allpages,  $thumbnail->url);
            }
            return response($allpages)->header('Content-Type', 'application/json');
            // response HTTP
            // return response($fileContent)->header('Content-Type', $contentType);
        } catch (\Exception $e) {
            // Tangani kesalahan jika gagal mengambil file
            \Log::error('Error accessing S3 file: ' . $e->getMessage());
            return response()->json(['message' => 'Error accessing S3 file' . $e->getMessage() . "AWS_URL: " . env("AWS_URL")], 500);
        }
    }

    public function sign(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:1024',
            'document_id' => 'required|string',
        ]);

        // Upload document to storage s3
        $fileUrl = $this->uploadDocument($request->file('file'));

        // Get document data
        $document = Document::where('document_id', $request->input('document_id'))->first();
        if (!$document) {
            return redirect()->route('dashboard')->with('error', 'Failed to sign document, document not found.');
        }

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

        return redirect()->route('dashboard')->with('success', 'Document signed successfully.');
    }

    public function approve(Declaration $document)
    {
        if (!$document) {
            return redirect()->route('dashboard')->with('error', 'Failed to approve document, document not found.');
        }

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
            'status' => 'Published',
            'published_at' => now('America/Chicago'),
            'chain_address' => $result->result
        ]);

        return redirect()->route('publish')->with('success', 'Document approved successfully.');
    }

    private function uploadDocument($file)
    {
        try {
            $filename = time() . '_' . str_replace(" ", "_", $file->getClientOriginalName());
            $filePath = 'documents/' . $filename;

            $response = Storage::disk('s3-private')->put($filePath, file_get_contents($file));
            $fileUrl = Storage::disk('s3-private')->url($filePath);

            \Log::info("File Path: " . $filePath);
            \Log::info("File URL: " . $fileUrl);
            \Log::info("File: " . $file);

            return $fileUrl;
        } catch (\Exception $e) {

            \Log::error('Error while uploading file: ' . $e->getMessage());
            return response()->json(['message' => 'Error uploading file'], 500);
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:1024'
        ]);

        // upload document to storage s3
        $fileUrl = $this->uploadDocument($request->file('file'));

        // Set verifier randomly
        $verifierIds = User::where('role', 'VERIFIER')->pluck('id')->toArray();
        $randomVerifierId = $verifierIds[array_rand($verifierIds)];

        Document::create([
            'name' => $request->input('documentName'),
            'location' => $request->input('documentLocation'),
            'producer_id' => auth()->id(),
            'verifier_id' => $randomVerifierId,
            'file_path' => $fileUrl,
            'document_id' => Uuid::uuid4()->toString(),
            'status' => 'Ready for preview',
        ]);

        return redirect()->route('dashboard')->with('success', 'Document uploaded successfully.');
    }

    public function publish(Request $request)
    {
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

        Declaration::create([
            'name' => $documentName,
            'location' => $documentLocation,
            'producer' => $documentProducer,
            'verifier' => $documentVerifier,
            'uploader_id' => auth()->id(),
            'gwp' => $documentGWP,
            'file_path' => $fileUrl,
            'document_id' => Uuid::uuid4()->toString(),
            'status' => $status,
        ]);

        return redirect()->route('publish')->with('success', 'Declaration uploaded successfully.');
    }

    public function download(Document $document)
    {
        try {
            // Manipulate string file_path
            if (is_null($document->signed_file_path)) {
                $filePath = str_replace(env("AWS_URL"), "", $document->file_path);
            } else {
                $filePath = str_replace(env("AWS_URL"), "", $document->signed_file_path);
            }

            // Retrieve file from S3
            $fileContents = Storage::disk('s3-private')->get($filePath);

            // Determine the MIME type of the file
            $mimeType = Storage::disk('s3-private')->mimeType($filePath);

            // Set appropriate headers for file download
            $headers = [
                'Content-Disposition' => 'attachment; filename="' . $filePath . '"',
                'Content-Type' => $mimeType, // Set the MIME type
            ];
            // Log the download
            \Log::info('File downloaded: ' . $document->name);
            // Serve the file to the user
            return response($fileContents, 200, $headers);
        } catch (\Exception $e) {
            // Handle errors
            \Log::error('Error downloading file: ' . $e->getMessage());
            return response()->json(['message' => 'Error downloading file'], 500);
        }
    }

    public function download_publish(Declaration $document)
    {
        try {
            // Manipulate string file_path
            $filePath = str_replace(env("AWS_URL"), "", $document->file_path);

            // Retrieve file from S3
            $fileContents = Storage::disk('s3-private')->get($filePath);

            // Determine the MIME type of the file
            $mimeType = Storage::disk('s3-private')->mimeType($filePath);

            // Set appropriate headers for file download
            $headers = [
                'Content-Disposition' => 'attachment; filename="' . $filePath . '"',
                'Content-Type' => $mimeType, // Set the MIME type
            ];
            // Log the download
            \Log::info('File downloaded: ' . $document->name);
            // Serve the file to the user
            return response($fileContents, 200, $headers);
        } catch (\Exception $e) {
            // Handle errors
            \Log::error('Error downloading file: ' . $e->getMessage());
            return response()->json(['message' => 'Error downloading file'], 500);
        }
    }

    public function edit(Declaration $document, Request $request)
    {
        $documentName = trim($request->input('documentName') ?? '');
        $documentProducer = trim($request->input('documentProducer') ?? '');
        $documentVerifier = trim($request->input('documentVerifier') ?? '');
        $documentGWP = trim($request->input('documentGWP') ?? '');

        if($documentName === "" || $documentProducer === "" || $documentVerifier === "" || $documentGWP === "") {
            $status = 'Need Info';
        } else {
            $status = 'Under Review';
        }

        Declaration::where('id', $document->id)->update([
            'name' => $documentName,
            'producer' => $documentProducer,
            'verifier' => $documentVerifier,
            'gwp' => $documentGWP,
            'status' => $status,
        ]);

        return redirect()->route('publish')->with('success', 'Declaration updated successfully.');
    }

    public function delete(Declaration $document)
    {
        Declaration::where('id', $document->id)->delete();

        return redirect()->route('publish')->with('success', 'Declaration deleted successfully.');
    }

}
