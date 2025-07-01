<?php

namespace App\Http\Controllers;

use App\Models\DataBayi;
use Illuminate\Http\Request;

class StatusGiziController extends Controller
{
    public function index() {
        // ── Inisialisasi label bulan ───────────────────────────────
        $monthLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        // Status yang kita pakai (pastikan sama persis dgn isi kolom bb_tb)
        $statusList = ['Gizi Baik','Gizi Kurang','Gizi Lebih'];

        // Siapkan array kosong 12 bulan × 3 status
        $counts = [];
        foreach ($statusList as $s) {
            $counts[$s] = array_fill(0, 12, 0);   // [0,0,0, …]
        }

        // ── Query jumlah per bulan per status gizi ────────────────
        $rows = DataBayi::selectRaw('MONTH(tgl_penimbangan) as bln, bb_tb, COUNT(*) as total')
                    ->groupByRaw('MONTH(tgl_penimbangan), bb_tb')
                    ->get();

        foreach ($rows as $row) {
            $idx = $row->bln - 1;                      // 0-based index
            $status = $row->bb_tb;
            if (isset($counts[$status][$idx])) {
                $counts[$status][$idx] = (int) $row->total;
            }
        }

        /* ── Persiapkan dataset Chart.js ─────────────────────────── */
        $datasets = [
            [
                'label' => 'Gizi Baik',
                'data'  => $counts['Gizi Baik'],
                'borderColor' => '#22c55e',
                'backgroundColor' => '#22c55e',
                'fill' => false,
                'tension' => 0.3,
                'pointStyle' => 'circle',
                'pointRadius' => 5,
            ],
            [
                'label' => 'Gizi Kurang',
                'data'  => $counts['Gizi Kurang'],
                'borderColor' => '#ef4444',
                'backgroundColor' => '#ef4444',
                'fill' => false,
                'tension' => 0.3,
                'pointStyle' => 'triangle',
                'pointRadius' => 5,
            ],
            [
                'label' => 'Gizi Lebih',
                'data'  => $counts['Gizi Lebih'],
                'borderColor' => '#3b82f6',
                'backgroundColor' => '#3b82f6',
                'fill' => false,
                'tension' => 0.3,
                'pointStyle' => 'rect',
                'pointRadius' => 5,
            ],
        ];

        return view('status-gizi', [
            'monthLabels' => $monthLabels,
            'datasets'    => $datasets,
        ]);
    }
}
