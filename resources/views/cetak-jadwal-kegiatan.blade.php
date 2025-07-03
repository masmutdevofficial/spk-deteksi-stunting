<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Jadwal Kegiatan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Jadwal Kegiatan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Kegiatan</th>
                <th>Sasaran</th>
                <th>Pelaksana</th>
                <th>Catatan Tambahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->bulan }}</td>
                <td>{{ $d->kegiatan }}</td>
                <td>{{ $d->sasaran }}</td>
                <td>{{ $d->pelaksana }}</td>
                <td>{{ $d->catatan_tambahan }}</td>
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
