@extends('layout.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Penjualan Obat</h4>
                            <a href="#" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#inputModal">
                                Tambah Penjualan
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter Tanggal -->
                        <form action="{{ route('penjualan-obat') }}" method="GET" class="row mb-3">
                            <div class="col-md-5">
                                <label for="filter_tanggal_mulai" class="form-label">Filter Tanggal Mulai</label>
                                <input type="date" class="form-control" id="filter_tanggal_mulai" name="start_date" value="{{ $startDate }}">
                            </div>
                            <div class="col-md-5">
                                <label for="filter_tanggal_selesai" class="form-label">Filter Tanggal Selesai</label>
                                <input type="date" class="form-control" id="filter_tanggal_selesai" name="end_date" value="{{ $endDate }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                            </div>
                        </form>
                        <table id="add-row" class="display table table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Nama Pasien</th>
                                    <th>Harga Pembelian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data penjualan akan ditampilkan di sini -->
                                @foreach($penjualan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $item->nama_pasien }}</td>
                                    <td>Rp {{ number_format($item->details->sum('total_harga'), 0, ',', '.') }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('penjualan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <!-- Tombol Cetak -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#printModal-{{ $item->id }}">
                                            <i class="fa fa-print"></i> Cetak
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('penjualan.delete', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeletion({{ $item->id }}, '{{ $item->nama_pasien }}')">
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

<!-- Modal for inputting data -->
<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputModalLabel">Input Data Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="penjualanForm" method="POST" action="{{ route('penjualan') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_pasien" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for printing data -->
@foreach($penjualan as $item)
<div class="modal fade" id="printModal-{{ $item->id }}" tabindex="-1" aria-labelledby="printModalLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel-{{ $item->id }}">Cetak Kwitansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="printFrame-{{ $item->id }}" src="{{ route('cetak-kwitansi', $item->id) }}" frameborder="0" style="width: 100%; height: 500px;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
                <button type="button" class="btn btn-primary" onclick="printIframe('printFrame-{{ $item->id }}')">
                    <i class="fa fa-print"></i> Print
                </button>
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
            timer: 5000,
            timerProgressBar: true
        });
    });
</script>
@endif

<script>
    // Fungsi untuk konfirmasi penghapusan
    function confirmDeletion(id, namaPasien) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Anda akan menghapus penjualan atas nama "${namaPasien}".`,
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

    // Fungsi untuk mencetak iframe
    function printIframe(id) {
        const iframe = document.getElementById(id);
        iframe.contentWindow.print();
    }
</script>
@endsection