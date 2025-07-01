@extends('layouts.main')

@section('content-header')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Statistik Status Gizi Balita per Bulan</h3>
    </div>
</div>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <canvas id="statusGiziLineChart" height="90"></canvas>
                <button id="downloadChart" class="btn btn-success mt-3"> Cetak Laporan Grafik</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('customJs')
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
@endsection


@section('bodyJs')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('statusGiziLineChart').getContext('2d');

        const data = {
            labels: {!! json_encode($monthLabels) !!},
            datasets: {!! json_encode($datasets) !!}
        };

        const chart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                interaction: { mode: 'nearest', axis: 'x', intersect: false },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Balita' }
                    },
                    x: {
                        title: { display: true, text: 'Bulan' }
                    }
                }
            }
        });

        // Tombol download
        document.getElementById('downloadChart').addEventListener('click', function () {
            const link = document.createElement('a');
            link.href = document.getElementById('statusGiziLineChart').toDataURL('image/png');
            link.download = 'statistik-status-gizi.png';
            link.click();
        });
    });
    </script>
@endsection
