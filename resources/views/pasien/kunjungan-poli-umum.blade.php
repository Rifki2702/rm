@extends('layout.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Kunjungan Poli Umum</h3>
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
                    <a href="#">Kunjungan Poli Umum</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Kunjungan Poli Umum</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kunjungan.poli-umum.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pasien_id" value="{{ $pasien_id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                                        <input type="date" name="tanggal_kunjungan" class="form-control" value="{{ old('tanggal_kunjungan', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_pasien">Jenis Pasien</label>
                                        <select name="jenis_pasien" class="form-control" required>
                                            <option value="Baru" {{ old('jenis_pasien') == 'Baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="Lama" {{ old('jenis_pasien') == 'Lama' ? 'selected' : '' }}>Lama</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="diagnosis">Diagnosis</label>
                                        <input type="text" name="diagnosis" class="form-control" value="{{ old('diagnosis') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pembiayaan">Pembiayaan</label>
                                        <select name="pembiayaan" class="form-control" required>
                                            <option value="BPJS" {{ old('pembiayaan') == 'BPJS' ? 'selected' : '' }}>BPJS</option>
                                            <option value="Umum" {{ old('pembiayaan') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="dokter_id">Dokter</label>
                                        <select name="dokter_id" class="form-control" required>
                                            @foreach($dokters as $dokter)
                                                @if($dokter->poli == 'Umum')
                                                    <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>{{ $dokter->nama }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
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
@endsection