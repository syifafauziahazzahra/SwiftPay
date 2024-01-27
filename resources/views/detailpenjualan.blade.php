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
                <th>Detail ID</th>
                <th>Penjualan ID</th>
                <th>Produk ID</th>
                <th>Jumlah Produk</th>
                <th>Subtotal</th>
                <th>TOOLS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->DetailID }}</td>
                <td>{{ $item->PenjualanID }}</td>
                <td>{{ $item->ProdukID }}</td>
                <td>{{ $item->JumlahProduk }}</td>
                <td>{{ $item->Subtotal }}</td>
                <td>
                    <button type="button" title="EDIT" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#updateData" data-DetailID="{{ $item->DetailID }}" data-PenjualanID="{{ $item->PenjualanID }}" data-ProdukID="{{ $item->ProdukID }}" data-JumlahProduk="{{ $item->JumlahProduk }}" data-Subtotal="{{ $item->Subtotal }}" data-url="' . route('detailpenjualan.update', ['DetailID' => $row->DetailID
                        ]) }}">
                        <i class="bi bi-pen"></i> UPDATE
                    </button>
                    <form id="deleteForm" action="' . route('detailpenjualan.delete', ['DetailID' => $row->DetailID]) . '" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="DELETE" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> DELETE
                        </button>
                    </form>
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
                            <label for="DetailID" class="form-label">DetailID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-require" id="DetailID" name="DetailID" placeholder="Masukkan DetailID" required>
                            <x-input-error :messages="$errors->get('DetailID')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="PenjualanID" class="form-label">PenjualanID</label>
                            <select class="form-select" id="PenjualanID" name="PenjualanID">
                                <option value="" selected disabled>Pilih Penjualan</option>
                                @foreach($data as $detailPenjualan)
                                <option value="{{ $detailPenjualan->penjualan->PenjualanID }}">{{ $detailPenjualan->penjualan->PelangganID }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('PenjualanID')" class="mt-2" />
                        </div>


                        <div class="mb-3">
                            <label for="ProdukID" class="form-label">ProdukID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-require" id="ProdukID" name="ProdukID" placeholder="Masukkan ProdukID" required>
                            <x-input-error :messages="$errors->get('ProdukID')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="JumlahProduk" class="form-label">JumlahProduk</label>
                            <input type="text" class="form-control form-require" id="JumlahProduk" name="JumlahProduk" placeholder="Masukkan JumlahProduk" required>
                            <x-input-error :messages="$errors->get('JumlahProduk')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="Subtotal" class="form-label">Subtotal</label>
                            <input type="text" class="form-control form-require" id="Subtotal" name="Subtotal" placeholder="Masukkan Subtotal" required>
                            <x-input-error :messages="$errors->get('Subtotal')" class="mt-2" />
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
    $(function() {
        var table = $('#datatable-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('detailpenjualan.index') }}",
            columns: [{
                    data: 'DetailID',
                    name: 'DetailID'
                },
                {
                    data: 'PenjualanID',
                    name: 'PenjualanID'
                },
                {
                    data: 'ProdukID',
                    name: 'ProdukID'
                },
                {
                    data: 'JumlahProduk',
                    name: 'JumlahProduk'
                },
                {
                    data: 'Subtotal',
                    name: 'Subtotal'
                },
            ]
        });

        $('#updateData').on('shown.bs.modal', function(e) {
            var html = `
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Quote</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="${$(e.relatedTarget).data('url')}" method="post">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="DetailID">DetailID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-require" id="DetailID" name="DetailID"
                        placeholder="Masukan DetailID" value="${$(e.relatedTarget).data('detailid')}" required>
                    <x-input-error :messages="$errors->get('DetailID')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="PenjualanID">PenjualanID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-require" id="PenjualanID" name="PenjualanID"
                        placeholder="Masukan PenjualanID" value="${$(e.relatedTarget).data('penjualanid')}" required>
                    <x-input-error :messages="$errors->get('PenjualanID')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="ProdukID">ProdukID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-require" id="ProdukID" name="ProdukID"
                        placeholder="Masukan ProdukID" value="${$(e.relatedTarget).data('produkid')}" required>
                    <x-input-error :messages="$errors->get('ProdukID')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="JumlahProduk">JumlahProduk</label>
                    <input type="text" class="form-control form-require" id="JumlahProduk" name="JumlahProduk"
                        placeholder="Masukan JumlahProduk" value="${$(e.relatedTarget).data('jumlahproduk')}" required>
                    <x-input-error :messages="$errors->get('JumlahProduk')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="Subtotal">Subtotal</label>
                    <input type="text" class="form-control form-require" id="Subtotal" name="Subtotal"
                        placeholder="Masukan Subtotal" value="${$(e.relatedTarget).data('subtotal')}" required>
                    <x-input-error :messages="$errors->get('Subtotal')" class="mt-2" />
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    `;
            $('#modal-content').html(html);
        });

    });
</script>
@endsection