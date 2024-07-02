<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranBarangTable extends Migration
{
    public function up()
    {
        Schema::create('pengeluaran_barang', function (Blueprint $table) {
            $table->char('no_fk', 15)->nullable();
            $table->char('kd_brg', 10)->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('harga')->nullable();
            $table->integer('total_harga')->generatedAlways()->storedAs('(jumlah * harga)');
            $table->foreign('no_fk')->references('no_fk')->on('faktur_pengeluaran');
            $table->foreign('kd_brg')->references('kd_brg')->on('barang');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengeluaran_barang');
    }
}
