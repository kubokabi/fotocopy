<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateViews extends Migration
{
    public function up()
    {
        DB::statement('
            CREATE VIEW v_pembelian_perbulan AS
            SELECT DATE_FORMAT(tgl_faktur, "%Y-%m") AS bulan_pembelian,
                   SUM(total_barang) AS total_seluruh_barang,
                   SUM(total_keseluruhan) AS grand_total
            FROM faktur_pembelian
            GROUP BY DATE_FORMAT(tgl_faktur, "%Y-%m")
        ');

        DB::statement('
            CREATE VIEW v_pengeluaran_perbulan AS
            SELECT DATE_FORMAT(tgl_faktur, "%Y-%m") AS bulan_pengeluaran,
                   SUM(total_barang) AS total_seluruh_barang,
                   SUM(total_keseluruhan) AS grand_total
            FROM faktur_pengeluaran
            GROUP BY DATE_FORMAT(tgl_faktur, "%Y-%m")
        ');

        DB::statement('
            CREATE VIEW v_penjualan AS
            SELECT fp.tgl_faktur AS tgl_trans,
                   b.nama_brg AS nama_brg,
                   b.satuan AS satuan,
                   b.harga_beli AS harga_beli,
                   b.harga_jual AS harga_jual,
                   pb.jumlah AS terjual,
                   pb.total_harga AS total_jual,
                   (pb.total_harga - b.harga_beli * pb.jumlah) AS margin
            FROM faktur_pengeluaran fp
            JOIN pengeluaran_barang pb ON fp.no_fk = pb.no_fk
            JOIN barang b ON pb.kd_brg = b.kd_brg
        ');

        DB::statement('
            CREATE VIEW v_stok_barang AS
            SELECT b.kd_brg AS kode,
                   b.nama_brg AS nama,
                   b.satuan AS satuan,
                   COALESCE(penjualan.total_penjualan, 0) AS terjual,
                   b.stok AS stok_tersisa
            FROM barang b
            LEFT JOIN (
                SELECT pb.kd_brg AS kd_brg,
                       SUM(pb.jumlah) AS total_penjualan
                FROM pengeluaran_barang pb
                GROUP BY pb.kd_brg
            ) penjualan ON b.kd_brg = penjualan.kd_brg
        ');
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_pembelian_perbulan');
        DB::statement('DROP VIEW IF EXISTS v_pengeluaran_perbulan');
        DB::statement('DROP VIEW IF EXISTS v_penjualan');
        DB::statement('DROP VIEW IF EXISTS v_stok_barang');
    }
}
