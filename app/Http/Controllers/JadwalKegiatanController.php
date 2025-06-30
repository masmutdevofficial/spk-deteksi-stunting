<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKegiatan;

class JadwalKegiatanController extends Controller
{
    public function index() {
        $data = JadwalKegiatan::all();
        return view('jadwal-kegiatan', compact('data'));
    }

    public function store(Request $request) {
        $request->validate([
            'bulan' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'sasaran' => 'required|string|max:255',
            'pelaksana' => 'required|string|max:255',
            'catatan_tambahan' => 'nullable|string',
        ]);

        JadwalKegiatan::create($request->all());
        return redirect()->back()->with('success', 'Jadwal kegiatan berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $data = JadwalKegiatan::findOrFail($id);

        $request->validate([
            'bulan' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'sasaran' => 'required|string|max:255',
            'pelaksana' => 'required|string|max:255',
            'catatan_tambahan' => 'nullable|string',
        ]);

        $data->update($request->all());
        return redirect()->back()->with('success', 'Jadwal kegiatan berhasil diperbarui');
    }

    public function destroy($id) {
        JadwalKegiatan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal kegiatan berhasil dihapus');
    }
}
