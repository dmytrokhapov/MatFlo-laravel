<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkFlowController extends Controller
{
    public function create(){
        if(\Auth::user()->role == "ADMIN"){
            return view('admin.workflow.create');
        }
        elseif(\Auth::user()->role == "PRODUCER"){
            return view('producer.workflow.create');
        }
        elseif(\Auth::user()->role == "CALCULATOR"){
            return view('calculator.workflow.create');
        }
        elseif(\Auth::user()->role == "VERIFIER"){
            return view('verifier.workflow.create');
        }
    }
}
