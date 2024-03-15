<?php

namespace App\Http\Controllers\Auth;

use App\Models\Applications;
use Illuminate\Http\Request;
use App\Models\Useraccesslog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //

    public function do_logout(){
        //Applications::clearApplicationDataFromSession(); //clear any application data that may be in the session

        //dd('logout');
        if( Auth::user() ){
            //Useraccesslog::logUserAction(Auth::user()->id, 'logged-out');
            session()->flush();
            Auth::logout();
        }

        return redirect()->route('login');
    }
}