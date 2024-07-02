<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranBarang;
use App\Models\FakturPengeluaran;

class FakturPengeluaranController extends Controller
{
    public function index()
    {
        // Mengambil data dari tabel FakturPengeluaran
        $fakturPengeluaran = FakturPengeluaran::all();

        // Mengirim data ke view
        return view('Master.FakturPengeluaran.index', compact('fakturPengeluaran'));
    }

    public function view($no_fk)
    {
        // Mengambil data faktur berdasarkan no_fk
        $faktur = FakturPengeluaran::where('no_fk', $no_fk)->firstOrFail();

        // Mengambil data Pengeluaran barang berdasarkan no_fk
        $PengeluaranBarang = PengeluaranBarang::where('no_fk', $no_fk)->get();

        // Mengirim data ke view
        return view('Master.FakturPengeluaran.detail', compact('faktur', 'PengeluaranBarang'));
    }
}
