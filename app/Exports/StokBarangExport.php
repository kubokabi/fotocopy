<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StokBarangExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $stokBarang;
    protected $grandTotalTerjual;
    protected $grandTotalStokTersisa;

    public function __construct($stokBarang, $grandTotalTerjual, $grandTotalStokTersisa)
    {
        $this->stokBarang = $stokBarang;
        $this->grandTotalTerjual = $grandTotalTerjual;
        $this->grandTotalStokTersisa = $grandTotalStokTersisa;
    }

    public function collection()
    {
        // Buat array untuk data termasuk grand total
        $data = [];

        foreach ($this->stokBarang as $barang) {
            $data[] = [
                'Kode' => $barang->kode,
                'Nama' => $barang->nama,
                'Satuan' => $barang->satuan,
                'Terjual' => $barang->terjual,
                'Stok Tersisa' => $barang->stok_tersisa,
            ];
        }

        // Tambahkan baris grand total
        $data[] = [
            'Kode' => 'Grand Total',
            'Nama' => '',
            'Satuan' => '',
            'Terjual' => $this->grandTotalTerjual,
            'Stok Tersisa' => $this->grandTotalStokTersisa,
        ];

        // Kembalikan koleksi data
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama',
            'Satuan',
            'Terjual',
            'Stok Tersisa',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style baris pertama sebagai teks tebal.
            1 => ['font' => ['bold' => true]],
            // Atur lebar kolom A menjadi 30 piksel.
            'A' => ['width' => 30],
        ];
    }
}
