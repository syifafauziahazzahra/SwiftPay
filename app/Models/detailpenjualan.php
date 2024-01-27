<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detailpenjualan';
    protected $primaryKey = 'DetailID';

    // Definisi relasi BelongsTo dengan Pelanggan
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID', 'PenjualanID');
    }
}
