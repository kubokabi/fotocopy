@extends('layouts.app')

@section('title', 'SET JUAL')

@section('content')
<div class="pagetitle">
    <h1>Setting Jual</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Konfigurasi</li>
            <li class="breadcrumb-item active">Set Jual Barang</li>
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
                    <p>Silakan setting Harga dari masing-masing barang dibawah.</p>

                    <!-- Form untuk mengupdate harga_beli dan harga_jual -->
                    <form action="{{ route('setjual.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataBarang as $barang)
                                <tr>
                                    <td>{{ $barang->kd_brg }}</td>
                                    <td>{{ $barang->nama_brg }}</td>
                                    <td>{{ $barang->satuan }}</td>
                                    <td>
                                        <input type="hidden" name="kd_brg[]" value="{{ $barang->kd_brg }}">
                                        <input type="number" class="form-control" name="harga_beli[]" value="{{ $barang->harga_beli }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="harga_jual[]" value="{{ $barang->harga_jual }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn text-light fw-bold" style="background: #4154f1;">Simpan Perubahan</button>
                    </form>
                    <!-- End Form untuk mengupdate harga_beli dan harga_jual -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
