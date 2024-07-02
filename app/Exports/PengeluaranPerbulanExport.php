<?php

namespace App\Exports;

use App\Models\VPengeluaranPerbulan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Collection;

class PengeluaranPerbulanExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    protected $grandTotalJumlah;
    protected $grandTotalPengeluaran;

    public function __construct()
    {
        $this->grandTotalJumlah = VPengeluaranPerbulan::sum('total_seluruh_barang');
        $this->grandTotalPengeluaran = VPengeluaranPerbulan::sum('grand_total');
    }

    public function collection()
    {
        $pengeluaranPerbulan = VPengeluaranPerbulan::all();

        // Tambahkan baris untuk grand total
        $grandTotal = new VPengeluaranPerbulan();
        $grandTotal->bulan_pengeluaran = 'Grand Total';
        $grandTotal->total_seluruh_barang = $this->grandTotalJumlah;
        $grandTotal->grand_total = $this->grandTotalPengeluaran;

        $pengeluaranPerbulan->push($grandTotal);

        return $pengeluaranPerbulan;
    }

    public function headings(): array
    {
        return [
            'Bulan',
            'Jumlah Barang',
            'Total Pembelian',
        ];
    }

    private function formatRupiah($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    public function map($pengeluaran): array
    {
        if ($pengeluaran->bulan_pengeluaran === 'Grand Total') {
            return [
                'Grand Total',
                $pengeluaran->total_seluruh_barang,
                $this->formatRupiah($pengeluaran->grand_total),
            ];
        }

        return [
            $this->getNamaBulan($pengeluaran->bulan_pengeluaran),
            $pengeluaran->total_seluruh_barang,
            $this->formatRupiah($pengeluaran->grand_total),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Lebar kolom untuk 'Bulan'
            'B' => 20, // Lebar kolom untuk 'Jumlah Barang'
            'C' => 30, // Lebar kolom untuk 'Total Pengeluaran'
        ];
    }

    private function getNamaBulan($bulanPengeluaran)
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
}
