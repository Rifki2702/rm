@extends('layout.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tambah Kunjungan Rawat Inap</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pasien') }}">Data Pasien</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Tambah Kunjungan Rawat Inap</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Tambah Kunjungan Rawat Inap</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kunjungan.rawat-inap.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pasien_id" value="{{ $pasien_id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Field Tanggal Masuk -->
                                    <div class="form-group">
                                        <label for="tanggal_masuk">Tanggal Masuk</label>
                                        <input type="date" name="tanggal_masuk" class="form-control" required>
                                    </div>

                                    <!-- Field Tanggal Keluar -->
                                    <div class="form-group">
                                        <label for="tanggal_keluar">Tanggal Keluar</label>
                                        <input type="date" name="tanggal_keluar" class="form-control" value="{{ old('tanggal_masuk', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                    </div>

                                    <!-- Field Jenis Pasien -->
                                    <div class="form-group">
                                        <label for="jenis_pasien">Jenis Pasien</label>
                                        <select name="jenis_pasien" class="form-control" required>
                                            <option value="Baru" {{ old('jenis_pasien') == 'Baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="Lama" {{ old('jenis_pasien') == 'Lama' ? 'selected' : '' }}>Lama</option>
                                        </select>
                                    </div>

                                    <!-- Field Diagnosis -->
                                    <div class="form-group">
                                        <label for="diagnosis">Diagnosis</label>
                                        <input type="text" name="diagnosis" class="form-control" value="{{ old('diagnosis') }}" required>
                                    </div>

                                    <!-- Field Kondisi Keluar -->
                                    <div class="form-group">
                                        <label for="kondisi_keluar">Kondisi Keluar</label>
                                        <select name="kondisi_keluar" class="form-control">
                                            <option value="">Pilih Kondisi Keluar</option>
                                            <option value="Sembuh" {{ old('kondisi_keluar') == 'Sembuh' ? 'selected' : '' }}>Sembuh</option>
                                            <option value="Pulang Paksa" {{ old('kondisi_keluar') == 'Pulang Paksa' ? 'selected' : '' }}>Pulang Paksa</option>
                                            <option value="Meninggal">Meninggal</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <!-- Field Jenis Pembiayaan -->
                                    <div class="form-group">
                                        <label for="jenis_pembiayaan">Jenis Pembiayaan</label>
                                        <select name="jenis_pembiayaan" class="form-control" required>
                                            <option value="BPJS" {{ old('jenis_pembiayaan') == 'BPJS' ? 'selected' : '' }}>BPJS</option>
                                            <option value="Umum" {{ old('jenis_pembiayaan') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                        </select>
                                    </div>

                                    <!-- Field Ruang -->
                                    <div class="form-group">
                                        <label for="ruang">Ruang</label>
                                        <input type="text" name="ruang" class="form-control" value="{{ old('ruang') }}" required>
                                    </div>

                                    <!-- Field Dokter UGD -->
                                    <div class="form-group">
                                        <label for="dokter_ugd_id">Dokter UGD</label>
                                        <select name="dokter_ugd_id" class="form-control" required>
                                            <option value="">Pilih Dokter UGD</option>
                                            @foreach($dokters->where('poli', 'Umum') as $dokter)
                                            <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Field Dokter Poli Umum -->
                                    <div class="form-group">
                                        <label for="dokter_rawat_inap">Dokter Poli Umum</label>
                                        <div id="dokter-rawat-inap-container">
                                            <div class="d-flex align-items-center mb-2">
                                                <select name="dokter_rawat_inap[]" class="form-control" required>
                                                    @foreach($dokters->where('poli', 'Umum') as $dokter)
                                                    <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="number" name="jumlah[]" class="form-control ml-2" placeholder="Jumlah Kunjungan" min="1" value="1" required>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success" onclick="addDokterRawatInapField()">Tambah Dokter</button>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Simpan
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                                            <i class="fa fa-arrow-left"></i> Kembali
                                        </button>
                                        <button type="reset" class="btn btn-warning">
                                            <i class="fa fa-undo"></i> Reset
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addDokterRawatInapField() {
        var container = document.getElementById('dokter-rawat-inap-container');
        var newField = document.createElement('div');
        newField.className = 'd-flex align-items-center mb-2';
        newField.innerHTML = `
            <select name="dokter_rawat_inap[]" class="form-control" required>
                @foreach($dokters->where('poli', 'Umum') as $dokter)
                <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                @endforeach
            </select>
            <input type="number" name="jumlah[]" class="form-control ml-2" placeholder="Jumlah Kunjungan" min="1" value="1" required>
            <button type="button" class="btn btn-danger ml-2" onclick="removeDokterRawatInapField(this)">Hapus</button>
        `;
        container.appendChild(newField);
    }

    function removeDokterRawatInapField(button) {
        button.parentElement.remove();
    }
</script>
@endsection