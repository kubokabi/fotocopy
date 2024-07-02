<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakturPembelianTable extends Migration
{
    public function up()
    {
        Schema::create('faktur_pembelian', function (Blueprint $table) {
            $table->char('no_faktur', 15)->primary();
            $table->date('tgl_faktur')->nullable();
            $table->integer('total_barang')->nullable();
            $table->integer('total_keseluruhan')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faktur_pembelian');
    }
}
