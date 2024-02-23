<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detailpenjualan';
    protected $primaryKey = 'DetailID';

    // Definisi relasi hasMany dengan DetailPenjualan

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID', 'PenjualanID');
    }
}
