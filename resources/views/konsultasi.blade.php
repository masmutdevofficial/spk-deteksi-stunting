@extends('layouts.main')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Konsultasi</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('data-bayi-medis.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_user" value="{{ auth()->id() }}">

            <div class="mb-3">
                <label>Nama Bayi</label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh : Bayi J" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control tgl-lahir" required>
            </div>

            <div class="mb-3">
                <label>Umur</label>
                <input type="text" name="umur" class="form-control umur-field" placeholder="Contoh : 2 Tahun - 1 Bulan - 5 Hari" readonly required>
            </div>

            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="1">Laki-laki</option>
                    <option value="2">Perempuan</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Berat (kg)</label>
                    <input type="number" step="0.01" name="berat" class="form-control" placeholder="Contoh : 10.40" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tinggi (cm)</label>
                    <input type="number" step="0.01" name="tinggi" class="form-control" placeholder="Contoh : 79.00" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>LILA (cm)</label>
                    <input type="number" step="0.01" name="lila" class="form-control" placeholder="Contoh : 15.00" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Tanggal Konsultasi</label>
                <input type="date" name="tgl_penimbangan" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
    </div>

</div>
@endsection

@section('bodyJs')
<script>
    function hitungUmur(tglLahir) {
        const tgl = new Date(tglLahir);
        const now = new Date();

        let tahun = now.getFullYear() - tgl.getFullYear();
        let bulan = now.getMonth() - tgl.getMonth();
        let hari = now.getDate() - tgl.getDate();

        if (hari < 0) {
            bulan--;
            const daysInLastMonth = new Date(now.getFullYear(), now.getMonth(), 0).getDate();
            hari += daysInLastMonth;
        }

        if (bulan < 0) {
            tahun--;
            bulan += 12;
        }

        return `${tahun} Tahun - ${bulan} Bulan - ${hari} Hari`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const tglInput = document.querySelector('.tgl-lahir');
        const umurField = document.querySelector('.umur-field');

        tglInput.addEventListener('change', function () {
            const umur = hitungUmur(this.value);
            umurField.value = umur;
        });
    });
</script>
@endsection
