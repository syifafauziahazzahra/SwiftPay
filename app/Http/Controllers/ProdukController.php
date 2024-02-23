<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('produk')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn(
                    'Gambar',
                    function ($row) {
                        return  '<img src="' . asset("storage/images/" . $row->Gambar) . '" width="100" height="75"/>';
                    }
                )
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">
                        <button type="button" title="EDIT" class="btn btn-sm btn-biru me-1" data-bs-toggle="modal"
                            data-bs-target="#updateData" data-ProdukID="' . $row->ProdukID . '"
                            data-NamaProduk="' . $row->NamaProduk . '"
                            data-Gambar="' . $row->Gambar . '"
                            data-Harga="' . $row->Harga . '"
                            data-Stok="' . $row->Stok . '"
                            data-url="' . route('produk.update', ['ProdukID' => $row->ProdukID]) . '">
                            <i class="bi bi-pen"></i>
                        </button>
                        <form id="deleteForm" action="' . route('produk.delete', ['ProdukID' => $row->ProdukID]) . '" method="POST">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                            <button type="button" title="DELETE" class="btn btn-sm btn-biru btn-delete" onclick="confirmDelete(event)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['action', 'Gambar'])
                ->make(true);
        }

        $data = DB::table('produk')->get();
        return view('produk', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'NamaProduk' => 'required',
            'Gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'Harga' => 'required',
            'Stok' => 'required',
        ]);

        $file = $request->file('Gambar');
        $fileName = 'IMG-' . time() . '-' . $file->getClientOriginalName();
        Storage::disk('public')->put('produks/' . $fileName, file_get_contents($file));

        DB::table('produk')->insert([
            'NamaProduk' => $request->NamaProduk,
            'Gambar' => $fileName,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
        ]);
        return redirect()->back()->with(['message' => 'Produk berhasil ditambahkan', 'status' => 'success']);
    }


    public function update(Request $request, $ProdukID)
    {
        $this->validate($request, [
            'NamaProduk' => 'required',
            'Harga' => 'required',
            'Stok' => 'required',
        ]);

        // Ambil data produk yang akan diperbarui
        $produk = DB::table('produk')->where('ProdukID', $ProdukID)->first();

        // Pastikan bahwa data gambar tetap sama dengan gambar yang ada
        $updateData = [
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
            'Gambar' => $produk->Gambar, // Gunakan gambar yang sudah ada
        ];

        // Lakukan pembaruan data produk
        DB::table('produk')->where('ProdukID', $ProdukID)->update($updateData);

        return redirect()->back()->with(['message' => 'Produk berhasil diubah', 'status' => 'success']);
    }


    public function destroy($ProdukID)
    {
        $produk = DB::table('produk')->where('ProdukID', $ProdukID)->first();

        // Hapus gambar terkait dari penyimpanan
        Storage::disk('public')->delete('produks/' . $produk->Gambar);

        // Hapus data produk dari database
        DB::table('produk')->where('ProdukID', $ProdukID)->delete();

        return redirect()->back()->with(['message' => 'Produk berhasil dihapus', 'status' => 'success']);
    }
}
