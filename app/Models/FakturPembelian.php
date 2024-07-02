<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturPembelian extends Model
{
    use HasFactory;
    protected $table = 'faktur_pembelian'; // Sesuaikan dengan nama tabel di database

    protected $primaryKey = 'no_faktur'; // Tentukan primary key

    public $incrementing = false; // Jika primary key bukan integer dan tidak auto increment

    protected $keyType = 'string'; // Jika primary key adalah string

    public $timestamps = false;  // Nonaktifkan timestamps

    protected $fillable = [
        'no_faktur',
        'tgl_faktur',
        'total_barang',
        'total_keseluruhan',
    ];
}
