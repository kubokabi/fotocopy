<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PengeluaranBarang;
use App\Models\FakturPengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('Transaksi.PengeluaranBarang.index', compact('barang'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_brg' => 'required|array',
            'kd_brg.*' => 'required|string',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:1',
            'harga_jual' => 'required|array',
            'harga_jual.*' => 'required|numeric|min:0',
        ]);

        // Check stock minimum before creating invoice
        foreach ($request->kd_brg as $index => $kd_brg) {
            $jumlah = $request->jumlah[$index];

            // Ambil barang dari database berdasarkan kd_brg
            $barang = Barang::where('kd_brg', $kd_brg)->first();

            if ($barang) {
                // Check if stock is below required quantity
                if ($barang->stok < $jumlah) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk barang dengan kode: ' . $kd_brg);
                }

                // Check if stock is below minimum
                if ($barang->stok <= $barang->stok_min) {
                    return redirect()->back()->with('error', 'Stok untuk barang dengan kode: ' . $kd_brg . ' telah mencapai minimum. Silakan lakukan pembelian barang.');
                }
            } else {
                return redirect()->back()->with('error', 'Barang dengan kode: ' . $kd_brg . ' tidak ditemukan.');
            }
        }

        // Set timezone to Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Generate no_faktur
        $now = date('m-y-Hi');
        $no_faktur = 'FK-' . $now;

        // Create faktur Pengeluaran
        $invoice = FakturPengeluaran::create([
            'no_fk' => $no_faktur,
            'tgl_faktur' => date('Y-m-d H:i:s'),
            'total_barang' => count($request->kd_brg),
            'total_keseluruhan' => 0, // Total keseluruhan diisi nanti setelah perhitungan
        ]);

        // Loop through each item
        $total_keseluruhan = 0;
        foreach ($request->kd_brg as $index => $kd_brg) {
            $harga_jual = $request->harga_jual[$index];
            $jumlah = $request->jumlah[$index];
            $total_harga = $harga_jual * $jumlah;

            // Ambil barang dari database berdasarkan kd_brg (tidak perlu lagi karena sudah diambil sebelumnya)

            // Kurangi stok barang
            $barang->stok -= $jumlah;
            $barang->save();

            // Insert into PengeluaranBarang
            PengeluaranBarang::create([
                'no_fk' => $no_faktur,
                'kd_brg' => $kd_brg,
                'jumlah' => $jumlah,
                'harga' => $harga_jual,
            ]);

            // Calculate total_keseluruhan
            $total_keseluruhan += $total_harga;
        }

        // Update total keseluruhan di faktur Pengeluaran
        $invoice->update(['total_keseluruhan' => $total_keseluruhan]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
    }
}
