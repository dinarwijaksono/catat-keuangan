<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerateDataController extends Controller
{
    public function index()
    {
        return view('Generate.index');
    }
}
