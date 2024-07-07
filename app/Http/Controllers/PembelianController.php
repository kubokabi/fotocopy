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

        // Check stok maksimum sebelum membuat faktur pembelian
        $warningMessages = [];
        foreach ($request->kd_brg as $index => $kd_brg) {
            $jumlah = $request->jumlah[$index];

            // Ambil data barang dari database
            $barang = Barang::where('kd_brg', $kd_brg)->first();

            if ($barang) {
                // Periksa apakah stok akan melebihi stok maksimum
                $projected_stok = $barang->stok + $jumlah;
                if ($projected_stok >= $barang->stok_max) {
                    $warningMessages[] = 'Stok untuk barang dengan kode: ' . $kd_brg . ' sudah mencapai maksimum. Pembelian tidak dapat dilakukan.';
                }
            }
        }

        // Jika terdapat pesan peringatan, kembalikan ke halaman sebelumnya dengan pesan error
        if (!empty($warningMessages)) {
            return redirect()->back()->with('error', implode(' ', $warningMessages));
        }

        // Generate no_faktur berdasarkan waktu saat ini
        $now = date('m-y-Hi');
        $tgl= date('j');
        $no_faktur = $tgl . 'F-' . $now;

        // Buat faktur pembelian baru
        $invoice = FakturPembelian::create([
            'no_faktur' => $no_faktur,
            'tgl_faktur' => date('Y-m-d H:i:s'),
            'total_barang' => count($request->kd_brg),
            'total_keseluruhan' => 0, // Total keseluruhan diisi nanti setelah perhitungan
        ]);

        // Loop untuk setiap barang yang dibeli
        $total_keseluruhan = 0;
        foreach ($request->kd_brg as $index => $kd_brg) {
            $nama_brg = $request->nama_brg[$index] ?? null;
            $satuan = $request->satuan[$index] ?? null;
            $harga_beli = $request->harga[$index];
            $jumlah = $request->jumlah[$index];
            $total_harga = $harga_beli * $jumlah;

            // Periksa apakah barang sudah ada atau belum
            $barang = Barang::where('kd_brg', $kd_brg)->first();

            if ($barang) {
                // Update barang yang sudah ada
                $barang->harga_beli = $harga_beli;
                $barang->stok += $jumlah;
                $barang->save();
            } else {
                // Buat barang baru jika belum ada
                $barang = Barang::create([
                    'kd_brg' => $kd_brg,
                    'nama_brg' => $nama_brg,
                    'satuan' => $satuan,
                    'harga_beli' => $harga_beli,
                    'stok' => $jumlah,
                ]);
            }

            // Simpan pembelian barang ke dalam database
            PembelianBarang::create([
                'no_faktur' => $no_faktur,
                'kd_brg' => $kd_brg,
                'jumlah' => $jumlah,
                'harga' => $harga_beli,
            ]);

            // Hitung total keseluruhan harga pembelian
            $total_keseluruhan += $total_harga;
        }

        // Update total keseluruhan di faktur pembelian
        $invoice->update(['total_keseluruhan' => $total_keseluruhan]);

        // Redirect kembali dengan pesan sukses
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
