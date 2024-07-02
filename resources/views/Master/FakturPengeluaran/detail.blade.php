@extends('layouts.app')

@section('title', 'Detail Faktur Pengeluaran')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table table-border">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Harga Beli</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">{{ $faktur->no_fk }}</h5>
                        <h5 class="card-title">{{ $faktur->tgl_faktur }}</h5>
                    </div>
                    @foreach($PengeluaranBarang as $item)
                    <tr>
                        <td>{{ $item->barang->nama_brg }}</td>
                        <td>{{ $item->barang->satuan }}</td>
                        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Grand Total</th>
                        <th>Rp{{ number_format($faktur->total_keseluruhan, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <button onclick="printTable();" class="btn btn-danger"><i class="bi bi-collection"></i> Cetak</button>
            <a href="{{ route('fakturPengeluaran') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </div>
</div>

<script>
    function printTable() {
        var faktur = '{{ $faktur->no_fk }}';
        var tglFaktur = '{{ $faktur->tgl_faktur }}';
        var grandTotal = "Rp{{ number_format($faktur->total_keseluruhan, 0, ',', '.') }}";
        var tableContent = document.querySelector('table').outerHTML;

        var newWin = window.open('');
        newWin.document.write('<html><head><title>Cetak</title>');
        newWin.document.write('<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 8px; text-align: left; } </style>');
        newWin.document.write('</head><body>');
        newWin.document.write('<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">');
        newWin.document.write('<div style="flex: 1;"><h5>Faktur: ' + faktur + '</h5></div>');
        newWin.document.write('<div style="flex: 1; text-align: right;"><h5>Tanggal: ' + tglFaktur + '</h5></div>');
        newWin.document.write('</div>');
        newWin.document.write(tableContent);
        newWin.document.write('</body></html>');
        newWin.document.close();
        newWin.print();
        newWin.close();
    }
</script>
@endsection
