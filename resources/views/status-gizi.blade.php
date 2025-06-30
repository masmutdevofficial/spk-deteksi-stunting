@extends('layouts.main')

@section('content-header')
<div class="card col-12">
    <div class="card-header text-black">
        <h3 class="card-title">Statistik Status Gizi Balita per Bulan</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <canvas id="statusGiziLineChart" height="100"></canvas>
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
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('statusGiziLineChart').getContext('2d');

    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Gizi Baik',
                data: [12, 15, 14, 16, 18, 17, 19, 20, 21, 22, 23, 24],
                borderColor: '#22c55e',
                backgroundColor: '#22c55e',
                fill: false,
                tension: 0.3,
                pointStyle: 'circle',
                pointRadius: 5
            },
            {
                label: 'Gizi Kurang',
                data: [5, 4, 5, 4, 3, 2, 3, 4, 3, 2, 2, 1],
                borderColor: '#ef4444',
                backgroundColor: '#ef4444',
                fill: false,
                tension: 0.3,
                pointStyle: 'triangle',
                pointRadius: 5
            },
            {
                label: 'Gizi Lebih',
                data: [4, 5, 4, 5, 6, 6, 7, 6, 6, 5, 5, 5],
                borderColor: '#3b82f6',
                backgroundColor: '#3b82f6',
                fill: false,
                tension: 0.3,
                pointStyle: 'rect',
                pointRadius: 5
            }
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: false
                },
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Balita'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        }
    });
});
</script>
@endsection
