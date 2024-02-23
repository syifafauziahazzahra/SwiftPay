<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class PenjualanController extends Controller
{
    public function print($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $data = [
            'penjualan' => $penjualan
        ];

        $view = View::make('print', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream('penjualan.pdf', array('Attachment' => 0));
    }
}
