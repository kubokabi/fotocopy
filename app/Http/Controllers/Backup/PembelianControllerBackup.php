<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\PembelianBarang;
use App\Models\FakturPembelian;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('Transaksi.PembelianBarang.index', compact('barang'));
    }

    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'kd_brg' => 'required|array',
    //         'kd_brg.*' => 'required|string',
    //         'nama_brg' => 'required|array',
    //         'nama_brg.*' => 'required|string',
    //         'satuan' => 'required|array',
    //         'satuan.*' => 'required|string',
    //         'harga' => 'required|array',
    //         'harga.*' => 'required|numeric',
    //         'jumlah' => 'required|array',
    //         'jumlah.*' => 'required|numeric'
    //     ]);

    //     // Set timezone to Asia/Jakarta
    //     date_default_timezone_set('Asia/Jakarta');

    //     // Generate no_faktur
    //     $now = date('m-y-Hi');
    //     $no_faktur = 'F-' . $now;

    //     // Create faktur pembelian
    //     $invoice = FakturPembelian::create([
    //         'no_faktur' => $no_faktur,
    //         'tgl_faktur' => date('Y-m-d H:i:s'),
    //         'total_barang' => count($request->kd_brg), // Jumlah barang bisa dihitung dari array $request->kd_brg
    //         'total_keseluruhan' => 0 // Total keseluruhan diisi nanti setelah perhitungan
    //     ]);

    //     // Loop through each item
    //     $total_keseluruhan = 0;
    //     foreach ($request->kd_brg as $index => $kd_brg) {
    //         $nama_brg = $request->nama_brg[$index];
    //         $satuan = $request->satuan[$index];
    //         $harga_beli = $request->harga[$index];
    //         $jumlah = $request->jumlah[$index];
    //         $total_harga = $harga_beli * $jumlah;

    //         // Update or create barang
    //         // Update or create barang
    //         $barang = Barang::updateOrCreate(
    //             ['kd_brg' => $kd_brg],
    //             [
    //                 'nama_brg' => $nama_brg,
    //                 'satuan' => $satuan,
    //                 'harga_beli' => $harga_beli,
    //             ]
    //         );

    //         // Perbarui stok barang
    //         $barang->stok += $jumlah;
    //         $barang->save();

    //         // Insert into pembelian_barang
    //         PembelianBarang::create([
    //             'no_faktur' => $no_faktur,
    //             'kd_brg' => $kd_brg,
    //             'jumlah' => $jumlah,
    //             'harga' => $harga_beli,
    //         ]);

    //         // Calculate total_keseluruhan
    //         $total_keseluruhan += $total_harga;
    //     }

    //     // Update total keseluruhan di faktur pembelian
    //     $invoice->update(['total_keseluruhan' => $total_keseluruhan]);

    //     return redirect()->back()->with('success', 'Pembelian berhasil disimpan.');
    // }

    // ini benar
    // public function store(Request $request)
    // {
    //     // // Validasi input
    //     $request->validate([
    //         'kd_brg' => 'required|array',
    //         'kd_brg.*' => 'required|string',
    //         'nama_brg' => 'sometimes|array',
    //         'nama_brg.*' => 'sometimes|string',
    //         'satuan' => 'sometimes|array',
    //         'satuan.*' => 'sometimes|string',
    //         'harga' => 'required|array',
    //         'harga.*' => 'required|numeric',
    //         'jumlah' => 'required|array',
    //         'jumlah.*' => 'required|numeric',
    //     ]);

    //     // Set timezone to Asia/Jakarta
    //     date_default_timezone_set('Asia/Jakarta');

    //     // Generate no_faktur
    //     $now = date('m-y-Hi');
    //     $no_faktur = 'F-' . $now;

    //     // Create faktur pembelian
    //     $invoice = FakturPembelian::create([
    //         'no_faktur' => $no_faktur,
    //         'tgl_faktur' => date('Y-m-d H:i:s'),
    //         'total_barang' => count($request->kd_brg),
    //         'total_keseluruhan' => 0, // Total keseluruhan diisi nanti setelah perhitungan
    //     ]);

    //     // Loop through each item
    //     $total_keseluruhan = 0;
    //     foreach ($request->kd_brg as $index => $kd_brg) {
    //         $nama_brg = $request->nama_brg[$index] ?? null;
    //         $satuan = $request->satuan[$index] ?? null;
    //         $harga_beli = $request->harga[$index];
    //         $jumlah = $request->jumlah[$index];
    //         $total_harga = $harga_beli * $jumlah;

    //         // Update or create barang
    //         $barang = Barang::where('kd_brg', $kd_brg)->first();

    //         if ($barang) {
    //             // Update existing barang
    //             $barang->harga_beli = $harga_beli;
    //             $barang->stok += $jumlah;
    //             $barang->save();
    //         } else {
    //             // Create new barang
    //             $barang = Barang::create([
    //                 'kd_brg' => $kd_brg,
    //                 'nama_brg' => $nama_brg,
    //                 'satuan' => $satuan,
    //                 'harga_beli' => $harga_beli,
    //                 'stok' => $jumlah,
    //             ]);
    //         }

    //         // Insert into pembelian_barang
    //         PembelianBarang::create([
    //             'no_faktur' => $no_faktur,
    //             'kd_brg' => $kd_brg,
    //             'jumlah' => $jumlah,
    //             'harga' => $harga_beli,
    //         ]);

    //         // Calculate total_keseluruhan
    //         $total_keseluruhan += $total_harga;
    //     }

    //     // Update total keseluruhan di faktur pembelian
    //     $invoice->update(['total_keseluruhan' => $total_keseluruhan]);

    //     return redirect()->back()->with('success', 'Pembelian berhasil disimpan.');
    // }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_brg' => 'required|array',
            'kd_brg.*' => 'required|string',
            'nama_brg' => 'sometimes|array',
            'nama_brg.*' => 'sometimes|string',
            'satuan' => 'sometimes|array',
            'satuan.*' => 'sometimes|string',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric',
        ]);

        // Set timezone to Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Generate no_faktur
        $now = date('m-y-Hi');
        $no_faktur = 'F-' . $now;

        // Create faktur pembelian
        $invoice = FakturPembelian::create([
            'no_faktur' => $no_faktur,
            'tgl_faktur' => date('Y-m-d H:i:s'),
            'total_barang' => count($request->kd_brg),
            'total_keseluruhan' => 0, // Total keseluruhan diisi nanti setelah perhitungan
        ]);

        // Loop through each item
        $total_keseluruhan = 0;
        foreach ($request->kd_brg as $index => $kd_brg) {
            $nama_brg = $request->nama_brg[$index] ?? null;
            $satuan = $request->satuan[$index] ?? null;
            $harga_beli = $request->harga[$index];
            $jumlah = $request->jumlah[$index];
            $total_harga = $harga_beli * $jumlah;

            //   Update or create barang
            $barang = Barang::where('kd_brg', $kd_brg)->first();

            if ($barang) {
                // Update existing barang
                $barang->harga_beli = $harga_beli;
                $barang->stok += $jumlah;
                $barang->save();
            } else {
                // Create new barang
                $barang = Barang::create([
                    'kd_brg' => $kd_brg,
                    'nama_brg' => $nama_brg,
                    'satuan' => $satuan,
                    'harga_beli' => $harga_beli,
                    'stok' => $jumlah,
                ]);
            }

            // Insert into pembelian_barang
            PembelianBarang::create([
                'no_faktur' => $no_faktur,
                'kd_brg' => $kd_brg,
                'jumlah' => $jumlah,
                'harga' => $harga_beli,
            ]);

            // Calculate total_keseluruhan
            $total_keseluruhan += $total_harga;
        }

        // Update total keseluruhan di faktur pembelian
        $invoice->update(['total_keseluruhan' => $total_keseluruhan]);

        return redirect()->back()->with('success', 'Pembelian berhasil disimpan.');
    }

    public function checkKodeBarang(Request $request)
    {
        $kd_brg = $request->kd_brg;

        // Lakukan validasi apakah kode barang sudah ada
        $barang = Barang::where('kd_brg', $kd_brg)->exists();

        return response()->json(['exists' => $barang]);
    }
}
