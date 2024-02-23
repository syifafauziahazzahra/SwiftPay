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
                <th>NAMA PRODUK</th>
                <th>Gambar Produk</th>
                <th>HARGA</th>
                <th>STOK</th>
                <th>TOOLS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <!-- <td>{{ $item->ProdukID }}</td> -->
                <td>{{ $item->NamaProduk }}</td>
                <td><img src="{{ asset("storage/produks/" . $item->Gambar) }}" width="100" height="75" /></td>
                <td>{{ $item->Harga }}</td>
                <td>{{ $item->Stok }}</td>
                <td>
                    <button type="button" title="EDIT" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#updateData" data-ProdukID="{{ $item->ProdukID }}" data-NamaProduk="{{ $item->NamaProduk }}" data-Harga="{{ $item->Harga }}" data-Stok="{{ $item->Stok }}" data-Gambar="{{ $item->Gambar }}" data-url="{{ route('produk.update', ['ProdukID' => $item->ProdukID]) }}">
                        <i class="bi bi-pen"></i> PERBARUI
                    </button>
                    <form id="deleteForm" action="{{ route('produk.destroy', ['ProdukID' => $item->ProdukID]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="DELETE" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> HAPUS
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('produk.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class=" modal-body">
                        <!-- <div class="mb-3">
                            <label for="ProdukID" class="form-label">ProdukID </label>
                            <input type="text" class="form-control form-require" id="ProdukID" name="ProdukID" placeholder="Masukkan ProdukID" required>
                            <x-input-error :messages="$errors->get('ProdukID')" class="mt-2" />
                        </div> -->

                        <div class="mb-3">
                            <label for="NamaProduk" class="form-label">Nama Produk </label>
                            <input type="text" class="form-control form-require" id="NamaProduk" name="NamaProduk" placeholder="Masukkan Nama Produk" required>
                            <x-input-error :messages="$errors->get('NamaProduk')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="Gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control form-require" id="Gambar" name="Gambar" placeholder="Masukkan Gambar Produk" required>
                            <x-input-error :messages="$errors->get('Gambar')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="Harga" class="form-label">Harga Produk</label>
                            <input type="text" class="form-control form-require" id="Harga" name="Harga" placeholder="Masukkan Harga Produk" required>
                            <x-input-error :messages="$errors->get('Harga')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <ladbel for="Stok" class="form-label">Stok Produk</label>
                                <input type="text" class="form-control form-require" id="Stok" name="Stok" placeholder="Masukkan Stok Produk" required>
                                <x-input-error :messages="$errors->get('Stok')" class="mt-2" />
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
            ajax: "{{ route('produk.index') }}",
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
                    data: 'ProdukID',
                    name: 'ProdukID'
                },
                {
                    data: 'NamaProduk',
                    name: 'NamaProduk'
                },
               
                {
                    data: 'Harga',
                    name: 'Harga'
                },
                {
                    data: 'Stok',
                    name: 'Stok'
                },
            ]
        });

        $('#updateData').on('shown.bs.modal', function(e) {
            var html = `
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Data Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="${$(e.relatedTarget).data('url')}" method="post">
                    @csrf
                    @method('PATCH')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="NamaProduk">Nama Produk </label>
                            <input type="text" class="form-control form-require" id="NamaProduk" name="NamaProduk"
                                placeholder="Masukan Nama Produk" value="${$(e.relatedTarget).data('namaproduk')}" required>
                            <x-input-error :messages="$errors->get('NamaProduk')" class="mt-2" />
                       
                        <div class="mb-3">
                            <label for="Harga">Harga Produk</label>
                            <input type="text" class="form-control form-require" id="Harga" name="Harga"
                                placeholder="Masukan Harga" value="${$(e.relatedTarget).data('harga')}" required>
                            <x-input-error :messages="$errors->get('Harga')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="Stok">Stok Produk</label>
                            <input type="text" class="form-control form-require" id="Stok" name="Stok"
                                placeholder="Masukan Stok" value="${$(e.relatedTarget).data('stok')}" required>
                            <x-input-error :messages="$errors->get('Stok')" class="mt-2" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            `;
            $('#modal-content').html(html);

            // Fill input file with current image
            var currentImage = "${$(e.relatedTarget).data('gambar')}";
            if (currentImage) {
                $('#Gambar').val(currentImage);
            }
        });
    });
</script>
@endsection