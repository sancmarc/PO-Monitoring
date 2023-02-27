<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index(){
        return view('admins.index');
    }

    function addAccount(){
        return view('admins.add-account');
    }
}
