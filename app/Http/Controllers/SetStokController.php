<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class SetStokController extends Controller
{
    public function index()
    {
        $dataBarang = Barang::all();
        return view('Konfigurasi.setstok', compact('dataBarang'));
    }

    public function store(Request $request)
    {
        // Validasi request jika dibutuhkan
        $request->validate([
            'stok_min.*' => 'required|numeric',
            'stok_max.*' => 'required|numeric',
        ]);

        // Loop through each kd_brg and update stok_min and stok_max
        foreach ($request->kd_brg as $key => $kd_brg) {
            $barang = Barang::where('kd_brg', $kd_brg)->first();
            if ($barang) {
                $barang->update([
                    'stok_min' => $request->stok_min[$key],
                    'stok_max' => $request->stok_max[$key],
                ]);
            }
        }

        // Redirect back or to any route
        return redirect()->back()->with('success', 'Stok minimum dan maksimum berhasil diperbarui.');
    }
}
