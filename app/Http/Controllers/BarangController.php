<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $dataBarang = Barang::all(); // Mengambil semua data barang
        return view('master.barang.index', compact('dataBarang'));
    }

    public function edit($kd_brg)
    {
        $dataBarang = Barang::findOrFail($kd_brg);
        return view('master.barang.edit', compact('dataBarang'));
    }

    public function update(Request $request, $kd_brg)
    {
        $barang = Barang::findOrFail($kd_brg);
        $barang->update($request->all());
        return redirect()->route('barang')->with('success', 'Barang berhasil diupdate');
    }
}
