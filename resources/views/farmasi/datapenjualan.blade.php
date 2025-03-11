@extends('layout.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Form Penjualan Obat</h4>
                        <form id="penjualanForm" method="POST" action="{{ route('penjualan.store') }}">
                            @csrf
                            <div class="row mb-5">
                                <div class="col-md-2">
                                    <label for="penjualan_id" class="form-label">Nama Pasien</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" class="form-control" id="penjualan_id" name="penjualan_id" value="{{ $penjualan->id }}">
                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="{{ $penjualan->nama_pasien }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="obat" class="form-label">Nama Obat</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="search_obat" placeholder="Cari Obat..." onkeyup="filterObat()">
                                    <div id="obat_list" class="list-group mt-2 position-absolute w-100" style="z-index: 1000; display: none;"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                </div>
                                <div class="col-md-2">
                                    <label for="harga" class="form-label">Harga/pcs</label>
                                </div>
                                <div class="col-md-1">
                                    <label for="diskon" class="form-label">Diskon (%)</label>
                                </div>
                                <div class="col-md-2">
                                    <label for="harga_diskon" class="form-label">Harga Diskon</label>
                                </div>
                                <div class="col-md-2">
                                    <label for="ppn" class="form-label">PPN (11%)</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="total_harga" class="form-label">Harga Total</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-1">
                                    <input type="number" class="form-control" id="jumlah" name="jumlah[]" placeholder="Jumlah" oninput="updateHarga()">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="harga" placeholder="Harga" readonly>
                                </div>
                                <div class="col-md-1">
                                    <input type="number" class="form-control" id="diskon" name="diskon[]" placeholder="Diskon (%)" value="0" oninput="updateHarga()">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="harga_diskon" placeholder="Harga Diskon" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="ppn" placeholder="PPN (11%)" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="total_harga" name="total_harga[]" placeholder="Harga Total" readonly>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-success" onclick="tambahData()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Harga Setelah Diskon</th>
                                        <th>PPN</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel_obat"></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right">Sub Total</th>
                                        <th id="sub_total">0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" id="submitButton">
                                    <span id="submitText">Simpan</span>
                                    <span id="submitLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    function confirmDeletion(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data penjualan akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        })
    }
</script>

<script>
    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }
    let obatData = [
        @foreach($obat as $o) {
            nama: "{{ $o->nama_obat }}",
            distributor: "{{ $o->distributor->nama }}",
            harga: "{{ $o->harga }}",
            id: "{{ $o->id }}"
        },
        @endforeach
    ];

    function filterObat() {
        let input = document.getElementById("search_obat").value.toLowerCase();
        let list = document.getElementById("obat_list");
        list.innerHTML = "";

        if (input.length === 0) {
            list.style.display = "none";
            return;
        }

        let filteredObat = obatData.filter(obat => obat.nama.toLowerCase().includes(input));

        if (filteredObat.length > 0) {
            list.style.display = "block";
            filteredObat.forEach(obat => {
                let item = document.createElement("button");
                item.type = "button"; // Tambahkan ini agar tidak submit form saat diklik
                item.className = "list-group-item list-group-item-action";
                item.innerHTML = `${obat.nama} - ${obat.distributor}`;
                item.onclick = function() {
                    document.getElementById("search_obat").value = obat.nama;
                    document.getElementById("harga").value = obat.harga;
                    document.getElementById("jumlah").value = 1; // Set default quantity to 1
                    document.getElementById("obat_list").style.display = "none";
                    updateHarga(); // Panggil updateHarga saat obat dipilih
                };
                list.appendChild(item);
            });
        } else {
            list.style.display = "none";
        }
    }

    function updateHarga() {
        let hargaObat = parseFloat(document.getElementById("harga").value);
        let jumlah = parseInt(document.getElementById("jumlah").value);
        let diskon = parseFloat(document.getElementById("diskon").value);

        if (!hargaObat || !jumlah) return;

        let totalHarga = hargaObat * jumlah;
        let hargaSetelahDiskon = totalHarga - (totalHarga * (diskon / 100));
        let ppn = hargaSetelahDiskon * 0.11; // PPN 11%
        let totalHargaFinal = hargaSetelahDiskon + ppn;

        document.getElementById("harga_diskon").value = hargaSetelahDiskon.toFixed(2);
        document.getElementById("ppn").value = ppn.toFixed(2);
        document.getElementById("total_harga").value = totalHargaFinal.toFixed(2);
    }

    function updateSubTotal() {
        let tabel = document.getElementById("tabel_obat");
        let rows = tabel.rows;
        let subTotal = 0;

        for (let i = 0; i < rows.length; i++) {
            let totalHarga = parseFloat(rows[i].cells[6].innerText);
            if (!isNaN(totalHarga)) {
                subTotal += totalHarga;
            }
        }

        document.getElementById("sub_total").innerText = subTotal.toFixed(2);
    }

    function tambahData() {
        let namaObat = document.getElementById("search_obat").value;
        let jumlah = document.getElementById("jumlah").value;
        let harga = document.getElementById("harga").value;
        let diskon = document.getElementById("diskon").value;
        let hargaDiskon = document.getElementById("harga_diskon").value;
        let ppn = document.getElementById("ppn").value;
        let totalHarga = document.getElementById("total_harga").value;

        if (!namaObat) {
            alert("Silakan pilih obat terlebih dahulu!");
            return;
        }

        if (!jumlah || jumlah < 1) {
            alert("Jumlah tidak boleh kosong atau kurang dari 1!");
            return;
        }

        if (!totalHarga || totalHarga === "0") {
            alert("Harga total tidak boleh kosong!");
            return;
        }

        // Ambil ID obat
        let obat = obatData.find(obat => obat.nama === namaObat);
        if (!obat) {
            alert("Obat tidak ditemukan!");
            return;
        }
        let obatId = obat.id;

        // Tambahkan data ke tabel
        let tabel = document.getElementById("tabel_obat");
        let row = tabel.insertRow();
        row.innerHTML = `<td>${namaObat}</td>
<td>${jumlah}</td>
<td>${harga}</td>
<td>${diskon}%</td>
<td>${hargaDiskon}</td>
<td>${ppn}</td>
<td>${totalHarga}</td>
<td><button class='btn btn-danger btn-sm' onclick='hapusBaris(this)'><i class="fas fa-trash"></i> Hapus</button></td>`;

        // Tambahkan input hidden untuk setiap data agar tersimpan di form
        let form = document.getElementById("penjualanForm");

        let inputObatId = document.createElement("input");
        inputObatId.type = "hidden";
        inputObatId.name = "obat_id[]";
        inputObatId.value = obatId;
        form.appendChild(inputObatId);

        let inputJumlah = document.createElement("input");
        inputJumlah.type = "hidden";
        inputJumlah.name = "jumlah[]";
        inputJumlah.value = jumlah;
        form.appendChild(inputJumlah);

        let inputTotalHarga = document.createElement("input");
        inputTotalHarga.type = "hidden";
        inputTotalHarga.name = "total_harga[]";
        inputTotalHarga.value = totalHarga;
        form.appendChild(inputTotalHarga);

        updateSubTotal();
    }

    function hapusBaris(btn) {
        if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            return;
        }

        let row = btn.parentNode.parentNode;
        let form = document.getElementById("penjualanForm");

        // Hapus input hidden yang terkait
        let inputs = form.querySelectorAll("input[type='hidden']");
        inputs.forEach(input => {
            if (input.value === row.cells[6].innerText) {
                form.removeChild(input);
            }
        });

        row.parentNode.removeChild(row);
        updateSubTotal();
    }

    // Loading state saat form disubmit
    document.getElementById("penjualanForm").addEventListener("submit", function() {
        document.getElementById("submitText").style.display = "none";
        document.getElementById("submitLoading").style.display = "inline-block";
    });
</script>
@endsection