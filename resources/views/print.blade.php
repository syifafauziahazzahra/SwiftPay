<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 300px;
            margin: auto;
            padding: 10px;
            border: 2px solid #000;
            border-radius: 10px;
            box-shadow: 0px 0px 5px 0px #888;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 100px;
            height: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            max-height: 200px;
            /* Ketinggian maksimum untuk tabel */
            overflow-y: auto;
            /* Tambahkan scrollbar vertikal jika konten melebihi ketinggian maksimum */
            border-bottom: none;
            /* Hapus garis pinggir bawah */
        }

        th,
        td {
            border: none;
            padding: 5px;
        }

        .subtotal {
            margin-top: 10px;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <h1>Struk Penjualan</h1>
    <h1>CipaCup's Cafe</h1>
    <br>
    <table>
        <tr>
            <td>Nama Pelanggan:</td>
            <td>{{ $data->penjualan->pelanggan->NamaPelanggan }}</td>

        </tr>
        <tr>
            <td>Tanggal Penjualan:</td>
            <td>{{ $data->penjualan ? $data->penjualan->TanggalPenjualan : 'Tidak ada data penjualan' }}</td>
        </tr>
        <tr>
            <td>Nama Produk:</td>
            <td>{{ $data->produk ? $data->produk->NamaProduk : 'Tidak ada data produk' }}</td>
        </tr>
        <tr>
            <td>Jumlah Produk:</td>
            <td>{{ $data->JumlahProduk }}</td>
        </tr>
        <br>
    </table>
    <div class="subtotal">
        Total: {{ $data->Subtotal }}
    </div>
    <!-- <div class="footer">
        Ini Struk CipaCup's Cafe - SwiftPay
    </div> -->
</body>

</html>