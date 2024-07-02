<?php

namespace App\Exports;

use App\Models\VPenjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenjualanExport implements FromCollection, WithHeadings, WithColumnFormatting, WithStyles
{
    protected $start_date;
    protected $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $penjualan = VPenjualan::whereBetween('tgl_trans', [$this->start_date, $this->end_date])
            ->select('tgl_trans', 'nama_brg', 'satuan', 'harga_beli', 'harga_jual', 'terjual', 'total_jual', 'margin')
            ->get();

        // Calculate grand totals
        $grandTotalTerjual = $penjualan->sum('terjual');
        $grandTotalJual = $penjualan->sum('total_jual');
        $grandTotalMargin = $penjualan->sum('margin');

        // Add grand totals as last row
        $penjualan->push([
            'tgl_trans' => 'Grand Total',
            'nama_brg' => '',
            'satuan' => '',
            'harga_beli' => '',
            'harga_jual' => '',
            'terjual' => $grandTotalTerjual,
            'total_jual' => $grandTotalJual,
            'margin' => $grandTotalMargin,
        ]);

        return $penjualan;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Barang',
            'Satuan',
            'Harga Beli',
            'Harga Jual',
            'Terjual',
            'Total Jual',
            'Margin',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '[$Rp-421] #,##0', // Harga Beli
            'E' => '[$Rp-421] #,##0', // Harga Jual
            'G' => '[$Rp-421] #,##0', // Total Jual
            'H' => '[$Rp-421] #,##0', // Margin
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        return [];
    }
}
