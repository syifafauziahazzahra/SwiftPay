<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class MenuController extends Controller
{
    public function index(Request $request)
    {

        // if ($request->ajax()) {
        //     $data = DB::table('menus')->get();

        //     return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->addColumn('action', function ($row) {
        //                 $btn = '<div class="d-flex">
        //                 <button type="button" title="EDIT" class="btn btn-sm btn-biru me-1" data-bs-toggle="modal"
        //                     data-bs-target="#updateData" data-id="' . $row->id . '"
        //                     data-name="' . $row->name . '"
        //                     data-harga="' . $row->harga . '"
        //                     data-url="' . route('menus.update', ['id' => $row->id]) . '">
        //                     <i class="bi bi-pen"></i>
        //                 </button>
        //                 <form id="deleteForm" action="' . route('menus.delete', ['id' => $row->id]) . '" method="POST">
        //                 ' . csrf_field() . '
        //                 ' . method_field('DELETE') . '
        //                     <button type="button" title="DELETE" class="btn btn-sm btn-biru btn-delete" onclick="confirmDelete(event)">
        //                         <i class="bi bi-trash"></i>
        //                     </button>
        //                 </form>
        //                 </div>';
        //                 return $btn;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }

        $data = DB::table('menus')->get();
        return view('menus', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'deskription' => 'required',
            'prince' => 'required',
        ]);


        DB::table('menus')->insert([
            'name' => $request->name,
            'deskription' => $request->deskription,
            'prince' => $request->prince,
        ]);
        return redirect()->back()->with(['message' => 'Menus berhasil ditambahkan', 'status' => 'success']);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'deskription' => 'required',
            'prince' => 'required',
        ]);

        DB::table('menus')->where('id', $id)->update([
            'name' => $request->name,
            'deskription' => $request->deskription,
            'prince' => $request->prince,
        ]);
        return redirect()->back()->with(['message' => 'Menus berhasil di Edit', 'status' => 'success']);
    }



    public function destroy($id)
    {
        DB::table('menus')->where('id', $id)->delete();
        return redirect()->back()->with(['message' => 'Menus berhasil di Hapus', 'status' => 'success']);
    }
}
