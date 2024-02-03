<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $res = User::select('user_name', 'wallet')->where('role','<>','ADMIN')->get()->toArray();
        if(\Auth::user()->role == 'ADMIN'){
            return view('admindashboard',compact('res'));
        }
        return view('dashboard',compact('res'));

    }

    public function viewBatch($batchNo,$txn){
        if(!isset($batchNo) || (isset($batchNo) && $batchNo=='') &&
        !isset($txn) || (isset($txn) && $txn=='')){
            return redirect(route('dashboard'));
        }
        //dd($batchNo,$txn);
        return view('view_batch',compact('batchNo','txn'));
    }
}
