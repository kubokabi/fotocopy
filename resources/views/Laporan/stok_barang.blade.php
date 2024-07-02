@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="pagetitle">
    <h1>Data Stok Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Laporan</li>
            <li class="breadcrumb-item active">Stok Barang</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between mb-3">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#pdfModal">
                    Cetak PDF
                </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#excelModal">
                    Cetak Excel
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Penjualan</h5>
                    <p>Semua Stok Barang terdata di bawah ini.</p>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Terjual</th>
                                <th>Stok Tersisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokBarang as $barang)
                            <tr>
                                <td>{{ $barang->kode }}</td>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->satuan }}</td>
                                <td>{{ $barang->terjual }}</td>
                                <td>{{ $barang->stok_tersisa }}</td>
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

<!-- Modal untuk Pilihan Cetak PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Tipe Laporan PDF</h5>
            </div>
            <form action="{{ route('laporan.stokBarang.pdf') }}" method="GET">
                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter" id="terjual" value="terjual" required>
                        <label class="form-check-label" for="terjual">
                            Hanya Yang Terjual
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter" id="semua" value="semua" required>
                        <label class="form-check-label" for="semua">
                            Semua Barang
                        </label>
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
<!-- End Modal untuk Pilihan Cetak PDF -->

<!-- Modal untuk Pilihan Cetak Excel -->
<div class="modal fade" id="excelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Tipe Laporan EXCEL</h5>
            </div>
            <form action="{{ route('laporan.stokBarang.excel') }}" method="GET">
                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter" id="terjual_ex" value="terjual" required>
                        <label class="form-check-label" for="terjual_ex">
                            Hanya Yang Terjual
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter" id="semua_ex" value="semua" required>
                        <label class="form-check-label" for="semua_ex">
                            Semua Barang
                        </label>
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
<!-- End Modal untuk Pilihan Cetak Excel -->
@endsection
