@extends('layouts.main')

@section('content')
<div class="card shadow">
    <div class="card-header bg-secondary text-white text-center">
        <h5 class="mb-0">PENANGANAN</h5>
    </div>
    <div class="card-body">
        <div class="bg-light p-4 rounded">

            <form action="{{ route('penanganan.store') }}" method="POST">
                @csrf

                <input type="hidden" name="id_bayi" value="{{ request('id') }}">

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="keterangan[]" value="Pemantauan pertumbuhan berkala" id="check1">
                    <label class="form-check-label" for="check1">
                        Pemantauan pertumbuhan berkala
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="keterangan[]" value="Pemberian Suplementasi dan vitamin" id="check2">
                    <label class="form-check-label" for="check2">
                        Pemberian Suplementasi dan vitamin
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="keterangan[]" value="Konseling perkembangan anak" id="check3">
                    <label class="form-check-label" for="check3">
                        Konseling perkembangan anak
                    </label>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Penanganan</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
