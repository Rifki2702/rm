@extends('layout.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Pasien Poli Umum</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="add-row" class="display table table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Usia</th>
                                    <th>Jenis Pasien</th>
                                    <th>No RM</th>
                                    <th>Diagnosis</th>
                                    <th>Alamat</th>
                                    <th>Pembiayaan</th>
                                    <th>Dokter</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kunjungan as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->tanggal_kunjungan }}</td>
                                    <td>{{ $data->pasien->nama }}</td>
                                    <td>{{ $data->pasien->jenis_kelamin }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->pasien->tanggal_lahir)->age }}</td>
                                    <td>{{ $data->jenis_pasien }}</td>
                                    <td>{{ $data->pasien->no_rm }}</td>
                                    <td>{{ $data->diagnosis }}</td>
                                    <td>{{ $data->pasien->alamat }}</td>
                                    <td>{{ $data->pembiayaan }}</td>
                                    <td>{{ $data->dokter->nama }}</td>
                                    <td>
                                        <!-- Tombol Edit Kunjungan -->
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $data->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <form id="delete-form-{{ $data->id }}" action="{{ route('poli-umum.delete', $data->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeletion({{ $data->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit Kunjungan -->
@foreach($kunjungan as $data)
<div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('poli-umum.edit', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                                <input type="date" name="tanggal_kunjungan" class="form-control" value="{{ $data->tanggal_kunjungan }}" required>
                            </div>
                            <div class="form-group">
                                <label for="jenis_pasien">Jenis Pasien</label>
                                <select name="jenis_pasien" class="form-control" required>
                                    <option value="Baru" {{ $data->jenis_pasien == 'Baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="Lama" {{ $data->jenis_pasien == 'Lama' ? 'selected' : '' }}>Lama</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="diagnosis">Diagnosis</label>
                                <input type="text" name="diagnosis" class="form-control" value="{{ $data->diagnosis }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pembiayaan">Pembiayaan</label>
                                <select name="pembiayaan" class="form-control" required>
                                    <option value="BPJS" {{ $data->pembiayaan == 'BPJS' ? 'selected' : '' }}>BPJS</option>
                                    <option value="Umum" {{ $data->pembiayaan == 'Umum' ? 'selected' : '' }}>Umum</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dokter_id">Dokter</label>
                                <select name="dokter_id" class="form-control" required>
                                    @foreach($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" {{ old('dokter_id', $data->dokter_id) == $dokter->id ? 'selected' : '' }}>{{ $dokter->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        timer: 2000,
        timerProgressBar: true
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Gagal!',
        text: "{{ session('error') }}",
        icon: 'error',
        timer: 2000,
        timerProgressBar: true
    });
</script>
@endif

<script>
    function confirmDeletion(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data kunjungan akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection