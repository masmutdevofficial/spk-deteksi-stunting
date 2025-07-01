<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataBayi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'tgl_penimbangan' => 'required|date',
        ]);

        // Cek duplikat berdasarkan nama dan tanggal penimbangan
        $cek = DataBayi::whereDate('tgl_penimbangan', $request->tgl_penimbangan)
                       ->where('nama', 'like', '%' . $request->nama . '%')
                       ->exists();

        if ($cek) {
            return redirect()->back()->with('error' , 'Bayi sudah dilakukan penimbangan pada tgl tersebut.');
        }

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
            'tgl_penimbangan' => 'required|date',
        ]);

        // Cek duplikat selain dirinya sendiri
        $cek = DataBayi::whereDate('tgl_penimbangan', $request->tgl_penimbangan)
                       ->where('nama', 'like', '%' . $request->nama . '%')
                       ->where('id', '!=', $id)
                       ->exists();

        if ($cek) {
            return redirect()->back()->with('error' , 'Bayi sudah dilakukan penimbangan pada tgl tersebut.');
        }

        $data->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function storeMedis(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'nama' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required|in:1,2',
            'berat' => 'required|numeric',
            'tinggi' => 'required|numeric',
            'lila' => 'required|numeric',
            'tgl_penimbangan' => 'required|date',
        ]);

        // Cek duplikat berdasarkan nama dan tanggal
        $cek = DataBayi::whereDate('tgl_penimbangan', $request->tgl_penimbangan)
                       ->where('nama', 'like', '%' . $request->nama . '%')
                       ->exists();

        if ($cek) {
            return redirect()->back()->with('error', 'Bayi sudah dilakukan penimbangan pada tgl tersebut.');
        }

        // Ambil semua data untuk statistik
        $all = DataBayi::all();
        $total = $all->count();

        // Hitung statistik per kelas
        $naive = $all->groupBy('bb_tb')->map(function ($grp) use ($total) {
            $cnt = $grp->count();
            $prior = $cnt / $total;

            $stat = [];
            foreach (['berat','tinggi','lila'] as $f) {
                $mean = $grp->avg($f);
                $std = sqrt($grp->pluck($f)->map(fn($v) => pow($v - $mean, 2))->sum() / ($cnt - 1 ?: 1));
                $std = max($std, 1.0); // fallback
                $stat[$f] = ['mean' => $mean, 'std' => $std];
            }

            return [
                'prior' => $prior,
                'berat' => $stat['berat'],
                'tinggi'=> $stat['tinggi'],
                'lila'  => $stat['lila'],
            ];
        });

        // Hitung likelihood untuk input baru
        $berat = $request->berat;
        $tinggi = $request->tinggi;
        $lila = $request->lila;

        $gaussian = function($x, $mean, $std) {
            if ($std == 0) return 0;
            $exponent = exp(-pow($x - $mean, 2) / (2 * pow($std, 2)));
            return (1 / (sqrt(2 * pi()) * $std)) * $exponent;
        };

        $likelihoods = [];
        foreach ($naive as $status => $stats) {
            $p_berat  = $gaussian($berat,  $stats['berat']['mean'],  $stats['berat']['std']);
            $p_tinggi = $gaussian($tinggi, $stats['tinggi']['mean'], $stats['tinggi']['std']);
            $p_lila   = $gaussian($lila,   $stats['lila']['mean'],   $stats['lila']['std']);

            $likelihoods[$status] = $p_berat * $p_tinggi * $p_lila * $stats['prior'];
        }

        // Ambil status gizi dengan likelihood tertinggi
        $bb_tb = collect($likelihoods)->sortDesc()->keys()->first();

        // Simpan ke database
        $bayi = DataBayi::create([
            'id_user' => $request->id_user,
            'nama' => $request->nama,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'berat' => $berat,
            'tinggi' => $tinggi,
            'lila' => $lila,
            'tgl_penimbangan' => $request->tgl_penimbangan,
            'bb_tb' => $bb_tb,
        ]);

        return redirect('/hasil-deteksi?id=' . $bayi->id);
    }

    public function hasilDeteksi(Request $request)
    {
        $bayi = DataBayi::findOrFail($request->id);
        $namaBayi = $bayi->nama;

        // Ambil semua data kecuali data yang sedang dianalisis (agar tidak bias)
        $dataLain = DataBayi::where('id', '!=', $bayi->id)->get();
        $total = $dataLain->count();

        // Hitung statistik per kelas
        $naive = $dataLain->groupBy('bb_tb')->map(function ($grp) use ($total) {
            $cnt = $grp->count();
            $prior = $cnt / ($total ?: 1); // hindari divide by zero

            $stat = [];
            foreach (['berat', 'tinggi', 'lila'] as $f) {
                $mean = $grp->avg($f);
                $std = sqrt($grp->pluck($f)->map(fn($v) => pow($v - $mean, 2))->sum() / ($cnt - 1 ?: 1));
                $std = max($std, 1.0); // fallback std dev agar tidak 0
                $stat[$f] = ['mean' => $mean, 'std' => $std];
            }

            return [
                'prior'  => $prior,
                'berat'  => $stat['berat'],
                'tinggi' => $stat['tinggi'],
                'lila'   => $stat['lila'],
            ];
        });

        // Hitung likelihood
        $gaussian = function ($x, $mean, $std) {
            if ($std == 0) return 0;
            $exponent = exp(-pow($x - $mean, 2) / (2 * pow($std, 2)));
            return (1 / (sqrt(2 * pi()) * $std)) * $exponent;
        };

        $likelihoods = [];
        foreach ($naive as $status => $stats) {
            $p_berat = $gaussian($bayi->berat,  $stats['berat']['mean'],  $stats['berat']['std']);
            $p_tinggi = $gaussian($bayi->tinggi, $stats['tinggi']['mean'], $stats['tinggi']['std']);
            $p_lila = $gaussian($bayi->lila,  $stats['lila']['mean'],  $stats['lila']['std']);

            $likelihoods[$status] = $p_berat * $p_tinggi * $p_lila * $stats['prior'];
        }

        // Tentukan prediksi status dari likelihood tertinggi
        $prediksi = collect($likelihoods)->sortDesc()->keys()->first();

        /* ===== data untuk grafik bar ===== */
        $chartLabels = array_keys($likelihoods);  // ['Gizi Baik', 'Gizi Kurang', 'Gizi Lebih']
        $chartData   = array_values($likelihoods); // [0.00083246, 0.00000253, 0.00007805]

        return view('hasil-deteksi', [
            'bayi'        => $bayi,
            'likelihoods' => $likelihoods,
            'prediksi'    => $prediksi,
            'chartLabels' => $chartLabels,
            'chartData'   => $chartData,
            'namaBayi'    => $bayi->nama,
        ]);
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

    public function cetakLaporanPdf()
    {
        $data  = DataBayi::with('user')->get();
        $users = User::where('level', 1)->get();

        // view 'laporan-bayi-pdf' akan dirender jadi PDF
        $pdf = Pdf::loadView('laporan-bayi-pdf', compact('data','users'))
                  ->setPaper('a4', 'landscape');   // optional orientation

        return $pdf->download('laporan-bayi.pdf');
    }

}
