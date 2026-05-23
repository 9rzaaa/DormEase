<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FDProfileController extends Controller
{
    public function index()
    {
        return view('fdprofile');
    }
}