<?php

namespace App\Http\Controllers;

use App\Models\DataBayi;
use Illuminate\Http\Request;

class PenangananGiziController extends Controller
{
    public function index()
    {
        // Ambil data bayi dengan relasi penanganan
        $dataBayi = DataBayi::with('penanganan')
            ->select('id', 'nama', 'tgl_penimbangan', 'bb_tb')
            ->get();

        return view('penanganan-gizi', compact('dataBayi'));
    }

    public function cetakPenangananGizi()
    {
        // Ambil data bayi dengan relasi penanganan
        $dataBayi = DataBayi::with('penanganan')
            ->select('id', 'nama', 'tgl_penimbangan', 'bb_tb')
            ->get();

        return view('cetak-penanganan-gizi', compact('dataBayi'));
    }
}
