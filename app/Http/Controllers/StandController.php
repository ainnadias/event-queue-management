<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StandController extends Controller
{
   public function index()
    {
        return view('dashboard.stand.index');
    }
}
