<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\PembelianBarang;
use App\Models\FakturPembelian;

class FakturPembelianController extends Controller
{
    public function index()
    {
        // Mengambil data dari tabel FakturPembelian
        $fakturPembelian = FakturPembelian::all();

        // Mengirim data ke view
        return view('Master.FakturPembelian.index', compact('fakturPembelian'));
    }

    public function view($no_faktur)
    {
        // Mengambil data faktur berdasarkan no_faktur
        $faktur = FakturPembelian::where('no_faktur', $no_faktur)->firstOrFail();

        // Mengambil data pembelian barang berdasarkan no_faktur
        $pembelianBarang = PembelianBarang::where('no_faktur', $no_faktur)->get();

        // Mengirim data ke view
        return view('Master.FakturPembelian.detail', compact('faktur', 'pembelianBarang'));
    }
}
