<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengelolaanController extends Controller
{
    public function index()
    {
        return view('pengelolaan.index');
    }
}
