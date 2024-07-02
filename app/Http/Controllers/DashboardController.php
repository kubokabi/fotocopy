<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\PembelianBarang;
use App\Models\FakturPembelian;
use App\Models\PengeluaranBarang;
use App\Models\FakturPengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Set timezone to Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Filter default adalah hari ini
        $filter = $request->get('filter', 'today');

        // Mendapatkan rentang tanggal berdasarkan filter
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        switch ($filter) {
            case 'month':
                $startDate = $startOfMonth;
                break;
            case 'year':
                $startDate = $startOfYear;
                break;
            case 'today':
            default:
                $startDate = $today;
                break;
        }

        // Mendapatkan total penjualan berdasarkan filter yang dipilih
        $totalSales = FakturPengeluaran::where('tgl_faktur', '>=', $startDate)
            ->sum('total_barang');

        // Mendapatkan total margin dan tgl_trans berdasarkan filter yang dipilih dari view v_penjualan
        $totalMargin = DB::table('v_penjualan')
            ->where('tgl_trans', '>=', $startDate)
            ->sum('total_jual');

        // Mendapatkan transaksi terbaru berdasarkan filter yang dipilih dari view v_penjualan
        $latestTransactions = DB::table('v_penjualan')
            ->where('tgl_trans', '>=', $startDate)
            ->orderBy('tgl_trans', 'desc')
            ->take(5)
            ->get();

        // Mendapatkan total pelanggan dari tabel faktur_pengeluaran
        $totalCustomers = FakturPengeluaran::where('tgl_faktur', '>=', $startDate)
            ->count();

        // Mendapatkan produk terlaris berdasarkan filter yang dipilih dari view v_penjualan
        $topSellingProducts = DB::table('v_penjualan')
            ->select('nama_brg', 'harga_jual', DB::raw('SUM(terjual) as terjual'), DB::raw('SUM(total_jual) as total_jual'))
            ->where('tgl_trans', '>=', $startDate)
            ->groupBy('nama_brg', 'harga_jual')
            ->orderBy('terjual', 'desc')
            ->get();

        // Mendapatkan barang dengan stok mencapai stok_min atau stok_max
        $stockWarnings = Barang::whereColumn('stok', '<=', 'stok_min')
            ->orWhereColumn('stok', '>=', 'stok_max')
            ->get(['kd_brg', 'nama_brg', 'stok', 'stok_min', 'stok_max']);

        // Mendapatkan data untuk grafik berdasarkan bulan ini
        $monthlyData = DB::table('v_penjualan')
            ->select(
                DB::raw('DATE(tgl_trans) as date'),
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(total_jual) as total_revenue')
            )
            ->where('tgl_trans', '>=', $startOfMonth)
            ->groupBy(DB::raw('DATE(tgl_trans)'))
            ->get();

        // Mendapatkan data pelanggan dari faktur_pengeluaran
        $customerData = FakturPengeluaran::select(
            DB::raw('DATE(tgl_faktur) as date'),
            DB::raw('COUNT(*) as total_customers')
        )
        ->where('tgl_faktur', '>=', $startOfMonth)
        ->groupBy(DB::raw('DATE(tgl_faktur)'))
        ->get()
        ->keyBy('date');

        // Format data untuk chart
        $chartData = [
            'dates' => $monthlyData->pluck('date')->toArray(),
            'sales' => $monthlyData->pluck('total_sales')->toArray(),
            'customers' => $customerData->pluck('total_customers')->toArray(),
            'revenue' => $monthlyData->pluck('total_revenue')->toArray(),
        ];

        // Memformat margin menjadi format yang mudah dibaca (1k, 999k, 1m, dll.)
        $formattedMargin = $this->formatRevenue($totalMargin);

        return view('dashboard.index', compact('totalSales', 'formattedMargin', 'latestTransactions', 'totalCustomers', 'filter', 'topSellingProducts', 'stockWarnings', 'chartData'));
    }

    private function formatRevenue($revenue)
    {
        $suffixes = ['', 'k', 'm', 'b', 't'];
        $suffixIndex = 0;

        while ($revenue >= 1000 && $suffixIndex < count($suffixes)) {
            $revenue /= 1000;
            $suffixIndex++;
        }

        return number_format($revenue, ($suffixIndex > 0 ? 1 : 0)) . $suffixes[$suffixIndex];
    }
}
