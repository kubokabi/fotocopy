    @extends('layouts.app')

    @section('title', 'Barang')

    @section('content')
    <div class="pagetitle">
        <h1>Data Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Master</li>
                <li class="breadcrumb-item active">Barang</li>
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
                        <p>Semua barang dari supplier terdata di bawah ini.</p>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataBarang as $barang)
                                <tr>
                                    <td>{{ $barang->kd_brg }}</td>
                                    <td>{{ $barang->nama_brg }}</td>
                                    <td>{{ $barang->satuan }}</td>
                                    <td class="{{ $barang->stok <= $barang->stok_min ? 'text-danger fw-bold ' : ($barang->stok >= $barang->stok_max ? 'text-success fw-bold ' : '') }}">{{ $barang->stok }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('barang.edit', $barang->kd_brg) }}" class="btn btn-warning btn-sm">Edit</a>
                                    </td>
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
