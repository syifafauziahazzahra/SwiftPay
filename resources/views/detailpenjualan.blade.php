@extends('layouts.base')

@section('content')
<div class="card p-5">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createData">Tambah DATA</button>
    </div>
    <table class="table datatable-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>Pelanggan</th>
                <th>Tanggal Penjualan</th>
                <th>Produk</th>
                <th>Jumlah Produk</th>
                <th>Subtotal</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->penjualan->pelanggan->NamaPelanggan }}</td>
                <td>{{ $item->penjualan->TanggalPenjualan }}</td>
                <td>{{ $item->produk->NamaProduk }}</td>
                <td>{{ $item->JumlahProduk }}</td>
                <td>{{ $item->Subtotal }}</td>
                <td>
                    @if(isset($item->penjualan))
                    <form id="deleteForm" action="{{ route('penjualan.destroy', ['PenjualanID' => $item->penjualan->PenjualanID]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="DELETE" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> DELETE
                        </button>
                    </form>
                    <a href="{{ route('detailpenjualan.print', ['DetailID' => $item->DetailID]) }}" class="btn btn-sm btn-success" target="_blank">
                        <i class="bi bi-printer"></i> PRINT
                    </a>
                    @endif
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
                <form action="{{ route('detailpenjualan.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ProdukID" class="form-label">ProdukID</label>
                            <select class="form-select form-require" name="ProdukID" id="ProdukID">
                                @foreach ($pelanggan as $data)
                                <option value="{{ $data->ProdukID }}">{{ $data->NamaProduk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="JumlahProduk" class="form-label">JumlahProduk</label>
                            <input type="text" class="form-control form-require" id="JumlahProduk" name="JumlahProduk" placeholder="Masukkan JumlahProduk" required>
                        </div>
                        <div class="mb-3">
                            <label for="Subtotal" class="form-label">Subtotal</label>
                            <input type="text" class="form-control form-require" id="Subtotal" name="Subtotal" placeholder="Masukkan Subtotal" required>
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

@section('scripts')
<script>
    function printPage() {
        window.print();
    }
</script>
@endsection