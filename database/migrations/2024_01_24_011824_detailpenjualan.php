<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('detailpenjualan', function (Blueprint $table) {
            $table->id('DetailID');
            $table->unsignedBigInteger('PenjualanID');
            $table->unsignedBigInteger('ProdukID');
            $table->integer('JumlahProduk');
            $table->decimal('Subtotal', 7, 2);
            $table->timestamps();

            $table->foreign('PenjualanID')->references('PenjualanID')->on('penjualan');
            $table->foreign('ProdukID')->references('ProdukID')->on('produk');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detailpenjualan');
    }
};
