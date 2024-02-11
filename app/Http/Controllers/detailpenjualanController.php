<?php

namespace App\Http\Controllers;

use App\Models\detailpenjualan;
use App\Models\Pelanggan;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class detailpenjualanController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Pelanggan::all(); // Pindahkan ini ke luar kondisi

        if ($request->ajax()) {
            $data = DetailPenjualan::with(['produk', 'penjualan.pelanggan'])->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">
                <button type="button" title="EDIT" class="btn btn-sm btn-biru me-1" data-bs-toggle="modal"
                    data-bs-target="#updateData" data-DetailID="' . $row->DetailID . '"
                    data-DetailID="' . $row->DetailID . '"
                    data-PenjualanID="' . $row->PenjualanID . '"
                    data-ProdukID="' . $row->ProdukID . '"
                    data-JumlahProduk="' . $row->JumlahProduk . '"
                    data-Subtotal="' . $row->Subtotal . '"
                    data-url="' . route('detailpenjualan.update', ['DetailID' => $row->DetailID]) . '">
                    <i class="bi bi-pen"></i>
                </button>
                <form id="deleteForm" action="' . route('detailpenjualan.delete', ['DetailID' => $row->DetailID]) . '" method="POST">
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

        $data = DetailPenjualan::with(['produk', 'penjualan.pelanggan'])->get();
        return view('detailpenjualan', ['data' => $data, 'pelanggan' => $pelanggan]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'PenjualanID' => 'required',
            'ProdukID' => 'required',
            'JumlahProduk' => 'required',
            'Subtotal' => 'required',
        ]);


        DB::table('detailpenjualan')->insert([
            'PenjualanID' => $request->PenjualanID,
            'ProdukID' => $request->ProdukID,
            'JumlahProduk' => $request->JumlahProduk,
            'Subtotal' => $request->Subtotal,
        ]);
        return redirect()->back()->with(['message' => 'detailpenjualan berhasil ditambahkan', 'status' => 'success']);
    }


    public function printPdf($DetailID)
    {
        $detailpenjualan = DetailPenjualan::findOrFail($DetailID);

        // Load view untuk PDF
        $pdf = PDF::loadView('detailpenjualan.print', compact('detailpenjualan'));
        // Download PDF
        return $pdf->download('detailpenjualan.pdf');
    }




    public function destroy($DetailID)
    {
        DB::table('detailpenjualan')->where('DetailID', $DetailID)->delete();
        return redirect()->back()->with(['message' => 'detailpenjualan berhasil di Hapus', 'status' => 'success']);
    }
}
