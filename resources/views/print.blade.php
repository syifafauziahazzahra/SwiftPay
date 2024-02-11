<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        /* Gaya CSS untuk tampilan cetak */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            display: none;
            /* Sembunyikan tombol cetak saat mencetak */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Detail Penjualan</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Detail ID</th>
                    <th>Penjualan ID</th>
                    <th>Produk ID</th>
                    <th>Jumlah Produk</th>
                    <th>Subtotal</th>
                    <th>Pelanggan Alamat</th>
                    <th>Tanggal Pemesanan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $detailPenjualan->id }}</td>
                    <td>{{ $detailPenjualan->penjualan->PenjualanID }}</td>
                    <td>{{ $detailPenjualan->ProdukID }}</td>
                    <td>{{ $detailPenjualan->JumlahProduk }}</td>
                    <td>{{ $detailPenjualan->Subtotal }}</td>
                    <td>{{ $detailPenjualan->penjualan->pelanggan->Alamat }}</td>
                    <td>{{ $detailPenjualan->penjualan->TanggalPemesanan }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Sembunyikan tombol cetak saat mencetak
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>