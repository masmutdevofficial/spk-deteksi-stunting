<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Penanganan Gizi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Data Penanganan Gizi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bayi</th>
                <th>Tanggal Konsultasi</th>
                <th>Status Gizi</th>
                <th>Saran Penanganan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataBayi as $index => $bayi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bayi->nama }}</td>
                    <td>{{ $bayi->tgl_penimbangan ?? '-' }}</td>
                    <td>{{ $bayi->bb_tb ?? '-' }}</td>
                    <td>{{ $bayi->penanganan->keterangan ?? '-' }}</td>
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
