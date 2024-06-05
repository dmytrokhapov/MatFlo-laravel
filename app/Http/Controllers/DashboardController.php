<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\Declaration;
use Illuminate\Http\Request;
use App\Models\Api_log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userRole = \Auth::user()->role;

        // Get all users
        $res = User::where('role', '<>', 'ADMIN')->get();
        $log = Api_log::with(['api_key'])->get();
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
        $documents = Document::with(['producer', 'verifier'])->where('producer_id', $userId)->where(function ($query) use ($request, $search) {
            $query->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%')->orWhere('status', 'LIKE', '%'.$search.'%')->orWhereHas('producer', function ($query) use ($search) {
                $query->where('user_name', 'like', '%' . $search . '%');
            });
        })->latest()->paginate(10);
        $documentsForReview = Document::with(['producer', 'verifier'])->where('verifier_id', $userId)->where(function ($query) use ($request, $search) {
            $query->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%')->orWhere('status', 'LIKE', '%'.$search.'%')->orWhereHas('producer', function ($query) use ($search) {
                $query->where('user_name', 'like', '%' . $search . '%');
            });
        })->latest()->paginate(10);


        // return view files with users and documents data

        if ($userRole === 'ADMIN') {
            return view('admindashboard', compact('res', 'documentAll', 'search', 'log'));
        } elseif ($userRole === 'PRODUCER') {
            return view('dashboard')->with(['documents'=> $documents, 'search' => $search]);
        }elseif ($userRole === 'VERIFIER') {
            return view('verifierdashboard')->with(['documents' => $documentsForReview, 'search' => $search]);
        }

        return view('dashboard')->with('documents', $documents);
    }

    public function search(Request $request)
    {
        if(!empty($request->get('q'))){
            $search = $request->get('q');
        } else {
            $search = '';
        }

        // Query documents

        $documents = Document::with(['producer', 'verifier'])->where('status', 'Signed')->where(function ($query) use ($request, $search) {
            $query->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%');
        })->get()->toArray();
        $declarations = Declaration::with(['uploader'])->where('status', 'Published')->where(function ($query) use ($request, $search) {
            $query->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%');
        })->get()->toArray();

        return json_encode(array_merge($documents,$declarations));
    }

    public function publish(Request $request)
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

        $producers = User::where('role', 'PRODUCER')->get();

        // Query documents

        $documentAll = Declaration::with(['uploader'])->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%')->orWhere('status', 'LIKE', '%'.$search.'%')->orWhereHas('uploader', function ($query) use ($search) {
            $query->where('user_name', 'like', '%' . $search . '%');
        })->get();

        $documents = Declaration::with(['uploader'])->where('uploader_id', $userId)->where('name', 'LIKE', '%'.$search.'%')->orWhere('document_id', 'LIKE', '%'.$search.'%')->orWhere('status', 'LIKE', '%'.$search.'%')->orWhereHas('uploader', function ($query) use ($search) {
            $query->where('user_name', 'like', '%' . $search . '%');
        })->latest()->paginate(10);

        // return view files with users and documents data

        if ($userRole === 'ADMIN') {
            return view('publish')->with(['documents'=> $documentAll, 'search' => $search, 'producers' => json_encode($producers)]);
        } else {
            return view('publish')->with(['documents'=> $documents, 'search' => $search, 'producers' => json_encode($producers)]);
        }
    }

    public function viewBatch($batchNo)
    {
        if (!isset($batchNo)) {
            return redirect()->route('dashboard');
        }

        $document = Document::with(['producer', 'verifier'])->where('document_id', $batchNo)->first();

        return view('view_batch', compact('document'));
    }

    public function viewPublish($batchNo)
    {
        if (!isset($batchNo)) {
            return redirect()->route('publish');
        }

        $document = Declaration::with(['uploader'])->where('document_id', $batchNo)->first();

        return view('view_publish', compact('document'));
    }

    public function explorer()
    {
        $declarations = Declaration::whereNotNull('published_at')->get();
        return view('explorer', compact('declarations'));
    }

    public function explorerOld()
    {
        return view('explorerOld');
    }

}
