<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        // echo "This is our Contact Page";
        return view('contact');
    }
}
