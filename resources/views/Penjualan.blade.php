@extends('layouts.base')

@section('content')
<div class="card p-5">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createData">Tambah Data</button>
    </div>
    <table class="table datatable-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>TANGGAL PENJUALAN</th>
                <th>TOTAL HARGA</th>
                <th>PELANGGAN</th>
                <th>TOOLS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->TanggalPenjualan }}</td>
                <td>{{ $item->TotalHarga }}</td>
                <td>{{ $item->pelanggan->NamaPelanggan }}</td>
                <td>
                    <button type="button" title="EDIT" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#updateData" data-PenjualanID="{{ $item->PenjualanID }}" data-TanggalPenjualan="{{ $item->TanggalPenjualan }}" data-TotalHarga="{{ $item->TotalHarga }}" data-PelangganID="{{ $item->PelangganID }}">
                        <i class="bi bi-pen"></i> UPDATE
                    </button>
                    <form id="deleteForm" action="{{ route('penjualan.destroy', ['PenjualanID' => $item->PenjualanID]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="DELETE" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> DELETE
                        </button>
                    </form>
                    <!-- <button type="button" title="DETAIL" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailData" data-detailid="{{ $item->DetailID }}" data-jumlahproduk="{{ $item->JumlahProduk }}" data-subtotal="{{ $item->Subtotal }}">
                        <i class="bi bi-info-circle"></i> DETAIL
                    </button> -->

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Update -->
    <div class="modal fade" id="updateData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateDataLabel" aria-hidden="true">
        <div class="modal-dialog" id="updateDialog">
            <div id="modal-content" class="modal-content">
                <div class="modal-body">
                    Loading..
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="modal-content" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penjualan.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="PelangganID" class="form-label">PelangganID </label>
                            <select class="form-select form-require" name="PelangganID" id="PelangganID">
                                <option selected>Masukkan Nama Pelanggan</option>
                                @foreach ($pelanggan as $data)
                                <option value="{{ $data->PelangganID }}">{{ $data->NamaPelanggan }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('PelangganID')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="ProdukID" class="form-label">ProdukID </label>
                            <select class="form-select form-require" name="ProdukID" id="ProdukID">
                                <option selected>Masukkan Produk</option>
                                @foreach ($produk as $data)
                                <option value="{{ $data->ProdukID }}">{{ $data->NamaProduk }}</option>
                                @endforeach
                            </select> <x-input-error :messages="$errors->get('ProdukID')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="JumlahProduk" class="form-label">JumlahProduk</label>
                            <input type="text" class="form-control form-require" id="JumlahProduk" name="JumlahProduk" placeholder="Masukkan JumlahProduk" required>
                            <x-input-error :messages="$errors->get('JumlahProduk')" class="mt-2" />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal Detail Transaksi
<div class="modal fade" id="detailData" tabindex="-1" aria-labelledby="detailDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailDataLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Jumlah Produk:</strong> <span id="jumlahProduk"></span></p>
                <p><strong>Subtotal:</strong> <span id="subtotal"></span></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Ketika tombol detail ditekan
        $('button[data-bs-target^="#detailData"]').on('click', function() {
            var detailID = $(this).data('detailid');

            // Kirim permintaan AJAX untuk mendapatkan detail transaksi
            $.ajax({
                url: '/detailpenjualan/' + detailID,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    // Tampilkan detail transaksi di dalam modal
                    $('#jumlahProduk').text(response.JumlahProduk);
                    $('#subtotal').text(response.Subtotal);

                    // Tampilkan modal
                    $('#detailData').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error jika ada
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>



@section('scripts')
<script>
    $(function() {
        // Ketika tombol detail ditekan
        // Ketika tombol detail ditekan
        $('button[data-bs-target^="#detailData"]').on('click', function() {
            var detailID = $(this).data('detailid');

            // Kirim permintaan AJAX untuk mendapatkan detail transaksi
            $.ajax({
                url: '/detailpenjualan/' + detailID,
                method: 'GET',
                success: function(response) {
                    // Pastikan bahwa response memiliki properti JumlahProduk dan Subtotal
                    if ('JumlahProduk' in response && 'Subtotal' in response) {
                        // Tampilkan detail transaksi di dalam modal
                        $('#jumlahProduk').text(response.JumlahProduk);
                        $('#subtotal').text(response.Subtotal);

                        // Tampilkan modal
                        $('#detailData').modal('show');
                        console.log('Modal dibuka dengan sukses.');
                    } else {
                        console.error('Invalid response format');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error jika ada
                    console.error(xhr.responseText);
                }
            });
        }); -->


@section('scripts')
<script>
    $(function() {
        var table = $('#datatable-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('penjualan.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false
                },
                {
                    data: 'PenjualanID',
                    name: 'PenjualanID'
                },
                {
                    data: 'TanggalPenjualan',
                    name: 'TanggalPenjualan'
                },
                {
                    data: 'TotalHarga',
                    name: 'TotalHarga'
                },
                {
                    data: 'PelangganID',
                    name: 'PelangganID'
                },
            ]
        });

        $('#updateData').on('shown.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var PenjualanID = button.data('PenjualanID');

            // ...

            var html = `
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Data Penjualan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('penjualan.update', ['PenjualanID' => ':PenjualanID']) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="PelangganID" class="form-label">Pelanggan</label>
                    <select class="form-select form-require" name="PelangganID" id="PelangganID">
                        <option selected disabled>Pilih Pelanggan</option>
                        @foreach ($pelanggan as $data)
                            <option value="{{ $data->PelangganID }}">{{ $data->NamaPelanggan }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('PelangganID')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <label for="ProdukID" class="form-label">Produk</label>
                    <select class="form-select form-require" name="ProdukID" id="ProdukID">
                        <option selected disabled>Pilih Produk</option>
                        @foreach ($produk as $data)
                            <option value="{{ $data->ProdukID }}">{{ $data->NamaProduk }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('ProdukID')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <label for="JumlahProduk" class="form-label">Jumlah Produk</label>
                    <input type="text" class="form-control form-require" id="JumlahProduk" name="JumlahProduk" placeholder="Masukkan Jumlah Produk" required>
                    <x-input-error :messages="$errors->get('JumlahProduk')" class="mt-2" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
`;

            // Gantilah ':PenjualanID' dengan nilai PenjualanID
            html = html.replace(':PenjualanID', PenjualanID);
            $('#modal-content').html(html);
        });

    });
</script>
@endsection