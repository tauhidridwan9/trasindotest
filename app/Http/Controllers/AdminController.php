<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){

        $user = auth()->user();

        if(!$user){
            return abort(404, 'Admin not Found');
        }

        return view('admin.dashboard');
    }
}
