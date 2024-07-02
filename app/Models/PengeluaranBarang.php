<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranBarang extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran_barang'; // Sesuaikan dengan nama tabel di database

    public $timestamps = false;  // Nonaktifkan timestamps

    protected $fillable = [
        'no_fk',
        'kd_brg',
        'jumlah',
        'harga',
        'total_harga'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_brg', 'kd_brg');
    }
}
