<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class PelangganController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('pelanggan')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">
                        <button type="button" title="EDIT" class="btn btn-sm btn-biru me-1" data-bs-toggle="modal"
                            data-bs-target="#updateData" data-PelangganID="' . $row->PelangganID . '"
                            data-PelangganID="' . $row->PelangganID . '"
                            data-NamaPelanggan="' . $row->NamaPelanggan . '"
                            data-Alamat="' . $row->Alamat . '"
                            data-NomorTelepon="' . $row->NomorTelepon . '"
                            data-url="' . route('pelanggan.update', ['PelangganID' => $row->PelangganID]) . '">
                            <i class="bi bi-pen"></i>
                        </button>
                        <form id="deleteForm" action="' . route('pelanggan.delete', ['PelangganID' => $row->PelangganID]) . '" method="POST">
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

        $data = DB::table('pelanggan')->get();
        return view('pelanggan', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'NamaPelanggan' => 'required',
            'Alamat' => 'required',
            'NomorTelepon' => 'required',
        ]);


        DB::table('pelanggan')->insert([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon,
        ]);
        return redirect()->back()->with(['message' => 'pelanggan berhasil ditambahkan', 'status' => 'success']);
    }


    public function update(Request $request, $PelangganID)
    {
        $this->validate($request, [
            'NamaPelanggan' => 'required',
            'Alamat' => 'required',
            'NomorTelepon' => 'required',
        ]);

        DB::table('pelanggan')->where('PelangganID', $PelangganID)->update([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon,
        ]);
        return redirect()->back()->with(['message' => 'pelanggan berhasil di Edit', 'status' => 'success']);
    }



    public function destroy($PelangganID)
    {
        DB::table('pelanggan')->where('PelangganID', $PelangganID)->delete();
        return redirect()->back()->with(['message' => 'pelanggan berhasil di Hapus', 'status' => 'success']);
    }
}
