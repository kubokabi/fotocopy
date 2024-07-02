<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VPembelianPerbulan extends Model
{
    use HasFactory;

    protected $table = 'v_pembelian_perbulan';
    public $timestamps = false;
}
