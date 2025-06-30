<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusGiziController extends Controller
{
    public function index() {
        return view('status-gizi');
    }
}
