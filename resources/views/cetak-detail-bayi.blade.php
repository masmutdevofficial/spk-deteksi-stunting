<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data {{ $bayi->nama }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Hasil Perhitungan Data {{ $bayi->nama }}</h3>

    <p><strong>Nama:</strong> {{ $bayi->nama }}</p>
    <p><strong>Tanggal Lahir:</strong> {{ $bayi->tgl_lahir }}</p>
    <p><strong>Umur:</strong> {{ $bayi->umur }}</p>
    <p><strong>Berat:</strong> {{ $bayi->berat }} kg</p>
    <p><strong>Tinggi:</strong> {{ $bayi->tinggi }} cm</p>
    <p><strong>LILA:</strong> {{ $bayi->lila }} cm</p>
    <p><strong>Tanggal Penimbangan:</strong> {{ \Carbon\Carbon::parse($bayi->tgl_penimbangan)->format('d-m-Y') }}</p>

    <h4>Perhitungan Probabilitas</h4>
    <table>
        <thead>
            <tr>
                <th>Status Gizi</th>
                <th>Probabilitas</th>
            </tr>
        </thead>
        <tbody>
        @foreach($likelihoods as $status => $prob)
            <tr>
                <td>{{ $status }}</td>
                <td>{{ number_format($prob, 10, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p><strong>Hasil Prediksi:</strong> {{ $prediksi }}</p>

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
