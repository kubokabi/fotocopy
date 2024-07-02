@extends('layouts.app')

@section('title', 'Laporan Pembelian Perbulan')

@section('content')
<div class="pagetitle">
    <h1>Laporan Pembelian Perbulan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Laporan</li>
            <li class="breadcrumb-item active">Pembelian Perbulan</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('laporan.pembelian_perbulan.pdf') }}" class="btn btn-danger">Cetak PDF</a>
                <a href="{{ route('laporan.pembelian_perbulan.excel') }}" class="btn btn-success">Cetak Excel</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Laporan Pembelian Perbulan</h5>
                    <p>Data pembelian barang perbulan dapat dilihat di bawah ini.</p>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Jumlah</th>
                                <th>Total Pembelian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelianPerbulan as $pembelian)
                            <tr>
                                <td>{{ $pembelian->nama_bulan_pembelian }}</td>
                                <td>{{ $pembelian->total_seluruh_barang }} Barang</td>
                                <td>{{ formatRupiah($pembelian->grand_total) }}</td>
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
@endsection
