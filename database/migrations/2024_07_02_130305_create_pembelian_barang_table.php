<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianBarangTable extends Migration
{
    public function up()
    {
        Schema::create('pembelian_barang', function (Blueprint $table) {
            $table->char('no_faktur', 15)->nullable();
            $table->char('kd_brg', 10)->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('harga')->nullable();
            $table->integer('total_harga')->generatedAlways()->storedAs('(jumlah * harga)');
            $table->foreign('no_faktur')->references('no_faktur')->on('faktur_pembelian');
            $table->foreign('kd_brg')->references('kd_brg')->on('barang');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian_barang');
    }
}
