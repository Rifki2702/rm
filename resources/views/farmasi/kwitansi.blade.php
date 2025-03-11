<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Klinik Harapan Sehat</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            position: relative;
        }

        .header img {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 40px;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 0;
        }

        .patient-info {
            margin-bottom: 20px;
        }

        .patient-info p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('template/assets/img/kaiadmin/hs.ico') }}" alt="Logo">
            <h1>Klinik Harapan Sehat</h1>
            <p>Jl. Mumbulsari No.177, Krajan, Mayang, Jember, Jawa Timur 68182</p>
            <p>Telepon: (0331) 593007</p>
        </div>
        <div class="patient-info">
            <p><strong>Nama Pasien:</strong> {{ $penjualan->nama_pasien }}</p>
            <p><strong>Tanggal Pembelian:</strong> {{ $penjualan->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>PPN</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->obat->nama_obat }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->obat->harga, 0, ',', '.') }}</td>
                    <td>11%</td>
                    <td>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Total Harga:</strong></td>
                    <td>Rp {{ number_format($penjualan->details->sum('total_harga'), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>