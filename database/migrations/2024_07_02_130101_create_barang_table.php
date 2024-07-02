<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->char('kd_brg', 10)->primary();
            $table->char('nama_brg', 35)->nullable();
            $table->char('satuan', 15)->nullable();
            $table->integer('harga_beli')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('stok_min')->nullable();
            $table->integer('stok_max')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
