@extends('layouts.main')

{{-- ===================== CONTENT ===================== --}}
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">Hasil Deteksi Status Gizi</h3></div>

    <div class="card-body">
        {{-- ---------- INFO BAYI ---------- --}}
        <h5>Informasi Bayi</h5>
        <ul>
            <li><strong>Nama:</strong> {{ $bayi->nama }}</li>
            <li><strong>Umur:</strong> {{ $bayi->umur }}</li>
            <li><strong>Berat:</strong> {{ $bayi->berat }} kg</li>
            <li><strong>Tinggi:</strong> {{ $bayi->tinggi }} cm</li>
            <li><strong>LILA:</strong> {{ $bayi->lila }} cm</li>
            <li><strong>Status Tersimpan:</strong> {{ $bayi->bb_tb }}</li>
            <li><strong>Prediksi (Likelihood Tertinggi):</strong> {{ $prediksi }}</li>
        </ul>

        <hr>

        {{-- ---------- TABEL LIKELIHOOD ---------- --}}
        <h5>Likelihood Tiap Kategori</h5>
        <table class="table table-bordered">
            <thead><tr><th>Status Gizi</th><th>Nilai Likelihood</th></tr></thead>
            <tbody>
            @foreach ($likelihoods as $status => $val)
                <tr>
                    <td>{{ $status }}</td>
                    <td>{{ number_format($val, 8) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-2">
            @if ($bayi->bb_tb === $prediksi)
                <span class="text-success font-weight-bold">✓ Prediksi Sesuai</span>
            @else
                <span class="text-danger font-weight-bold">✗ Prediksi Tidak Sesuai</span>
            @endif
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Hasil Deteksi Probabilitas Status Gizi</h3>
    </div>
</div>

{{-- ---------- GRAFIK BAR ---------- --}}
<div class="card shadow-sm mt-4">
    <div class="card-body">
        <canvas id="statusGiziLineChart" height="100"></canvas>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">Tindakan Selanjutnya</h3>
    </div>
    <div class="card-body">
        <p>Untuk melihat saran atau penanganan lebih lanjut berdasarkan status gizi, silakan klik tombol berikut:</p>
        <a href="{{ url('/penanganan?id=' . $bayi->id) }}" class="btn btn-primary">
            Lihat Penanganan
        </a>
    </div>
</div>
@endsection


{{-- ===================== SCRIPTS ===================== --}}
@section('customJs')
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
@endsection

@section('bodyJs')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('statusGiziLineChart').getContext('2d');

    const data = {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Nilai Likelihood',
            data: {!! json_encode($chartData) !!},
            backgroundColor: ['#22c55e', '#ef4444', '#3b82f6'],
            borderColor: ['#16a34a', '#dc2626', '#2563eb'],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Likelihood Status Gizi: {{ $namaBayi }}'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nilai Likelihood'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Status Gizi'
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>
@endsection

