<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataBayi;
use Illuminate\Http\Request;

class DataBayiController extends Controller
{
    public function index() {
        $data = DataBayi::with('user')->get();
        $users = User::where('level', 1)->get();
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
            'lila' => 'required|numeric'
        ]);

        $data->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id) {
        DataBayi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function perhitungan()
    {
        $bayi = DataBayi::all();

        // Hitung mean
        $mean = [
            'berat' => $bayi->avg('berat'),
            'tinggi' => $bayi->avg('tinggi'),
            'lila' => $bayi->avg('lila'),
        ];

        // Hitung total kuadrat selisih untuk std dev
        $stdDev = [];
        foreach (['berat', 'tinggi', 'lila'] as $field) {
            $sum_sq = $bayi->pluck($field)->map(function ($val) use ($mean, $field) {
                return pow($val - $mean[$field], 2);
            })->sum();

            $stdDev[$field] = sqrt($sum_sq / (count($bayi) - 1));
        }

        // Buat array hasil perhitungan per bayi
        $hasil = $bayi->map(function ($b) use ($mean) {
            return [
                'nama' => $b->nama,
                'berat' => $b->berat,
                'berat_selisih' => round($b->berat - $mean['berat'], 5),
                'berat_kuadrat' => round(pow($b->berat - $mean['berat'], 2), 5),

                'tinggi' => $b->tinggi,
                'tinggi_selisih' => round($b->tinggi - $mean['tinggi'], 5),
                'tinggi_kuadrat' => round(pow($b->tinggi - $mean['tinggi'], 2), 5),

                'lila' => $b->lila,
                'lila_selisih' => round($b->lila - $mean['lila'], 5),
                'lila_kuadrat' => round(pow($b->lila - $mean['lila'], 2), 5),
            ];
        });

        return view('perhitungan', compact('mean', 'stdDev', 'hasil'));
    }

}
