<?php

namespace App\Exports;

use App\Models\VPembelianPerbulan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Collection;

class PembelianPerbulanExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    protected $grandTotalJumlah;
    protected $grandTotalPembelian;

    public function __construct()
    {
        $this->grandTotalJumlah = VPembelianPerbulan::sum('total_seluruh_barang');
        $this->grandTotalPembelian = VPembelianPerbulan::sum('grand_total');
    }

    public function collection()
    {
        $pembelianPerbulan = VPembelianPerbulan::all();

        // Tambahkan baris untuk grand total
        $grandTotal = new VPembelianPerbulan();
        $grandTotal->bulan_pembelian = 'Grand Total';
        $grandTotal->total_seluruh_barang = $this->grandTotalJumlah;
        $grandTotal->grand_total = $this->grandTotalPembelian;

        $pembelianPerbulan->push($grandTotal);

        return $pembelianPerbulan;
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

    public function map($pembelian): array
    {
        if ($pembelian->bulan_pembelian === 'Grand Total') {
            return [
                'Grand Total',
                $pembelian->total_seluruh_barang,
                $this->formatRupiah($pembelian->grand_total),
            ];
        }

        return [
            $this->getNamaBulan($pembelian->bulan_pembelian),
            $pembelian->total_seluruh_barang,
            $this->formatRupiah($pembelian->grand_total),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Lebar kolom untuk 'Bulan'
            'B' => 20, // Lebar kolom untuk 'Jumlah Barang'
            'C' => 30, // Lebar kolom untuk 'Total Pembelian'
        ];
    }

    private function getNamaBulan($bulanPembelian)
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
}
