<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('penjualan')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">
                        <button type="button" title="EDIT" class="btn btn-sm btn-biru me-1" data-bs-toggle="modal"
                            data-bs-target="#updateData" data-PenjualanID="' . $row->PenjualanID . '"
                            data-TanggalPenjualan="' . $row->TanggalPenjualan . '"
                            data-TotalHarga="' . $row->TotalHarga . '"
                            data-PelangganID="' . $row->PelangganID . '"
                            data-url="' . route('penjualan.update', ['PenjualanID' => $row->PenjualanID]) . '">
                            <i class="bi bi-pen"></i>
                        </button>
                        <form id="deleteForm" action="' . route('penjualan.delete', ['PenjualanID' => $row->PenjualanID]) . '" method="POST">
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

        $data = DB::table('penjualan')->get();
        return view('penjualan', ['data' => $data]);
    }
    

    public function store(Request $request)
    {
        $this->validate($request, [
            'PenjualanID' => 'required',
            'TanggalPenjualan' => 'required',
            'TotalHarga' => 'required',
            'PelangganID' => 'required',
        ]);


        DB::table('penjualan')->insert([
            'PenjualanID' => $request->PenjualanID,
            'TanggalPenjualan' => $request->TanggalPenjualan,
            'TotalHarga' => $request->TotalHarga,
            'PelangganID' => $request->PelangganID,
        ]);
        return redirect()->back()->with(['message' => 'penjualan berhasil ditambahkan', 'status' => 'success']);
    }


    public function update(Request $request, $PenjualanID)
    {
        $this->validate($request, [
            'PenjualanID' => 'required',
            'TanggalPenjualan' => 'required',
            'TotalHarga' => 'required',
            'PelangganID' => 'required',
        ]);

        DB::table('penjualan')->where('PenjualanID', $PenjualanID)->update([
            'PenjualanID' => $request->PenjualanID,
            'TanggalPenjualan' => $request->TanggalPenjualan,
            'TotalHarga' => $request->TotalHarga,
            'PelangganID' => $request->PelangganID,
        ]);
        return redirect()->back()->with(['message' => 'penjualan berhasil di Edit', 'status' => 'success']);
    }



    public function destroy($PenjualanID)
    {
        DB::table('penjualan')->where('PenjualanID', $PenjualanID)->delete();
        return redirect()->back()->with(['message' => 'penjualan berhasil di Hapus', 'status' => 'success']);
    }
}
