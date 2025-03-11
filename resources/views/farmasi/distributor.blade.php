@extends('layout.app')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Data Distributor</h4>
              <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addDistributorModal">
                <i class="fa fa-plus"></i> Tambah Distributor
              </button>
            </div>
          </div>
          <div class="card-body">
            <!-- Modal Tambah -->
            <div class="modal fade" id="addDistributorModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">Tambah Distributor</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="{{ route('distributor.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" required maxlength="100">
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

            <!-- Modal Edit -->
            <div class="modal fade" id="editDistributorModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title">Edit Distributor</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form id="editDistributorForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editDistributorId">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" id="editDistributorName" required maxlength="100">
                      </div>
                    </div>
                    <div class="modal-footer border-0">
                      <button type="submit" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Update
                      </button>
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Tutup
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover text-center">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Distributor</th>
                    <th>Nama</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($distributors as $key => $distributor)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $distributor->kode_distributor }}</td>
                    <td>{{ $distributor->nama }}</td>
                    <td>
                      <a href="#" class="btn btn-warning btn-sm" onclick="editDistributor({{ $distributor->id }}, '{{ $distributor->nama }}')">
                        <i class="fa fa-edit"></i> Edit
                      </a>
                      <form id="deleteForm-{{ $distributor->id }}" action="{{ route('distributor.delete', $distributor->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                      </form>
                      <a href="#" class="btn btn-danger btn-sm" onclick="confirmDeletion({{ $distributor->id }})">
                        <i class="fa fa-trash"></i> Hapus
                      </a>
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
      text: "Data distributor akan dihapus secara permanen!",
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

  function editDistributor(id, name) {
    document.getElementById('editDistributorId').value = id;
    document.getElementById('editDistributorName').value = name;
    document.getElementById('editDistributorForm').action = "/distributor/" + id;
    var modal = new bootstrap.Modal(document.getElementById('editDistributorModal'));
    modal.show();
  }
</script>

@endsection