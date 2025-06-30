<?php

namespace App\Http\Controllers;

use App\Models\DataBayi;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function index()
    {
        $dataBayi = DataBayi::with('user')->get();
        return view('konsultasi', compact('dataBayi'));
    }
}
