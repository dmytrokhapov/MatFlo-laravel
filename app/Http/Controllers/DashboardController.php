<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userRole = \Auth::user()->role;
        $res = User::where('role', '<>', 'ADMIN')->get();
        $userId = auth()->id();
        $documentAll = Document::with(['producer', 'verifier'])->get();
        $documents = Document::with(['producer', 'verifier'])->where('producer_id', $userId)->latest()->paginate(10);
        $documentsForReview = Document::with(['producer', 'verifier'])->where('verifier_id', $userId)->latest()->paginate(10);

        if ($userRole === 'ADMIN') {
            return view('admindashboard', compact('res', 'documentAll'));
        } elseif ($userRole === 'PRODUCER') {
            return view('dashboard')->with('documents', $documents);
        }elseif ($userRole === 'VERIFIER') {
            return view('verifierdashboard')->with('documents', $documentsForReview);
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