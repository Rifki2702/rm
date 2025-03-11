@extends('layout.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Obat Masuk</h4>
                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#tambahObat">
                                <i class="fa fa-plus"></i>
                                Tambah Obat
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Tabel Data Obat -->
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Distributor</th>
                                        <th>Harga</th>
                                        <th>Jumlah Stok</th>
                                        <th>Lokasi Stok</th>
                                        <th>Expired</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($obat as $o)
                                    <tr>
                                        <td>{{ $o->kode_obat }}</td>
                                        <td>{{ $o->nama_obat }}</td>
                                        <td>{{ $o->distributor->nama }}</td> <!-- Sesuaikan dengan nama kolom di tabel distributor -->
                                        <td>Rp {{ number_format($o->harga, 0, ',', '.') }}</td>
                                        <td>{{ $o->jumlah_stok }}</td>
                                        <td>{{ $o->lokasi_stok }}</td>
                                        <td>{{ date('d-m-Y', strtotime($o->tanggal_expired)) }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editObat{{ $o->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('obat-masuk.destroy', $o->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus obat ini?');">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Kode Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Distributor</th>
                                        <th>Harga</th>
                                        <th>Jumlah Stok</th>
                                        <th>Lokasi Stok</th>
                                        <th>Expired</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Obat -->
<div class="modal fade" id="tambahObat" tabindex="-1" aria-labelledby="tambahObatLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahObatLabel">Tambah Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('obat-masuk.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Obat</label>
                                <input type="text" name="kode_obat" class="form-control" value="OBT-{{ str_pad($obat->count() + 1, 4, '0', STR_PAD_LEFT) }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label>Nama Obat</label>
                                <input type="text" name="nama_obat" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Distributor</label>
                                <select name="distributor_id" class="form-control" required>
                                    @foreach($distributors as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option> <!-- Sesuaikan dengan nama kolom di tabel distributor -->
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Stok</label>
                                <input type="number" name="jumlah_stok" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Lokasi Stok</label>
                                <input type="text" name="lokasi_stok" class="form-control" value="Gudang Farmasi" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Expired</label>
                                <input type="date" name="tanggal_expired" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Obat -->
@foreach($obat as $o)
<div class="modal fade" id="editObat{{ $o->id }}" tabindex="-1" aria-labelledby="editObatLabel{{ $o->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editObatLabel{{ $o->id }}">Edit Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('obat-masuk.update', $o->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Obat</label>
                                <input type="text" name="kode_obat" class="form-control" value="{{ $o->kode_obat }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label>Nama Obat</label>
                                <input type="text" name="nama_obat" class="form-control" value="{{ $o->nama_obat }}" required>
                            </div>
                            <div class="form-group">
                                <label>Distributor</label>
                                <select name="distributor_id" class="form-control" required>
                                    @foreach($distributors as $d)
                                    <option value="{{ $d->id }}" {{ $o->distributor_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" name="harga" class="form-control" value="{{ $o->harga }}" required>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Stok</label>
                                <input type="number" name="jumlah_stok" class="form-control" value="{{ $o->jumlah_stok }}" required>
                            </div>
                            <div class="form-group">
                                <label>Lokasi Stok</label>
                                <input type="text" name="lokasi_stok" class="form-control" value="{{ $o->lokasi_stok }}" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Expired</label>
                                <input type="date" name="tanggal_expired" class="form-control" value="{{ $o->tanggal_expired }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Success Alert -->
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 2000,
            timerProgressBar: true
        });
    });
</script>
@endif

<!-- Error Alert -->
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Gagal!',
            text: "{{ session('error') }}",
            icon: 'error',
            timer: 2000,
            timerProgressBar: true
        });
    });
</script>
@endif

@endsection