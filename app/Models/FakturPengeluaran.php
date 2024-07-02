<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'faktur_pengeluaran'; // Sesuaikan dengan nama tabel di database

    protected $primaryKey = 'no_fk'; // Tentukan primary key

    public $incrementing = false; // Jika primary key bukan integer dan tidak auto increment

    protected $keyType = 'string'; // Jika primary key adalah string

    public $timestamps = false;  // Nonaktifkan timestamps

    protected $fillable = [
        'no_fk',
        'tgl_faktur',
        'total_barang',
        'total_keseluruhan',
    ];
}
