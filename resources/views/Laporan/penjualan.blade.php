@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="pagetitle">
    <h1>Data Penjualan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Laporan</li>
            <li class="breadcrumb-item active">Penjualan</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between mb-3">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tglPdf">
                    Cetak PDF
                </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tglExcel">
                    Cetak PDF
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Penjualan</h5>
                    <p>Semua Penjualan barang terdata di bawah ini.</p>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Terjual</th>
                                <th>Total Jual</th>
                                <th>Margin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan as $jual)
                            <tr>
                                <td>{{ $jual->tgl_trans }}</td>
                                <td>{{ $jual->nama_brg }}</td>
                                <td>{{ $jual->satuan }}</td>
                                <td>{{ formatRupiah($jual->harga_beli) }}</td>
                                <td>{{ formatRupiah($jual->harga_jual) }}</td>
                                <td>{{ $jual->terjual }}</td>
                                <td>{{ formatRupiah($jual->total_jual) }}</td>
                                <td class="text-info">{{ formatRupiah($jual->margin) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal untuk Memilih Tanggal (PDF) -->
<div class="modal fade" id="tglPdf" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Tanggal</h5>
            </div>
            <form action="{{ route('laporan.Penjualan.pdf') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal untuk Memilih Tanggal (PDF) -->


<!-- Modal untuk Memilih Tanggal (EXCEL) -->
<div class="modal fade" id="tglExcel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Tanggal</h5>
            </div>
            <form action="{{ route('laporan.Penjualan.excel') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal untuk Memilih Tanggal (EXCEL) -->
@endsection
