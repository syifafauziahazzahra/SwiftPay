<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Penjualan::where("PetugasID", Auth::User()->id)->get();

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

        // Metode index()
        $data = Penjualan::with('pelanggan')->where("PetugasID", Auth::id())->get();
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        return view('penjualan', ['data' => $data,  'pelanggan' => $pelanggan, 'produk' => $produk]);
    }


    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'TanggalPenjualan' => 'required',
        //     'TotalHarga' => 'required',
        //     'PelangganID' => 'required',
        // ]);


        // DB::table('penjualan')->insert([
        //      'TanggalPenjualan' => $request->TanggalPenjualan,
        //      'TotalHarga' => $request->TotalHarga,
        //      'PelangganID' => $request->PelangganID,
        // ]);

        $request->validate([
            'ProdukID' => 'required|exists:produk,ProdukID',
            'JumlahProduk' => 'required|integer|min:1',
            'PelangganID' => 'required|exists:pelanggan,PelangganID',
        ]);

        // Buat transaksi baru
        $transaksi = new Penjualan();
        $transaksi->TanggalPenjualan = now(); // Atau sesuaikan dengan tanggal transaksi
        $transaksi->TotalHarga = 0; // Inisialisasi harga total
        $transaksi->PelangganID = $request->input('PelangganID'); // Ambil PelangganID dari form
        $transaksi->PetugasID = Auth::user()->id;
        $transaksi->save();

        // Simpan detail transaksi
        $detail = new DetailPenjualan();
        $detail->PenjualanID = $transaksi->PenjualanID;
        $detail->ProdukID = $request->ProdukID;
        $detail->PetugasID = Auth::user()->id;
        $detail->JumlahProduk = $request->JumlahProduk;
        $detail->Subtotal = Produk::findOrFail($request->ProdukID)->Harga * $request->JumlahProduk;
        $detail->save();

        // Update harga total transaksi
        $transaksi->TotalHarga = $detail->Subtotal;
        $transaksi->save();

        // Update stok produk
        $produk = Produk::findOrFail($request->ProdukID);
        $produk->Stok -= $request->JumlahProduk;
        $produk->save();

        return redirect()->back()->with(['message' => 'penjualan berhasil ditambahkan', 'status' => 'success']);
    }


    // public function update(Request $request, $PenjualanID)
    // {
    //     $this->validate($request, [
    //         'TanggalPenjualan' => 'required',
    //         'TotalHarga' => 'required',
    //         'PelangganID' => 'required',
    //     ]);

    //     DB::table('penjualan')->where('PenjualanID', $PenjualanID)->update([
    //         'TanggalPenjualan' => $request->TanggalPenjualan,
    //         'TotalHarga' => $request->TotalHarga,
    //         'PelangganID' => $request->PelangganID,
    //     ]);
    //     return redirect()->back()->with(['message' => 'penjualan berhasil di Edit', 'status' => 'success']);
    // }



    public function destroy($PenjualanID)
    {
        // Hapus detail penjualan terkait
        DetailPenjualan::where('PenjualanID', $PenjualanID)->delete();

        // Hapus penjualan
        Penjualan::destroy($PenjualanID);

        return redirect()->back()->with(['message' => 'Penjualan berhasil dihapus beserta detailnya', 'status' => 'success']);
    }
}
