<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Jadwal Penimbangan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Jadwal Penimbangan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Lokasi Posyandu</th>
                <th>Tanggal Penimbangan</th>
                <th>Waktu</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->bulan }}</td>
                <td>{{ $d->lokasi_posyandu }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal_penimbangan)->format('d-m-Y') }}</td>
                <td>{{ $d->waktu }}</td>
                <td>{{ $d->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br><br>
    <div style="text-align: right;">
        <small>Dicetak: {{ now()->format('d-m-Y H:i') }}</small>
    </div>
</body>
</html>
