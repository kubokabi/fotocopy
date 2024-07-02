@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="pagetitle">
    <h1>Edit Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item"><a href="{{ route('barang') }}">Barang</a></li>
            <li class="breadcrumb-item active">Edit Barang</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Edit Barang</h5>

                    <form action="{{ route('barang.update', $dataBarang->kd_brg) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <label for="nama_brg" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_brg" name="nama_brg" value="{{ $dataBarang->nama_brg }}">
                        </div>
                        <div class="col-12">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $dataBarang->satuan }}">
                        </div>
                        <div class="text-start">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('barang') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
