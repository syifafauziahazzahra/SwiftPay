<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $primaryKey = 'PenjualanID';

    // Definisi relasi BelongsTo dengan Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'PenjualanID', 'PenjualanID');
    }
}

