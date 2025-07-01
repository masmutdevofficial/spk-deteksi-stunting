<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Bayi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px 6px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Data Bayi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>JK</th>
                <th>Berat (kg)</th>
                <th>Tinggi (cm)</th>
                <th>LILA (cm)</th>
                <th>Status Gizi</th>
                <th>Tgl Penimbangan</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->umur }}</td>
                <td>{{ $d->jenis_kelamin == 1 ? 'L' : 'P' }}</td>
                <td>{{ number_format($d->berat,2) }}</td>
                <td>{{ number_format($d->tinggi,2) }}</td>
                <td>{{ number_format($d->lila,2) }}</td>
                <td>{{ $d->bb_tb }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tgl_penimbangan)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <br><br>
    <table style="width:100%; border:none;">
        <tr>
            <td style="border:none; text-align:right;">
                <small>Dicetak: {{ now()->format('d-m-Y H:i') }}</small>
            </td>
        </tr>
    </table>
</body>
</html>
