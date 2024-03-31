<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userRole = \Auth::user()->role;

        // Get all users
        $res = User::where('role', '<>', 'ADMIN')->get();
        $userId = auth()->id();

        // check if there is a search string

        if(!empty($request->get('q'))){
            $search = $request->get('q');
        } else {
            $search = '';
        }

        // Query documents

        $documentAll = Document::with(['producer', 'verifier'])->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%')->orWhere('status', 'LIKE', '%'.$search.'%')->orWhereHas('producer', function ($query) use ($search) {
            $query->where('user_name', 'like', '%' . $search . '%');
        })->get();
        $documents = Document::with(['producer', 'verifier'])->where('producer_id', $userId)->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%')->orWhere('status', 'LIKE', '%'.$search.'%')->orWhereHas('producer', function ($query) use ($search) {
            $query->where('user_name', 'like', '%' . $search . '%');
        })->latest()->paginate(10);
        $documentsForReview = Document::with(['producer', 'verifier'])->where('verifier_id', $userId)->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%')->orWhere('status', 'LIKE', '%'.$search.'%')->orWhereHas('producer', function ($query) use ($search) {
            $query->where('user_name', 'like', '%' . $search . '%');
        })->latest()->paginate(10);


        // return view files with users and documents data

        if ($userRole === 'ADMIN') {
            return view('admindashboard', compact('res', 'documentAll', 'search'));
        } elseif ($userRole === 'PRODUCER') {
            return view('dashboard')->with(['documents'=> $documents, 'search' => $search]);
        }elseif ($userRole === 'VERIFIER') {
            return view('verifierdashboard')->with(['documents' => $documentsForReview, 'search' => $search]);
        }

        return view('dashboard')->with('documents', $documents);
    }

    public function viewBatch($batchNo)
    {
        if (!isset($batchNo)) {
            return redirect()->route('dashboard');
        }

        $document = Document::with(['producer', 'verifier'])->where('document_id', $batchNo)->first();

        return view('view_batch', compact('document'));
    }

}