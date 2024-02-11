<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('produk')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">
                        <button type="button" title="EDIT" class="btn btn-sm btn-biru me-1" data-bs-toggle="modal"
                            data-bs-target="#updateData" data-ProdukID="' . $row->ProdukID . '"
                            data-NamaProduk="' . $row->NamaProduk . '"
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
                ->rawColumns(['action'])
                ->make(true);
        }

        $data = DB::table('produk')->get();
        return view('produk', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'NamaProduk' => 'required',
            'Harga' => 'required',
            'Stok' => 'required',
        ]);


        DB::table('produk')->insert([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
        ]);
        return redirect()->back()->with(['message' => 'produk berhasil ditambahkan', 'status' => 'success']);
    }


    public function update(Request $request, $ProdukID)
    {
        $this->validate($request, [
            'NamaProduk' => 'required',
            'Harga' => 'required',
            'Stok' => 'required',
        ]);

        DB::table('produk')->where('ProdukID', $ProdukID)->update([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
        ]);
        return redirect()->back()->with(['message' => 'produk berhasil di Edit', 'status' => 'success']);
    }



    public function destroy($ProdukID)
    {
        DB::table('produk')->where('ProdukID', $ProdukID)->delete();
        return redirect()->back()->with(['message' => 'produk berhasil di Hapus', 'status' => 'success']);
    }
}
