<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\PenjualanDetail;
use App\Models\Penjualan;
use App\Models\Dokter;
use App\Models\KunjunganPoliUmum;

class MainController extends Controller
{
    public function index()
    {
        $jumlahPasien = Pasien::count();
        $jumlahKunjungan = Kunjungan::count();
        $jumlahPendapatan = PenjualanDetail::sum('total_harga');
        $jumlahPenjualan = Penjualan::count();
        $penjualan = Penjualan::all(); // Undefined variable $penjualan

        return view('dashboard', compact('jumlahPasien', 'jumlahKunjungan', 'jumlahPendapatan', 'jumlahPenjualan', 'penjualan'));
    }

    public function dataPasien()
    {
        // Do not load all patients by default to improve performance
        return view('pasien.data', ['pasien' => collect()]);
    }

    public function tambahPasien(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'no_rm' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        Pasien::create($request->all());

        return back()->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function editPasien(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'no_rm' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());

        return back()->with('success', 'Data pasien berhasil diupdate.');
    }

    public function hapusPasien($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return back()->with('success', 'Data pasien berhasil dihapus.');
    }

    public function searchPasien(Request $request)
    {
        $query = Pasien::query();

        if ($request->filled('no_rm')) {
            $query->where('no_rm', 'like', '%' . $request->no_rm . '%');
        }

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('alamat')) {
            $query->where('alamat', 'like', '%' . $request->alamat . '%');
        }

        $pasien = $query->get();

        return view('pasien.data', compact('pasien'));
    }

    public function showKunjunganForm($pasien_id)
    {
        $dokters = Dokter::all(); // Asumsi Anda memiliki model Dokter
        return view('pasien.kunjungan-poli-umum', compact('pasien_id', 'dokters'));
    }

    public function storeKunjungan(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date',
            'jenis_pasien' => 'required|in:Baru,Lama',
            'diagnosis' => 'required|string',
            'pembiayaan' => 'required|in:BPJS,Umum',
            'dokter_id' => 'required|exists:dokter,id',
        ]);

        // Simpan data kunjungan
        KunjunganPoliUmum::create([
            'pasien_id' => $request->pasien_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jenis_pasien' => $request->jenis_pasien,
            'diagnosis' => $request->diagnosis,
            'pembiayaan' => $request->pembiayaan,
            'dokter_id' => $request->dokter_id,
        ]);

        return redirect()->route('pasien')->with('success', 'Kunjungan poli umum berhasil disimpan!');
    }
}
