<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPenimbangan;

class JadwalPenimbanganController extends Controller
{
    public function index() {
        $data = JadwalPenimbangan::all();
        return view('jadwal-penimbangan', compact('data'));
    }

    public function store(Request $request) {
        $request->validate([
            'bulan' => 'required|string|max:255',
            'lokasi_posyandu' => 'required|string|max:255',
            'tanggal_penimbangan' => 'required|date',
            'waktu' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        JadwalPenimbangan::create($request->all());
        return redirect()->back()->with('success', 'Jadwal penimbangan berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $data = JadwalPenimbangan::findOrFail($id);

        $request->validate([
            'bulan' => 'required|string|max:255',
            'lokasi_posyandu' => 'required|string|max:255',
            'tanggal_penimbangan' => 'required|date',
            'waktu' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data->update($request->all());
        return redirect()->back()->with('success', 'Jadwal penimbangan berhasil diperbarui');
    }

    public function destroy($id) {
        JadwalPenimbangan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal penimbangan berhasil dihapus');
    }
}
