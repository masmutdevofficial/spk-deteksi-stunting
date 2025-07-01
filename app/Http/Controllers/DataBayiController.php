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
            'bb_tb' => 'required',
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
            'bb_tb' => 'required',
        ]);

        $data->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id) {
        DataBayi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    private function gaussian($x, $mean, $std)
    {
        if ($std == 0) return 0; // hindari divide-by-zero
        $exponent = exp(-pow($x - $mean, 2) / (2 * pow($std, 2)));
        return (1 / (sqrt(2 * pi()) * $std)) * $exponent;
    }

    public function perhitungan()
    {
        $bayi = DataBayi::all();

        // Mean dan standar deviasi keseluruhan
        $mean = [
            'berat'  => $bayi->avg('berat'),
            'tinggi' => $bayi->avg('tinggi'),
            'lila'   => $bayi->avg('lila'),
        ];

        $stdDev = [];
        foreach (['berat','tinggi','lila'] as $f) {
            $sum = $bayi->pluck($f)->map(fn($v)=>pow($v - $mean[$f], 2))->sum();
            $stdDev[$f] = sqrt($sum / (count($bayi)-1));
        }

        // Tabel per bayi
        $hasil = $bayi->map(function ($b) use ($mean) {
            return [
                'nama'            => $b->nama,
                'bb_tb'           => $b->bb_tb,
                'berat'           => $b->berat,
                'berat_selisih'   => round($b->berat  - $mean['berat'], 5),
                'berat_kuadrat'   => round(pow($b->berat  - $mean['berat'], 2), 5),
                'tinggi'          => $b->tinggi,
                'tinggi_selisih'  => round($b->tinggi - $mean['tinggi'], 5),
                'tinggi_kuadrat'  => round(pow($b->tinggi - $mean['tinggi'], 2), 5),
                'lila'            => $b->lila,
                'lila_selisih'    => round($b->lila   - $mean['lila'], 5),
                'lila_kuadrat'    => round(pow($b->lila   - $mean['lila'], 2), 5),
            ];
        });

        // Statistik Naive Bayes
        $total = $bayi->count();
        $naive = $bayi->groupBy('bb_tb')->map(function ($grp) use ($total) {
            $cnt   = $grp->count();
            $prior = $cnt / $total;

            $stat = [];
            foreach (['berat','tinggi','lila'] as $f) {
                $μ   = $grp->avg($f);
                $σ²  = $grp->pluck($f)->map(fn($v)=>pow($v - $μ, 2))->sum() / ($cnt - 1 ?: 1);
                $σ   = sqrt($σ²);
                $std = max($σ, 1.0); // fallback jika σ terlalu kecil

                $stat[$f] = ['mean' => $μ, 'std' => $std];
            }

            return [
                'prior'  => $prior,
                'berat'  => $stat['berat'],
                'tinggi' => $stat['tinggi'],
                'lila'   => $stat['lila'],
            ];
        });

        // likelihood dan prediksi
        $likelihoods = $bayi->map(function ($b) use ($naive) {
            $results = [];

            foreach ($naive as $status => $stats) {
                $prob_berat  = $this->gaussian($b->berat,  $stats['berat']['mean'],  $stats['berat']['std']);
                $prob_tinggi = $this->gaussian($b->tinggi, $stats['tinggi']['mean'], $stats['tinggi']['std']);
                $prob_lila   = $this->gaussian($b->lila,   $stats['lila']['mean'],   $stats['lila']['std']);

                $likehood = $prob_berat * $prob_tinggi * $prob_lila * $stats['prior'];
                $results[$status] = round($likehood, 8);
            }

            $prediksi = collect($results)->sortDesc()->keys()->first();

            return [
                'nama'        => $b->nama,
                'status_asli' => $b->bb_tb,
                'likelihoods'   => $results,
                'prediksi'    => $prediksi,
            ];
        });

        // Hitung akurasi
        $jumlah_benar = $likelihoods->filter(fn($x) => $x['status_asli'] === $x['prediksi'])->count();
        $akurasi = $total > 0 ? round(($jumlah_benar / $total) * 100, 2) : 0;

        return view('perhitungan', compact('mean', 'stdDev', 'hasil', 'naive', 'likelihoods', 'akurasi'));
    }


}
