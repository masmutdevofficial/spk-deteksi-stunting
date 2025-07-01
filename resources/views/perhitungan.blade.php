@extends('layouts.main')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">Perhitungan Standar Deviasi Gizi</h3></div>
    <div class="card-body">

    @verbatim
    <p><strong>Penjelasan:</strong> Halaman ini menunjukkan proses perhitungan deteksi status gizi anak menggunakan <u>algoritma Gaussian Naive Bayes</u>.</p>

    <ul>
        <li><strong>Mean (\( \mu \)):</strong> Rata-rata dari semua nilai, dihitung dengan rumus:
            \[
            \mu = \frac{\sum x}{n}
            \]
        </li>

        <li><strong>Standar Deviasi (\( \sigma \)):</strong> Mengukur penyebaran data terhadap nilai rata-rata:
            \[
            \sigma = \sqrt{ \frac{ \sum (x - \mu)^2 }{n - 1} }
            \]
        </li>

        <li><strong>Prior Probability:</strong> Probabilitas awal bahwa data termasuk dalam suatu kelas tertentu:
            \[
            P(C) = \frac{\text{Jumlah Data di Kelas } C}{\text{Total Data}}
            \]
        </li>

        <li><strong>Likelihood:</strong> Probabilitas suatu data termasuk dalam kelas tertentu berdasarkan distribusi Gaussian:
            \[
            f(x) = \frac{1}{\sqrt{2\pi\sigma^2}} \cdot e^{ -\frac{(x - \mu)^2}{2\sigma^2} }
            \]
        </li>

        <li><strong>Akurasi Klasifikasi:</strong> Mengukur seberapa banyak prediksi yang sesuai:
            \[
            \text{Akurasi} = \left( \frac{\text{Jumlah Prediksi Benar}}{\text{Total Data}} \right) \times 100\%
            \]
        </li>
    </ul>
    @endverbatim



        <hr>

        <h5>Detail Standar Deviasi (Per Bayi)</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th rowspan="2">Nama</th>
                    <th colspan="3" class="text-center">Berat</th>
                    <th colspan="3" class="text-center">Tinggi</th>
                    <th colspan="3" class="text-center">LILA</th>
                    <th rowspan="2">BB/TB</th>
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
                    <td>{{ $h['bb_tb'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Detail Tabel Per Bayi:</strong> Tabel berikut menampilkan selisih nilai setiap atribut terhadap rata-ratanya dan hasil kuadrat selisih tersebut. Rumus standar deviasi:</p>
        <ul>
            <li><code>σ = √(Σ(x - μ)² / (n - 1))</code></li>
        </ul>

        <h5 class="mt-4">Rata-rata & Standar Deviasi</h5>
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

        <hr>

        <p><strong>Statistik Per Kelas:</strong> Nilai rata-rata dan standar deviasi dihitung untuk setiap kelas status gizi ('Gizi Baik', 'Gizi Kurang', dan 'Gizi Lebih') secara terpisah.</p>
        <p><strong>Prior Probability:</strong> Perbandingan jumlah data pada tiap kelas terhadap total data.
        <code>Prior = jumlah_kelas / total_data</code></p>

        <h5 class="mt-4">Statistik Naive Bayes</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status Gizi</th>
                    <th>Berat (μ / σ)</th>
                    <th>Tinggi (μ / σ)</th>
                    <th>LILA (μ / σ)</th>
                    <th>Prior</th>
                </tr>
            </thead>
            <tbody>
                @foreach($naive as $status => $st)
                <tr>
                    <td>{{ $status }}</td>
                    <td>{{ number_format($st['berat']['mean'],2) }} /
                        {{ number_format($st['berat']['std'],2) }}</td>
                    <td>{{ number_format($st['tinggi']['mean'],2) }} /
                        {{ number_format($st['tinggi']['std'],2) }}</td>
                    <td>{{ number_format($st['lila']['mean'],2) }} /
                        {{ number_format($st['lila']['std'],2) }}</td>
                    <td>{{ number_format($st['prior'],2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        <p class="mt-4"><strong>Proses Klasifikasi:</strong> Setiap anak dihitung nilai kemungkinan (Likelihood) masuk ke masing-masing kategori status gizi berdasarkan atribut <strong>berat</strong>, <strong>tinggi</strong>, dan <strong>lila</strong>. Prediksi ditentukan berdasarkan nilai Likelihood tertinggi.</p>

        <h5 class="mt-4">Hasil Klasifikasi Naive Bayes (Likelihood per Anak)</h5>
        @foreach ($likelihoods as $item)
        <div class="mb-3">
            <strong>{{ $item['nama'] }}</strong>
            <br>Status Asli: <b>{{ $item['status_asli'] }}</b><br>
            Prediksi: <b>{{ $item['prediksi'] }}</b>

            @if ($item['status_asli'] === $item['prediksi'])
                <span class="text-success font-weight-bold">✓ Sesuai</span>
            @else
                <span class="text-danger font-weight-bold">✗ Tidak Sesuai</span>
            @endif

            <table class="table table-bordered table-striped mt-2">
                <thead>
                    <tr>
                        <th>Status Gizi</th>
                        <th>Likelihood</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item['likelihoods'] as $status => $val)
                    <tr>
                        <td>{{ $status }}</td>
                        <td>{{ number_format($val, 8) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

        <p><strong>Akurasi:</strong> Akurasi didapatkan dari perbandingan jumlah prediksi yang benar terhadap total data.
        <code>Akurasi = (jumlah_prediksi_benar / total_data) * 100%</code></p>

        <div class="alert alert-info mt-3">
            <strong>Akurasi Prediksi:</strong> {{ $akurasi }}%
        </div>

    </div>
</div>
@endsection
