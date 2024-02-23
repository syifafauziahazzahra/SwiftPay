<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan; // Perbaiki penulisan nama model
use App\Models\Pelanggan;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Datatables;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class DetailPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Pelanggan::all();

        if ($request->ajax()) {
            $data = DetailPenjualan::where("PetugasID", Auth::User()->id)->get();

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
                <form id="deleteForm" action="' . route('detailpenjualan.destroy', ['DetailID' => $row->DetailID]) . '" method="POST">
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

        $data = DetailPenjualan::with(['produk', 'penjualan.pelanggan'])->where("PetugasID", Auth::id())->get();
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

        DB::table('detailpenjualans')->insert([ // Perbaiki penulisan nama tabel
            'PenjualanID' => $request->PenjualanID,
            'ProdukID' => $request->ProdukID,
            'PetugasID' => Auth::id(),
            'JumlahProduk' => $request->JumlahProduk,
            'Subtotal' => $request->Subtotal,
        ]);
        return redirect()->back()->with(['message' => 'detailpenjualan berhasil ditambahkan', 'status' => 'success']);
    }

    public function printPdf($DetailID)
    {

        $penjualan = DetailPenjualan::findOrFail($DetailID);

        $view = View::make('print', ['data' => $penjualan])->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream('penjualan.pdf', array('Attachment' => 0));
    }

    public function destroy($DetailID)
    {
        DB::table('detailpenjualans')->where('DetailID', $DetailID)->delete(); // Perbaiki penulisan nama tabel
        return redirect()->back()->with(['message' => 'detailpenjualan berhasil di Hapus', 'status' => 'success']);
    }
}
