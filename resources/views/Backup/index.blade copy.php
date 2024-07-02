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
                                    <!-- <th>Harga Beli</th>
                                    <th>Harga Jual</th> -->
                                    <th>Stok</th>
                                    <th>Aksi</th> <!-- Kolom untuk menu aksi -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataBarang as $barang)
                                <tr>
                                    <td>{{ $barang->kd_brg }}</td>
                                    <td>{{ $barang->nama_brg }}</td>
                                    <td>{{ $barang->satuan }}</td>
                                    <!-- <td>{{ $barang->harga_beli }}</td>
                                    <td>{{ $barang->harga_jual }}</td> -->
                                    <td class="{{ $barang->stok <= $barang->stok_min ? 'text-danger fw-bold ' : ($barang->stok >= $barang->stok_max ? 'text-success fw-bold ' : '') }}">{{ $barang->stok }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('barang.edit', $barang->kd_brg) }}" class="btn btn-warning btn-sm">Edit</a>

                                        <!-- Tombol Delete -->
                                        <!-- <form id="deleteForm" action="{{ route('barang.destroy', $barang->kd_brg) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button> -->
                                        <!-- Modal Delete-->
                                        <!-- <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus barang ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- </form> -->

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
