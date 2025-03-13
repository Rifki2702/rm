<?php

namespace App\Http\Controllers;

use App\Charts\GigiUmumChart;
use App\Charts\KunjunganChart;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\PenjualanDetail;
use App\Models\Penjualan;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MainController extends Controller
{
    public function index(KunjunganChart $kunjunganChart, GigiUmumChart $gigiUmumChart)
    {
        // Data statistik
        $jumlahPasien = Pasien::count();
        $jumlahKunjungan = Kunjungan::count();
        $jumlahPendapatan = PenjualanDetail::sum('total_harga');
        $jumlahPenjualan = Penjualan::count();
        $penjualan = Penjualan::all();

        // Kirim semua variabel ke view
        return view('dashboard', [
            'jumlahPasien' => $jumlahPasien,
            'jumlahKunjungan' => $jumlahKunjungan,
            'jumlahPendapatan' => $jumlahPendapatan,
            'jumlahPenjualan' => $jumlahPenjualan,
            'penjualan' => $penjualan,
            'chart' => $kunjunganChart->build(),
            'gigiUmumChart' => $gigiUmumChart->build()
        ]);
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
}
