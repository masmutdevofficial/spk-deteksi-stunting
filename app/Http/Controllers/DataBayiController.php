<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataBayi;
use Illuminate\Http\Request;

class DataBayiController extends Controller
{
    public function index() {
        $data = DataBayi::with('user')->get();
        $users = User::all();
        return view('data-bayi', compact('data', 'users'));
    }

    public function store(Request $request) {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'nama' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required|in:1,2',
            'berat' => 'required|numeric',
            'tinggi' => 'required|numeric',
            'lila' => 'required|numeric',
            'nilai_bb_tb' => 'required|numeric',
            'hasil_bb_tb' => 'required'
        ]);

        DataBayi::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $data = DataBayi::findOrFail($id);

        $request->validate([
            'id_user' => 'required|exists:users,id',
            'nama' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required|in:1,2',
            'berat' => 'required|numeric',
            'tinggi' => 'required|numeric',
            'lila' => 'required|numeric',
            'nilai_bb_tb' => 'required|numeric',
            'hasil_bb_tb' => 'required'
        ]);

        $data->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id) {
        DataBayi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
