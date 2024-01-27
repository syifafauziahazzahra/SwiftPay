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
                <th>PENJUALAN ID</th>
                <th>TANGGAL PENJUALAN</th>
                <th>TOTAL HARGA</th>
                <th>PELANGGAN ID</th>
                <th>TOOLS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->PenjualanID }}</td>
                <td>{{ $item->TangganPenjualan }}</td>
                <td>{{ $item->TotalHarga }}</td>
                <td>{{ $item->Pelanggan }}</td>
                <td>
                    <button type="button" title="EDIT" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#updateData" data-ProdukID="{{ $item->ProdukID }}" data-NamaProduk="{{ $item->NamaProduk }}" data-Harga="{{ $item->Harga }}" data-Stok="{{ $item->Stok }}" data-url="{{ route('produk.update', ['ProdukID' => $item->ProdukID]) }}">
                        <i class="bi bi-pen"></i> UPDATE
                    </button>
                    <form id="deleteForm" action="{{ route('penjualan.destroy', ['PenjualanID' => $item->PenjualanID]) }}" method="POST">
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
                <form action="{{ route('penjualan.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="PenjualanID" class="form-label">PenjualanID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-require" id="PenjualanID" name="PenjualanID" placeholder="Masukkan PenjualanID" required>
                            <x-input-error :messages="$errors->get('PenjualanID')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="TanggalPenjualan" class="form-label">TanggalPenjualan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-require" id="TanggalPenjualan" name="TanggalPenjualan" placeholder="Masukkan TanggalPenjualan" required>
                            <x-input-error :messages="$errors->get('TanggalPenjualan')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="TotalHarga" class="form-label">TotalHarga</label>
                            <input type="text" class="form-control form-require" id="TotalHarga" name="TotalHarga" placeholder="Masukkan TotalHarga" required>
                            <x-input-error :messages="$errors->get('TotalHarga')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <ladbel for="PelangganID" class="form-label">PelangganID</label>
                                <input type="text" class="form-control form-require" id="PelangganID" name="PelangganID" placeholder="Masukkan PelangganID" required>
                                <x-input-error :messages="$errors->get('PelangganID')" class="mt-2" />
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

            var html = `
    <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Penjualan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="${$(e.relatedTarget).data('url')}" method="post">
        @csrf
        @method('PATCH')

        <div class="modal-body">
            <div class="mb-3">
                <label for="PenjualanID">PenjualanID <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-require" id="PenjualanID" name="PenjualanID"
                    placeholder="Masukan PenjualanID" value="${$(e.relatedTarget).data('penjualanid')}" required>
                <x-input-error :messages="$errors->get('PenjualanID')" class="mt-2" />
            </div>
            <div class="mb-3">
                <label for="TanggalPenjualan">TanggalPenjualan</label>
                <input type="date" class="form-control form-require" id="TanggalPenjualan" name="TanggalPenjualan"
                    placeholder="Masukan TanggalPenjualan" value="${$(e.relatedTarget).data('tanggalpenjualan')}" required>
                <x-input-error :messages="$errors->get('TanggalPenjualan')" class="mt-2" />
            </div>
            <div class="mb-3">
                <label for="TotalHarga">TotalHarga</label>
                <input type="text" class="form-control form-require" id="TotalHarga" name="TotalHarga"
                    placeholder="Masukan TotalHarga" value="${$(e.relatedTarget).data('totalharga')}" required>
                <x-input-error :messages="$errors->get('TotalHarga')" class="mt-2" />
            </div>
            <div class="mb-3">
                <label for="PelangganID">PelangganID</label>
                <input type="text" class="form-control form-require" id="PelangganID" name="PelangganID"
                    placeholder="Masukan PelangganID" value="${$(e.relatedTarget).data('pelangganid')}" required>
                <x-input-error :messages="$errors->get('PelangganID')" class="mt-2" />
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