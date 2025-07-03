@extends('layouts.main')

@section('customCss')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Tabler Icons -->
<link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler.min.css') }}">
@endsection

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Data Bayi</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Data Bayi</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Data Bayi</h3>
            <div class="d-flex flex-col justify-content-between align-items-center">
                <a href="perhitungan" class="btn btn-primary mr-2">
                    <i class="fa fa-calculator mr-2"></i>Lihat Perhitungan
                </a>
                <a href="/cetak-laporan-pdf" class="btn btn-secondary mr-2">
                    <i class="fa fa-print mr-2"></i>Cetak Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="basicTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>Jenis Kelamin</th>
                    <th>Berat</th>
                    <th>Tinggi</th>
                    <th>LILA</th>
                    <th>BB/TB</th>
                    <th>Tanggal Penimbangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $d)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->umur }}</td>
                    <td>{{ $d->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $d->berat }}</td>
                    <td>{{ $d->tinggi }}</td>
                    <td>{{ $d->lila }}</td>
                    <td>{{ $d->bb_tb }}</td>
                    <td>{{ $d->tgl_penimbangan }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="cetak-detail-bayi?id={{ $d->id }}" class="btn btn-sm btn-secondary mr-2">
                                <i class="fa fa-print mr-1"></i>Cetak
                            </a>
                            <button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#modalEdit{{ $d->id }}">
                                <i class="fa fa-edit mr-1"></i>Edit
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus{{ $d->id }}">
                                <i class="fa fa-trash mr-1"></i>Hapus
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $d->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ url('data-bayi/' . $d->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data Bayi</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text" name="nama" value="{{ $d->nama }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" value="{{ $d->tgl_lahir }}" class="form-control tgl-lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Umur</label>
                                        <input type="text" name="umur" value="{{ $d->umur }}" class="form-control umur-field" readonly required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control">
                                            <option value="1" {{ $d->jenis_kelamin == 1 ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="2" {{ $d->jenis_kelamin == 2 ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Berat (kg)</label>
                                        <input type="number" step="0.01" name="berat" value="{{ $d->berat }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tinggi (cm)</label>
                                        <input type="number" step="0.01" name="tinggi" value="{{ $d->tinggi }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>LILA (cm)</label>
                                        <input type="number" step="0.01" name="lila" value="{{ $d->lila }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>BB/TB</label>
                                        <select name="bb_tb" class="form-control">
                                            <option value="Gizi Baik" {{ $d->bb_tb === 'Gizi Baik' ? 'selected' : '' }}>Gizi Baik</option>
                                            <option value="Gizi Kurang" {{ $d->bb_tb === 'Gizi Kurang' ? 'selected' : '' }}>Gizi Kurang</option>
                                            <option value="Gizi Lebih" {{ $d->bb_tb === 'Gizi Lebih' ? 'selected' : '' }}>Gizi Lebih</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tanggal Penimbangan</label>
                                        <input type="date" name="tgl_penimbangan" value="{{ $d->tgl_penimbangan }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tenaga Medis</label>
                                        <select name="id_user" class="form-control">
                                            @foreach($users as $u)
                                            <option value="{{ $u->id }}" {{ $d->id_user == $u->id ? 'selected' : '' }}>{{ $u->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Update</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus{{ $d->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ url('data-bayi/' . $d->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    Yakin ingin menghapus data <strong>{{ $d->nama }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('customJs')
<!-- DataTables & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endsection

@section('bodyJs')
<script>
  $(function () {
    $("#basicTable").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "lengthMenu": [ [5, 10, 25, 50, 100], [5, 10, 25, 50, 100] ]
    });
  });
</script>
<script>
    function hitungUmur(tanggalLahir) {
        const tglLahir = new Date(tanggalLahir);
        const sekarang = new Date();

        let tahun = sekarang.getFullYear() - tglLahir.getFullYear();
        let bulan = sekarang.getMonth() - tglLahir.getMonth();
        let hari = sekarang.getDate() - tglLahir.getDate();

        if (hari < 0) {
            bulan -= 1;
            hari += new Date(sekarang.getFullYear(), sekarang.getMonth(), 0).getDate(); // ambil jumlah hari di bulan sebelumnya
        }

        if (bulan < 0) {
            tahun -= 1;
            bulan += 12;
        }

        return `${tahun} Tahun - ${bulan} Bulan - ${hari} Hari`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.tgl-lahir').forEach(function (input) {
            input.addEventListener('change', function () {
                const umurField = this.closest('.modal-body').querySelector('.umur-field');
                const umur = hitungUmur(this.value);
                if (umurField) {
                    umurField.value = umur;
                }
            });
        });
    });
</script>
@endsection
