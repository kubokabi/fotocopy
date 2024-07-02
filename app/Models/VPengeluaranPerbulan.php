<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VPengeluaranPerbulan extends Model
{
    use HasFactory;

    protected $table = 'v_pengeluaran_perbulan';
    public $timestamps = false;

    protected $fillable = [
        'bulan_pengeluaran',
        'total_seluruh_barang',
        'grand_total',
    ];
}
