<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VStokBarang;
use App\Models\VPenjualan;
use App\Models\VPengeluaranPerbulan;
use App\Models\VPembelianPerbulan;
use App\Exports\PembelianPerbulanExport;
use App\Exports\PengeluaranPerbulanExport;
use App\Exports\PenjualanExport;
use App\Exports\StokBarangExport;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function stokBarang()
    {
        $stokBarang = VStokBarang::all();
        return view('laporan.stok_barang', compact('stokBarang'));
    }

    public function penjualan()
    {
        $penjualan = VPenjualan::all();
        return view('laporan.penjualan', compact('penjualan'));
    }

    public function pengeluaranPerbulan()
    {
        $pengeluaranPerbulan = VPengeluaranPerbulan::all();

        // Konversi angka bulan ke nama bulan dalam bahasa Indonesia
        $pengeluaranPerbulan->each(function ($pengeluaran) {
            $pengeluaran->nama_bulan_pengeluaran = $this->getNamaBulanPengeluaran($pengeluaran->bulan_pengeluaran);
        });

        return view('laporan.pengeluaran_perbulan', compact('pengeluaranPerbulan'));
    }

    public function pembelianPerbulan()
    {
        $pembelianPerbulan = VPembelianPerbulan::all();

        // Konversi angka bulan ke nama bulan dalam bahasa Indonesia
        $pembelianPerbulan->each(function ($pembelian) {
            $pembelian->nama_bulan_pembelian = $this->getNamaBulanPembelian($pembelian->bulan_pembelian);
        });

        return view('laporan.pembelian_perbulan', compact('pembelianPerbulan'));
    }

    // Laporan Pembelian
    private function getNamaBulanPembelian($bulanPembelian)
    {
        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        // Pisahkan tahun dan bulan
        list($tahun, $bulan) = explode('-', $bulanPembelian);

        // Kembalikan format "Bulan Tahun"
        return $namaBulan[$bulan] . ' ' . $tahun;
    }

    public function exportPdfPembelian()
    {
        $pembelianPerbulan = VPembelianPerbulan::all();

        // Mengubah setiap bulan menjadi nama bulan
        $pembelianPerbulan->each(function ($pembelian) {
            $pembelian->nama_bulan_pembelian = $this->getNamaBulanPembelian($pembelian->bulan_pembelian);
        });

        // Menghitung grand total jumlah dan total pembelian
        $grandTotalJumlah = $pembelianPerbulan->sum('total_seluruh_barang');
        $grandTotalPembelian = $pembelianPerbulan->sum('grand_total');

        // Waktu saat ini untuk penamaan file
        date_default_timezone_set('Asia/Jakarta');
        $currentTime = Carbon::now()->format('yy_His');

        // HTML untuk laporan
        $html = '
        <html>
        <head>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .text-center {
                text-align: center;
            }
            .grand-total {
                font-weight: bold;
            }
        </style>
        </head>
        <body>
        <h1>Laporan Pembelian Perbulan</h1>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Total Pembelian</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($pembelianPerbulan as $pembelian) {
            $html .= '
            <tr>
                <td>' . $pembelian->nama_bulan_pembelian . '</td>
                <td class="text-center">' . $pembelian->total_seluruh_barang . ' Barang</td>
                <td class="text-center">' . formatRupiah($pembelian->grand_total) . '</td>
            </tr>';
        }

        $html .= '
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">Grand Total</th>
                    <th class="text-center">' . $grandTotalJumlah . ' Barang</th>
                    <th class="text-center">' . formatRupiah($grandTotalPembelian) . '</th>
                </tr>
            </tfoot>
        </table>
        </body>
        </html>';

        // Buat PDF menggunakan DomPDF
        $pdf = PDF::loadHTML($html);
        return $pdf->download('laporan_pembelian_perbulan_' . $currentTime . '.pdf');
    }

    public function exportExcelPembelian()
    {
        // Waktu saat ini untuk penamaan file
        date_default_timezone_set('Asia/Jakarta');
        $currentTime = Carbon::now()->format('yy_His');
        return Excel::download(new PembelianPerbulanExport, 'laporan_pembelian_perbulan_' . $currentTime . '.xlsx');
    }

    // Laporan Pengeluaran
    private function getNamaBulanPengeluaran($bulanPengeluaran)
    {
        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        // Pisahkan tahun dan bulan
        list($tahun, $bulan) = explode('-', $bulanPengeluaran);

        // Kembalikan format "Bulan Tahun"
        return $namaBulan[$bulan] . ' ' . $tahun;
    }

    public function exportPdfPengeluaran()
    {
        $pengeluaranPerbulan = VPengeluaranPerbulan::all();

        // Mengubah setiap bulan menjadi nama bulan
        $pengeluaranPerbulan->each(function ($pengeluaran) {
            $pengeluaran->nama_bulan_pengeluaran = $this->getNamaBulanPengeluaran($pengeluaran->bulan_pengeluaran);
        });

        // Menghitung grand total jumlah dan total pembelian
        $grandTotalJumlah = $pengeluaranPerbulan->sum('total_seluruh_barang');
        $grandTotalPembelian = $pengeluaranPerbulan->sum('grand_total');

        // Waktu saat ini untuk penamaan file
        date_default_timezone_set('Asia/Jakarta');
        $currentTime = Carbon::now()->format('yy_His');

        // HTML untuk laporan
        $html = '
         <html>
        <head>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .text-center {
                text-align: center;
            }
            .grand-total {
                font-weight: bold;
            }
        </style>
        </head>
        <body>
        <h1>Laporan Pengeluaran Perbulan</h1>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Total Pembelian</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($pengeluaranPerbulan as $pengeluaran) {
            $html .= '
        <tr>
            <td>' . $pengeluaran->nama_bulan_pengeluaran . '</td>
            <td class="text-center">' . $pengeluaran->total_seluruh_barang . ' Barang</td>
            <td class="text-center">' . formatRupiah($pengeluaran->grand_total) . '</td>
        </tr>';
        }

        $html .= '
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">Grand Total</th>
                    <th class="text-center">' . $grandTotalJumlah . ' Barang</th>
                    <th class="text-center">' . formatRupiah($grandTotalPembelian) . '</th>
                </tr>
            </tfoot>
        </table>
     </body>
      </html>';

        // Buat PDF menggunakan DomPDF
        $pdf = PDF::loadHTML($html);
        return $pdf->download('laporan_pengeluaran_perbulan_' . $currentTime . '.pdf');
    }

    public function exportExcelPengeluaran()
    {
        // Waktu saat ini untuk penamaan file
        date_default_timezone_set('Asia/Jakarta');
        $currentTime = Carbon::now()->format('yy_His');

        return Excel::download(new PengeluaranPerbulanExport, 'laporan_pengeluaran_perbulan_' . $currentTime . '.xlsx');
    }

    // Laporan Penjualan
    public function exportPdfPenjualan(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Filter data berdasarkan tanggal
        $penjualan = VPenjualan::whereBetween('tgl_trans', [$start_date, $end_date])->get();

        // Inisialisasi grand total
        $grandTotalTerjual = 0;
        $grandTotalJual = 0;
        $grandTotalMargin = 0;

        // Buat string HTML untuk PDF
        $html = '
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            h1 {
                text-align: center;
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
            .text-center {
                text-align: center;
            }
            .text-green {
                color: green;
            }
            .grand-total {
                font-weight: bold;
            }
        </style>';

        $html .= '<h1>Laporan Penjualan</h1>';
        $html .= '<p>Periode: ' . date('d/m/y', strtotime($start_date)) . ' sampai ' . date('d/m/y', strtotime($end_date)) . '</p>';
        $html .= '<table>';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Tanggal</th>';
        $html .= '<th>Nama Barang</th>';
        $html .= '<th>Satuan</th>';
        $html .= '<th>Harga Jual</th>';
        $html .= '<th>Terjual</th>';
        $html .= '<th>Total Jual</th>';
        $html .= '<th class="text-center text-green">Margin</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        foreach ($penjualan as $jual) {
            $html .= '<tr>';
            $html .= '<td>' . date('d/m/y', strtotime($jual->tgl_trans)) . '</td>';
            $html .= '<td>' . $jual->nama_brg . '</td>';
            $html .= '<td>' . $jual->satuan . '</td>';
            $html .= '<td>' . formatRupiah($jual->harga_jual) . '</td>';
            $html .= '<td>' . $jual->terjual . '</td>';
            $html .= '<td>' . formatRupiah($jual->total_jual) . '</td>';
            $html .= '<td class="text-center text-green">' . formatRupiah($jual->margin) . '</td>';
            $html .= '</tr>';

            // Tambahkan ke grand total
            $grandTotalTerjual += $jual->terjual;
            $grandTotalJual += $jual->total_jual;
            $grandTotalMargin += $jual->margin;
        }

        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '<tr>';
        $html .= '<th colspan="4">Grand Total</th>';
        $html .= '<th>' . $grandTotalTerjual . '</th>';
        $html .= '<th>' . formatRupiah($grandTotalJual) . '</th>';
        $html .= '<th class="text-center text-green">' . formatRupiah($grandTotalMargin) . '</th>';
        $html .= '</tr>';
        $html .= '</tfoot>';
        $html .= '</table>';

        // Buat PDF menggunakan DomPDF
        $pdf = PDF::loadHTML($html);

        return $pdf->download('laporan_penjualan_' . date('dmy', strtotime($start_date)) . '_to_' . date('dmy', strtotime($end_date)) . '.pdf');
    }

    public function exportExcelPenjualan(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        return Excel::download(new PenjualanExport($start_date, $end_date), 'laporan_penjualan_' . $start_date . '_to_' . $end_date . '.xlsx');
    }

    //Laporan Stok Barang
    public function exportPdfStok(Request $request)
    {
        $filter = $request->input('filter');

        $query = VStokBarang::query();

        if ($filter === 'terjual') {
            $query->where('terjual', '>', 0);
        }

        $stokBarang = $query->get();

        // Calculate grand totals
        $grandTotalTerjual = $stokBarang->sum('terjual');
        $grandTotalStokTersisa = $stokBarang->sum('stok_tersisa');

        // Set timezone to Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        $currentTime = Carbon::now()->format('Ymd_His');

        $pdf = PDF::loadHTML('<html>
        <head>
            <title>Laporan Stok Barang</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .grand-total {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <h1>Laporan Stok Barang</h1>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Terjual</th>
                        <th>Stok Tersisa</th>
                    </tr>
                </thead>
                <tbody>' .
            $this->generatePdfTableRows($stokBarang) . '
                    <tr class="grand-total">
                        <td colspan="3">Grand Total</td>
                        <td>' . number_format($grandTotalTerjual, 0, ',', '.') . '</td>
                        <td>' . number_format($grandTotalStokTersisa, 0, ',', '.') . '</td>
                    </tr>
                </tbody>
            </table>
        </body>
        </html>');

        return $pdf->download('laporan_stok_barang_' . $currentTime . '.pdf');
    }

    private function generatePdfTableRows($stokBarang)
    {
        $rows = '';

        foreach ($stokBarang as $barang) {
            $rows .= '<tr>
            <td>' . $barang->kode . '</td>
            <td>' . $barang->nama . '</td>
            <td>' . $barang->satuan . '</td>
            <td>' . $barang->terjual . '</td>
            <td>' . $barang->stok_tersisa . '</td>
        </tr>';
        }

        return $rows;
    }

    public function exportExcelStok(Request $request)
    {
        $filter = $request->input('filter');

        $query = VStokBarang::query();

        if ($filter === 'terjual') {
            $query->where('terjual', '>', 0);
        }

        $stokBarang = $query->get();

        // Calculate grand totals
        $grandTotalTerjual = $stokBarang->sum('terjual');
        $grandTotalStokTersisa = $stokBarang->sum('stok_tersisa');

        // Set timezone to Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        $currentTime = Carbon::now()->format('Ymd_His');

        return Excel::download(new StokBarangExport($stokBarang, $grandTotalTerjual, $grandTotalStokTersisa), 'laporan_stok_barang_' . $currentTime . '.xlsx');
    }
}
