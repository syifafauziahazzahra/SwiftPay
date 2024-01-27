@extends('layouts.base')

@section('content')
<div class="card p-5">
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createData">
            Tambah Data
        </button>
    </div>
    <table class="table datatable-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>ACTION</th>
                <th>NAMA</th>
                <th>DESKRIPSI</th>
                <th>HARGA</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td> <button type="button" title="EDIT" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#updateData" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" data-harga="{{ $item->harga }}" data-url="{{ route('menus.update', ['id' => $item->id]) }}">
                        <i class="bi bi-pen"></i>
                        UP
                    </button>
                    <form id="deleteForm" action="{{ route('menus.destroy', ['id' => $item->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="DELETE" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                            DEL
                        </button>
                    </form>
                </td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>{{ $item->harga }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- Modal -->
    <div class="modal fade" id="updateData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateDataLabel" aria-hidden="true">
        <div class="modal-dialog" id="updateDialog">
            <div id="modal-content" class="modal-content">
                <div class="modal-body">
                    Loading..
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="createData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="modal-content" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('menus.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kalimat">name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-require" id="name" name="name" placeholder="Masukan name" required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="description">description <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-require" id="description" description="description" placeholder="Masukan description" required>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label for="prince">prince</label>
                            <input type="text" class="form-control form-require" id="prince" name="prince" placeholder="Masukan prince" required>
                            <x-input-error :messages="$errors->get('prince')" class="mt-2" />
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
            ajax: "{{ route('menus.index') }}",
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'prince',
                    name: 'prince'
                },

            ]
        });
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
                        <label for="name">name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-require" id="name" name="name"
                            placeholder="Masukan name" value="${$(e.relatedTarget).data('name')}" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    </div>
                    <div class="mb-3">
                        <label for="description">description</label>
                        <input type="text" class="form-control form-require" id="description" name="description"
                            placeholder="Masukan description" value="${$(e.relatedTarget).data('description')}" required>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="prince">prince</label>
                        <input type="text" class="form-control form-require" id="prince" name="prince"
                            placeholder="Masukan prince" value="${$(e.relatedTarget).data('prince')}" required>
                        <x-input-error :messages="$errors->get('prince')" class="mt-2" />
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
</script>
@endsection