<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pagesController extends Controller
{
    //
    public function root()
    {
        return view('pages.root');
    }
    
    public function emailVerifyNotice()
    {
        return view('pages.email_verify_notice');
    }
}
