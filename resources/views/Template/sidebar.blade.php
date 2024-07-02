<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#master-nav">
                <i class="bi bi-archive"></i>
                <span>Master</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <div id="master-nav" class="collapse">
                <ul class="nav-content">
                    <li>
                        <a href="{{ route('barang') }}">
                            <i class="bi bi-circle"></i><span>Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fakturPembelian') }}">
                            <i class="bi bi-circle"></i><span>Faktur Pembelian</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fakturPengeluaran') }}">
                            <i class="bi bi-circle"></i><span>Faktur Pengeluaran</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li><!-- End Master Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#transaksi-nav">
                <i class="bi bi-currency-dollar"></i>
                <span>Transaksi</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <div id="transaksi-nav" class="collapse">
                <ul class="nav-content">
                    <li>
                        <a href="{{ route('pembelian') }}">
                            <i class="bi bi-circle"></i><span>Pembelian Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pengeluaran') }}">
                            <i class="bi bi-circle"></i><span>Pengeluaran Barang</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li><!-- End Transaksi Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#laporan-nav">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <div id="laporan-nav" class="collapse">
                <ul class="nav-content">
                    <li>
                        <a href="{{ route('lapBarangMasuk') }}">
                            <i class="bi bi-circle"></i><span>Barang Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lapBarangKeluar') }}">
                            <i class="bi bi-circle"></i><span>Barang Keluar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lapPenjualan') }}">
                            <i class="bi bi-circle"></i><span>Penjualan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lapStok') }}">
                            <i class="bi bi-circle"></i><span>Stok Barang</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li><!-- End Laporan Nav -->

        <li class="nav-heading">KONFIGURASI</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('setstok') }}">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>SET STOK</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('setjual') }}">
                <i class="bi bi-cart-plus-fill"></i>
                <span>SET JUAL</span>
            </a>
        </li>

    </ul>

</aside>
