@extends('layout.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Pasien</h4>
                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addPasienModal">
                                <i class="fa fa-plus"></i> Tambah Pasien
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('pasien.search') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="no_rm" placeholder="Cari berdasarkan No RM" value="{{ request('no_rm') }}">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="nama" placeholder="Cari berdasarkan Nama" value="{{ request('nama') }}">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="alamat" placeholder="Cari berdasarkan Alamat" value="{{ request('alamat') }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Modal Tambah -->
                        <div class="modal fade" id="addPasienModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Tambah Pasien</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('pasien.tambah') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" name="nama" required maxlength="100">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No RM</label>
                                                        <input type="text" class="form-control" name="no_rm" required maxlength="100">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="tanggal_lahir" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <input type="text" class="form-control" name="alamat" required maxlength="255">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select class="form-control" name="jenis_kelamin" required>
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Simpan
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                <i class="fa fa-times"></i> Tutup
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Tambah Kunjungan -->
                        <div class="modal fade" id="addKunjunganModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Tambah Kunjungan</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center">
                                            <div class="d-flex flex-wrap">
                                                <div class="p-2">
                                                    <button class="btn btn-primary" style="background-color: #007bff;" onclick="redirectToKunjunganForm()">
                                                        <i class="fa fa-stethoscope"></i> Poli Umum
                                                    </button>
                                                </div>
                                                <div class="p-2">
                                                    <button class="btn btn-success" style="background-color: #28a745;" onclick="">
                                                        <i class="fa fa-tooth"></i> Poli Gigi
                                                    </button>
                                                </div>
                                                <div class="p-2">
                                                    <button class="btn btn-warning" style="background-color: #ffc107;" onclick="">
                                                        <i class="fa fa-baby"></i> Poli KIA
                                                    </button>
                                                </div>
                                                <div class="p-2">
                                                    <button class="btn btn-danger" style="background-color: #dc3545;" onclick="">
                                                        <i class="fa fa-hospital"></i> Rawat Inap
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editPasienModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Edit Pasien</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="editPasienForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" id="editPasienId">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" name="nama" id="editPasienName" required maxlength="100">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No RM</label>
                                                        <input type="text" class="form-control" name="no_rm" id="editPasienNoRM" required maxlength="100">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="tanggal_lahir" id="editPasienTanggalLahir" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <input type="text" class="form-control" name="alamat" id="editPasienAlamat" required maxlength="255">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select class="form-control" name="jenis_kelamin" id="editPasienJenisKelamin" required>
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-refresh"></i> Update
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                <i class="fa fa-times"></i> Tutup
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if(request()->has('no_rm') || request()->has('nama') || request()->has('alamat'))
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover">
                                <thead>
                                    <tr class="justify-content-center">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">No RM</th>
                                        <th class="text-center">Tanggal Lahir</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Jenis Kelamin</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasien as $key => $p)
                                    <tr class="justify-content-center">
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-center">{{ $p->nama }}</td>
                                        <td class="text-center">{{ $p->no_rm }}</td>
                                        <td class="text-center">{{ $p->tanggal_lahir }}</td>
                                        <td class="text-center">{{ $p->alamat }}</td>
                                        <td class="text-center">{{ $p->jenis_kelamin }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-warning btn-sm" onclick="editPasien({{ $p->id }}, '{{ $p->nama }}', '{{ $p->no_rm }}', '{{ $p->tanggal_lahir }}', '{{ $p->alamat }}', '{{ $p->jenis_kelamin }}')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form id="deleteForm-{{ $p->id }}" action="{{ route('pasien.delete', $p->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDeletion({{ $p->id }})">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addKunjunganModal" onclick="setSelectedPasienId({{ $p->id }})">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                text: "Data pasien akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + id).submit();
                }
            });
        }

        function editPasien(id, name, no_rm, tanggal_lahir, alamat, jenis_kelamin) {
            document.getElementById('editPasienId').value = id;
            document.getElementById('editPasienName').value = name;
            document.getElementById('editPasienNoRM').value = no_rm;
            document.getElementById('editPasienTanggalLahir').value = tanggal_lahir;
            document.getElementById('editPasienAlamat').value = alamat;
            document.getElementById('editPasienJenisKelamin').value = jenis_kelamin;
            document.getElementById('editPasienForm').action = "/pasien/" + id;
            var modal = new bootstrap.Modal(document.getElementById('editPasienModal'));
            modal.show();
        }

        let selectedPasienId = null;

        function setSelectedPasienId(id) {
            selectedPasienId = id;
        }

        function redirectToKunjunganForm() {
            if (selectedPasienId) {
                window.location.href = `/kunjungan/poli-umum/${selectedPasienId}`;
            } else {
                alert('Please select a patient first.');
            }
        }
    </script>

    @endsection