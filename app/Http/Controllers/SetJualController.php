<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;


class SetJualController extends Controller
{
    public function index()
    {
        $dataBarang = Barang::all();
        return view('Konfigurasi.setjual', compact('dataBarang'));
    }

    public function store(Request $request)
    {
        // Validasi request jika dibutuhkan
        $request->validate([
            'harga_beli.*' => 'required|numeric',
            'harga_jual.*' => 'required|numeric',
        ]);

        // Loop through each kd_brg and update harga_beli and harga_jual
        foreach ($request->kd_brg as $key => $kd_brg) {
            $barang = Barang::where('kd_brg', $kd_brg)->first();
            if ($barang) {
                $barang->update([
                    'harga_beli' => $request->harga_beli[$key],
                    'harga_jual' => $request->harga_jual[$key],
                ]);
            }
        }

        // Redirect back or to any route
        return redirect()->back()->with('success', 'Harga berhasil diperbarui.');
    }
}
