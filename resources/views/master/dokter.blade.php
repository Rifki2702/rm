@extends('layout.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Tenaga Kesehatan</h4>
                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addDokterModal">
                                <i class="fa fa-plus"></i> Tambah Dokter
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="basic-datatables" class="display table table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Spesialis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dokters as $dokter)
                                <tr>
                                    <td>{{ $dokter->id }}</td>
                                    <td>{{ $dokter->nama }}</td>
                                    <td>{{ $dokter->poli }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editDokterModal" data-id="{{ $dokter->id }}" data-nama="{{ $dokter->nama }}" data-spesialis="{{ $dokter->poli }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <form id="delete-form-{{ $dokter->id }}" action="{{ route('dokter.delete', $dokter->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger deleteDokter" data-id="{{ $dokter->id }}" data-nama="{{ $dokter->nama }}">
                                                <i class="fa fa-trash"></i> Hapus
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

<!-- Add Dokter Modal -->
<div class="modal fade" id="addDokterModal" tabindex="-1" aria-labelledby="addDokterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('dokter.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDokterModalLabel">Tambah Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="poli" class="form-label">Poli</label>
                        <select class="form-control" name="poli" required>
                            <option value="Umum">Umum</option>
                            <option value="Gigi">Gigi</option>
                            <option value="Bidan">Bidan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

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
            timer: 5000,
            timerProgressBar: true
        });
    });
</script>
@endif

<script>
    // Fungsi untuk konfirmasi penghapusan
    function confirmDeletion(id, namaDokter) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Anda akan menghapus dokter atas nama "${namaDokter}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form penghapusan
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    // Event listener for delete button
    document.querySelectorAll('.deleteDokter').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const namaDokter = this.getAttribute('data-nama');
            confirmDeletion(id, namaDokter);
        });
    });

    // Fungsi untuk mencetak iframe
    function printIframe(id) {
        const iframe = document.getElementById(id);
        iframe.contentWindow.print();
    }
</script>
@endsection
