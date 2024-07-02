@extends('layouts.app')

@section('title', 'Laporan Pengeluaran Perbulan')

@section('content')
<div class="pagetitle">
    <h1>Laporan Pengeluaran Perbulan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Laporan</li>
            <li class="breadcrumb-item active">Pengeluaran Perbulan</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('laporan.pengeluaran_perbulan.pdf') }}" class="btn btn-danger">Cetak PDF</a>
                <a href="{{ route('laporan.pengeluaran_perbulan.excel') }}" class="btn btn-success">Cetak Excel</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Laporan Pengeluaran Perbulan</h5>
                    <p>Data pengeluaran barang perbulan dapat dilihat di bawah ini.</p>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Jumlah</th>
                                <th>Total Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengeluaranPerbulan as $pengeluaran)
                            <tr>
                                <td>{{ $pengeluaran->nama_bulan_pengeluaran }}</td>
                                <td>{{ $pengeluaran->total_seluruh_barang }} Barang</td>
                                <td>{{ formatRupiah($pengeluaran->grand_total) }}</td>
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
