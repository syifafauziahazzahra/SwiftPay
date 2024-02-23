<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'PenjualanID';

    // Definisi relasi HasMany dengan DetailPenjualan
    public function detailPenjualans()
    {
        return $this->hasOne(DetailPenjualan::class, 'PenjualanID', 'PenjualanID');
    }

    // Relasi BelongsTo dengan Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID');
    }
}
