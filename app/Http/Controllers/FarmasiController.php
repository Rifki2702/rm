<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FarmasiController extends Controller
{
    // ========================= DISTRIBUTOR =========================

    public function distributor()
    {
        $distributors = Distributor::all();
        return view('farmasi.distributor', compact('distributors'));
    }

    public function distributorStore(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'nama' => 'required|string|max:100'
            ]);

            // Simpan ke database
            Distributor::create([
                'nama' => $validatedData['nama'] // Sesuaikan dengan nama kolom di tabel
            ]);

            return redirect()->back()->with('success', 'Distributor berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Log error agar bisa ditelusuri
            Log::error('Error saat menyimpan distributor: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function distributorEdit(Request $request, $id)
    {
        $request->validate(['nama' => 'required|max:100']);

        $distributor = Distributor::findOrFail($id);
        $distributor->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'Distributor berhasil diperbarui!');
    }

    public function distributorDelete($id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        return redirect()->back()->with('success', 'Distributor berhasil dihapus!');
    }

    // ========================= OBAT =========================

    // Menampilkan halaman obat masuk
    public function indexObatMasuk()
    {
        try {
            $obat = Obat::with('distributor')->get();
            $distributors = Distributor::all();
            return view('farmasi.obat-masuk', compact('obat', 'distributors'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data obat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data obat.');
        }
    }

    // Menyimpan data obat baru
    public function storeObatMasuk(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'distributor_id' => 'required|exists:distributors,id',
                'kode_obat' => 'required|unique:obat,kode_obat',
                'nama_obat' => 'required',
                'harga' => 'required|numeric',
                'jumlah_stok' => 'required|integer',
                'tanggal_expired' => 'required|date'
            ]);

            // Tambahkan lokasi_stok default jika tidak disediakan
            $validatedData['lokasi_stok'] = $request->input('lokasi_stok', 'Default Lokasi');

            // Simpan data obat
            Obat::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Obat berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Log error dan redirect dengan pesan error
            Log::error('Error saat menambahkan obat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan obat.');
        }
    }

    // Mengupdate data obat
    public function updateObatMasuk(Request $request, $id)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'distributor_id' => 'required|exists:distributors,id',
                'kode_obat' => 'required|unique:obat,kode_obat,' . $id . ',id',
                'nama_obat' => 'required',
                'harga' => 'required|numeric',
                'jumlah_stok' => 'required|integer',
                'lokasi_stok' => 'required',
                'tanggal_expired' => 'required|date'
            ]);

            // Cari obat berdasarkan ID
            $obat = Obat::findOrFail($id);

            // Update data obat
            $obat->update($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Obat berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Redirect dengan pesan error jika obat tidak ditemukan
            return redirect()->back()->with('error', 'Obat tidak ditemukan.');
        } catch (\Exception $e) {
            // Log error dan redirect dengan pesan error
            Log::error('Error saat memperbarui obat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui obat.');
        }
    }

    // Menghapus data obat
    public function destroyObatMasuk($id)
    {
        try {
            // Cari obat berdasarkan ID
            $obat = Obat::findOrFail($id);

            // Hapus data obat
            $obat->delete();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Obat berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Redirect dengan pesan error jika obat tidak ditemukan
            return redirect()->back()->with('error', 'Obat tidak ditemukan.');
        } catch (\Exception $e) {
            // Log error dan redirect dengan pesan error
            Log::error('Error saat menghapus obat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus obat.');
        }
    }

    // ========================= PENJUALAN OBAT =========================

    public function penjualanObat(Request $request)
    {
        // Ambil tanggal default (awal bulan hingga hari ini)
        $startDate = $request->input('start_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', \Carbon\Carbon::now()->format('Y-m-d'));

        // Query untuk mendapatkan data penjualan berdasarkan rentang tanggal
        $penjualan = Penjualan::with(['details.obat'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        // Ambil semua data obat dan distributor
        $obat = Obat::all();
        $distributors = Distributor::all();

        // Return view dengan data yang diperlukan
        return view('farmasi.penjualan-obat', compact('penjualan', 'obat', 'distributors', 'startDate', 'endDate'));
    }

    public function inputPenjualan(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
        ]);

        // Simpan data penjualan
        $penjualan = Penjualan::create([
            'nama_pasien' => $request->nama_pasien,
        ]);

        // Redirect ke route penjualan.data dengan pesan sukses
        return redirect()->route('penjualan.data', ['id' => $penjualan->id])->with('success', 'Data penjualan berhasil disimpan!');
    }

    public function datapenjualan($id)
    {
        $penjualan = Penjualan::with('details.obat')->findOrFail($id); // Fetch penjualan by id
        $obat = Obat::all(); // Fetch all obat data
        $distributors = Distributor::all(); // Fetch all distributor data
        $penjualan_id = $penjualan->id; // Define penjualan_id to avoid undefined variable error
        return view('farmasi.datapenjualan', compact('penjualan', 'obat', 'distributors', 'penjualan_id'));
    }

    public function penjualanStore(Request $request)
    {
        // Validasi data
        $request->validate([
            'penjualan_id' => 'required|integer|exists:penjualan,id',
            'obat_id.*' => 'required|integer|exists:obat,id',
            'jumlah.*' => 'required|integer|min:1',
            'total_harga.*' => 'required|numeric|min:1',
        ], [
            'jumlah.*.required' => 'Jumlah obat harus diisi!',
            'jumlah.*.min' => 'Jumlah obat minimal 1!',
            'total_harga.*.required' => 'Harga total harus diisi!',
            'total_harga.*.min' => 'Harga total tidak boleh 0!',
            'obat_id.*.required' => 'Obat harus dipilih!',
            'obat_id.*.exists' => 'Obat tidak ditemukan di database!',
            'penjualan_id.required' => 'ID penjualan harus diisi!',
            'penjualan_id.exists' => 'ID penjualan tidak ditemukan di database!',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // Simpan data ke tabel `penjualan_detail`
            foreach ($request->obat_id as $index => $obatId) {
                PenjualanDetail::create([
                    'penjualan_id' => $request->penjualan_id, // Gunakan ID penjualan yang dikirim
                    'obat_id' => $obatId,
                    'jumlah' => $request->jumlah[$index],
                    'total_harga' => $request->total_harga[$index],
                ]);

                // Kurangi stok obat
                $obat = Obat::findOrFail($obatId);
                $obat->jumlah_stok -= $request->jumlah[$index]; // Kurangi stok sesuai jumlah yang dibeli
                $obat->save(); // Simpan perubahan stok
            }

            // Commit transaksi
            DB::commit();

            return redirect()->route('penjualan-obat', ['id' => $request->penjualan_id])->with('success', 'Detail penjualan berhasil disimpan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function penjualanEdit($id)
    {
        $penjualan = Penjualan::with('details.obat')->findOrFail($id); // Fetch penjualan by id
        $obat = Obat::all(); // Fetch all obat data
        $distributors = Distributor::all(); // Fetch all distributor data
        $penjualan_id = $penjualan->id; // Define penjualan_id to avoid undefined variable error
        return view('farmasi.editpenjualan', compact('penjualan', 'obat', 'distributors', 'penjualan_id'));
    }

    public function penjualanUpdate(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'penjualan_id' => 'required|integer|exists:penjualan,id',
            'obat_id.*' => 'required|integer|exists:obat,id',
            'jumlah.*' => 'required|integer|min:1',
            'total_harga.*' => 'required|numeric|min:1',
        ], [
            'jumlah.*.required' => 'Jumlah obat harus diisi!',
            'jumlah.*.min' => 'Jumlah obat minimal 1!',
            'total_harga.*.required' => 'Harga total harus diisi!',
            'total_harga.*.min' => 'Harga total tidak boleh 0!',
            'obat_id.*.required' => 'Obat harus dipilih!',
            'obat_id.*.exists' => 'Obat tidak ditemukan di database!',
            'penjualan_id.required' => 'ID penjualan harus diisi!',
            'penjualan_id.exists' => 'ID penjualan tidak ditemukan di database!',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // Ambil data penjualan berdasarkan ID
            $penjualan = Penjualan::findOrFail($id);

            // Ambil detail penjualan lama
            $detailLama = $penjualan->details;

            // Simpan data baru ke tabel `penjualan_detail`
            foreach ($request->obat_id as $index => $obatId) {
                // Cari detail penjualan lama untuk obat ini
                $detail = $detailLama->where('obat_id', $obatId)->first();

                if ($detail) {
                    // Jika obat sudah ada, update jumlah dan total harga
                    $jumlahLama = $detail->jumlah;
                    $detail->update([
                        'jumlah' => $request->jumlah[$index],
                        'total_harga' => $request->total_harga[$index],
                    ]);

                    // Update stok obat
                    $obat = Obat::findOrFail($obatId);
                    $obat->jumlah_stok += $jumlahLama; // Kembalikan stok lama
                    $obat->jumlah_stok -= $request->jumlah[$index]; // Kurangi stok baru
                    $obat->save();
                } else {
                    // Jika obat baru, tambahkan ke detail penjualan
                    PenjualanDetail::create([
                        'penjualan_id' => $penjualan->id,
                        'obat_id' => $obatId,
                        'jumlah' => $request->jumlah[$index],
                        'total_harga' => $request->total_harga[$index],
                    ]);

                    // Kurangi stok obat
                    $obat = Obat::findOrFail($obatId);
                    $obat->jumlah_stok -= $request->jumlah[$index];
                    $obat->save();
                }
            }

            // Kembalikan stok obat yang dihapus
            foreach ($detailLama as $detail) {
                if (!in_array($detail->obat_id, $request->obat_id)) {
                    $obat = Obat::findOrFail($detail->obat_id);
                    $obat->jumlah_stok += $detail->jumlah;
                    $obat->save();
                }
            }

            // Commit transaksi
            DB::commit();

            return redirect()->route('penjualan-obat', ['id' => $penjualan->id])->with('success', 'Detail penjualan berhasil diperbarui!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function penjualanDetailDelete($id)
    {
        DB::beginTransaction();
        try {
            // Ambil detail penjualan berdasarkan ID
            $detail = PenjualanDetail::findOrFail($id);

            // Kembalikan stok obat ke jumlah semula
            $obat = Obat::findOrFail($detail->obat_id);
            $obat->jumlah_stok += $detail->jumlah; // Kembalikan stok
            $obat->save();

            // Hapus detail penjualan
            $detail->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Detail penjualan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function penjualanDelete($id)
    {
        DB::beginTransaction();
        try {
            // Ambil data penjualan berdasarkan ID
            $penjualan = Penjualan::findOrFail($id);

            // Ambil detail penjualan terkait
            $details = $penjualan->details;

            // Kembalikan stok obat ke jumlah semula
            foreach ($details as $detail) {
                $obat = Obat::findOrFail($detail->obat_id);
                $obat->jumlah_stok += $detail->jumlah; // Kembalikan stok
                $obat->save();
            }

            // Hapus detail penjualan
            $penjualan->details()->delete();

            // Hapus data penjualan
            $penjualan->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Penjualan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cetakKwitansi($id)
    {
        try {
            // Ambil data penjualan berdasarkan ID
            $penjualan = Penjualan::with('details.obat')->findOrFail($id);

            // Return view kwitansi dengan data penjualan
            return view('farmasi.kwitansi', compact('penjualan'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Redirect dengan pesan error jika penjualan tidak ditemukan
            return redirect()->back()->with('error', 'Penjualan tidak ditemukan.');
        } catch (\Exception $e) {
            // Log error dan redirect dengan pesan error
            Log::error('Error saat mencetak kwitansi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencetak kwitansi.');
        }
    }

    public function laporanFarmasi()
    {
        return view('farmasi.laporan');
    }
}
