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
                <th>Pelanggan ID</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>TOOLS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->PelangganID }}</td>
                <td>{{ $item->NamaPelanggan }}</td>
                <td>{{ $item->Alamat }}</td>
                <td>{{ $item->NomorTelepon }}</td>
                <td>
                    <button type="button" title="EDIT" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#updateData" data-PelangganID="{{ $item->PelangganID }}" data-NamaPelanggan="{{ $item->NamaPelanggan }}" data-Alamat="{{ $item->Alamat }}" data-NomorTelepon="{{ $item->NomorTelepon }}" data-url="{{ route('pelanggan.update', ['PelangganID' => $item->PelangganID]) }}">
                        <i class="bi bi-pen"></i> UPDATE
                    </button>
                    <form id="deleteForm" action="{{ route('pelanggan.destroy', ['PelangganID' => $item->PelangganID]) }}" method="POST">
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
                <form action="{{ route('pelanggan.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="PelangganID" class="form-label">PelangganID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-require" id="PelangganID" name="PelangganID" placeholder="Masukkan PelangganID" required>
                            <x-input-error :messages="$errors->get('PelangganID')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="NamaPelanggan" class="form-label">NamaPelanggan</label>
                            <input type="text" class="form-control form-require" id="NamaPelanggan" name="NamaPelanggan" placeholder="Masukkan NamaPelanggan" required>
                            <x-input-error :messages="$errors->get('NamaPelanggan')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <ladbel for="Alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control form-require" id="Alamat" name="Alamat" placeholder="Masukkan Alamat" required>
                                <x-input-error :messages="$errors->get('Alamat')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <ladbel for="NomorTelepon" class="form-label">NomorTelepon</label>
                                <input type="text" class="form-control form-require" id="NomorTelepon" name="NomorTelepon" placeholder="Masukkan NomorTelepon" required>
                                <x-input-error :messages="$errors->get('NomorTelepon')" class="mt-2" />
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
            ajax: "{{ route('pelanggan.index') }}",
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
                    data: 'PelangganID',
                    name: 'PelangganID'
                },
                {
                    data: 'NamaPelanggan',
                    name: 'NamaPelanggan'
                },
                {
                    data: 'Alamat',
                    name: 'Alamat'
                },
                {
                    data: 'NomorTelepon',
                    name: 'NomorTelepon'
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
                            <label for="PelangganID">PelangganID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-require" id="PelangganID" name="PelangganID"
                                placeholder="Masukan PelangganID" value="${$(e.relatedTarget).data('pelangganid')}" required>
                            <x-input-error :messages="$errors->get('PelangganID')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="NamaPelanggan">NamaPelanggan</label>
                            <input type="text" class="form-control form-require" id="NamaPelanggan" name="NamaPelanggan"
                                placeholder="Masukan NamaPelanggan" value="${$(e.relatedTarget).data('namapelanggan')}" required>
                            <x-input-error :messages="$errors->get('NamaPelanggan')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="Alamat">Alamat</label>
                            <input type="text" class="form-control form-require" id="Alamat" name="Alamat"
                                placeholder="Masukan Alamat" value="${$(e.relatedTarget).data('alamat')}" required>
                            <x-input-error :messages="$errors->get('Alamat')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="NomorTelepon">NomorTelepon</label>
                            <input type="text" class="form-control form-require" id="NomorTelepon" name="NomorTelepon"
                                placeholder="Masukan NomorTelepon" value="${$(e.relatedTarget).data('nomortelepon')}" required>
                            <x-input-error :messages="$errors->get('NomorTelepon')" class="mt-2" />
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