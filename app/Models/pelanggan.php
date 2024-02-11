<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'PelangganID';

    // Definisi relasi One-to-Many dengan Penjualan
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'PelangganID', 'PelangganID');
    }
}
