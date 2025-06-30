@extends('layouts.main')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Konsultasi</h3>
    </div>

    <div class="card-body">
        @if ($dataBayi->isEmpty())
            <div class="alert alert-warning text-center">
                <strong>Belum Ada Data Bayi. Silahkan Isi Data Bayi Terlebih Dahulu</strong>
            </div>
        @else
            <form>
                <div class="mb-3">
                    <label for="id_bayi">Pilih Nama Bayi</label>
                    <select id="id_bayi" class="form-control" onchange="isiFormBayi(this.value)">
                        <option value="">-- Pilih Bayi --</option>
                        @foreach ($dataBayi as $bayi)
                            <option value="{{ $bayi->id }}">{{ $bayi->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Umur</label>
                        <input type="text" id="umur" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin</label>
                        <input type="text" id="jenis_kelamin" class="form-control" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Berat (kg)</label>
                        <input type="text" id="berat" class="form-control" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Tinggi (cm)</label>
                        <input type="text" id="tinggi" class="form-control" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>LILA (cm)</label>
                        <input type="text" id="lila" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nilai BB/TB</label>
                        <input type="text" id="nilai_bb_tb" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Hasil BB/TB</label>
                        <input type="text" id="hasil_bb_tb" class="form-control" readonly>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
    const dataBayi = @json($dataBayi);

    function isiFormBayi(id) {
        const selected = dataBayi.find(item => item.id == id);

        if (selected) {
            document.getElementById('umur').value = selected.umur;
            document.getElementById('jenis_kelamin').value = selected.jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan';
            document.getElementById('berat').value = selected.berat;
            document.getElementById('tinggi').value = selected.tinggi;
            document.getElementById('lila').value = selected.lila;
            document.getElementById('nilai_bb_tb').value = selected.nilai_bb_tb;
            document.getElementById('hasil_bb_tb').value = selected.hasil_bb_tb;
        } else {
            document.querySelectorAll('input').forEach(input => input.value = '');
        }
    }
</script>
@endsection
