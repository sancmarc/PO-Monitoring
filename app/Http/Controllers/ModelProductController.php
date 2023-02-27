<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModelProductController extends Controller
{
    public function addModel(){
        return view('admins.add-model');
    }
}
