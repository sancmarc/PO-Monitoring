<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    protected function redirectTo(){
        if( Auth()->user()->role == 1){
            return route('admin.dashboard');
        }else if( Auth()->user() == 2){
            return route('user.dashboard');
        }
    }
}
