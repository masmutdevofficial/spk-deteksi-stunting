@extends('layouts.main')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">Perhitungan Standar Deviasi Gizi</h3></div>
    <div class="card-body">

        <h5>Rata-rata & Standar Deviasi</h5>
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>Parameter</th><th>Mean (μ)</th><th>Std Dev (σ)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Berat</td><td>{{ number_format($mean['berat'], 5) }}</td><td>{{ number_format($stdDev['berat'], 5) }}</td></tr>
                <tr><td>Tinggi</td><td>{{ number_format($mean['tinggi'], 5) }}</td><td>{{ number_format($stdDev['tinggi'], 5) }}</td></tr>
                <tr><td>LILA</td><td>{{ number_format($mean['lila'], 5) }}</td><td>{{ number_format($stdDev['lila'], 5) }}</td></tr>
            </tbody>
        </table>

        <h5>Detail Per Bayi</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th rowspan="2">Nama</th>
                    <th colspan="3" class="text-center">Berat</th>
                    <th colspan="3" class="text-center">Tinggi</th>
                    <th colspan="3" class="text-center">LILA</th>
                </tr>
                <tr>
                    <th>x</th><th>x - μ</th><th>(x - μ)²</th>
                    <th>x</th><th>x - μ</th><th>(x - μ)²</th>
                    <th>x</th><th>x - μ</th><th>(x - μ)²</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hasil as $h)
                <tr>
                    <td>{{ $h['nama'] }}</td>
                    <td>{{ $h['berat'] }}</td>
                    <td>{{ $h['berat_selisih'] }}</td>
                    <td>{{ $h['berat_kuadrat'] }}</td>

                    <td>{{ $h['tinggi'] }}</td>
                    <td>{{ $h['tinggi_selisih'] }}</td>
                    <td>{{ $h['tinggi_kuadrat'] }}</td>

                    <td>{{ $h['lila'] }}</td>
                    <td>{{ $h['lila_selisih'] }}</td>
                    <td>{{ $h['lila_kuadrat'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
