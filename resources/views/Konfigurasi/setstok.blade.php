@extends('layouts.app')

@section('title', 'SET STOK')

@section('content')
<div class="pagetitle">
    <h1>Setting Stok</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Konfigurasi</li>
            <li class="breadcrumb-item active">Set Stok Barang</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Barang</h5>
                    <p>Silakan setting stok minimum dan maximum dari masing-masing barang dibawah.</p>

                    <!-- Form untuk mengupdate stok_min dan stok_max -->
                    <form action="{{ route('setstok.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Stok</th>
                                    <th>Stok Minimum</th>
                                    <th>Stok Maximum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataBarang as $barang)
                                <tr>
                                    <td>{{ $barang->kd_brg }}</td>
                                    <td>{{ $barang->nama_brg }}</td>
                                    <td class="{{ $barang->stok <= $barang->stok_min ? 'text-danger fw-bold' : ($barang->stok >= $barang->stok_max ? 'text-success fw-bold' : '') }}">
                                        {{ $barang->stok }}
                                    </td>
                                    <td>
                                        <input type="hidden" name="kd_brg[]" value="{{ $barang->kd_brg }}">
                                        <input type="number" class="form-control" name="stok_min[]" value="{{ $barang->stok_min }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="stok_max[]" value="{{ $barang->stok_max }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn text-light fw-bold" style="background: #4154f1;">Simpan Perubahan</button>
                    </form>
                    <!-- End Form untuk mengupdate stok_min dan stok_max -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
