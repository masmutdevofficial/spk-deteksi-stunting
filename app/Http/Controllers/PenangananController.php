<?php

namespace App\Http\Controllers;

use App\Models\DataBayi;
use App\Models\Penanganan;
use Illuminate\Http\Request;

class PenangananController extends Controller
{
    public function index()
    {
        return view('penanganan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bayi' => 'required|exists:data_bayi,id',
            'keterangan' => 'required|array',
            'keterangan.*' => 'string', // validasi tiap item dalam array
        ]);

        Penanganan::updateOrCreate(
            ['data_bayi_id' => $request->id_bayi],
            ['keterangan' => implode(', ', $request->keterangan)] // gabungkan array jadi string
        );

        return redirect('/konsultasi')->with('success', 'Penanganan berhasil disimpan.');
    }
}
