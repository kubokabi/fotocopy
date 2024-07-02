<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang'; // Sesuaikan dengan nama tabel di database

    protected $primaryKey = 'kd_brg'; // Tentukan primary key

    public $incrementing = false; // Jika primary key bukan integer dan tidak auto increment

    protected $keyType = 'string'; // Jika primary key adalah string

    public $timestamps = false;  // Nonaktifkan timestamps

    protected $fillable = [
        'kd_brg',
        'nama_brg',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_min',
        'stok_max'
    ];
}
