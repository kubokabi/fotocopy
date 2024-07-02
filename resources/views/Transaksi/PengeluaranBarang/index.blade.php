@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('content')
<div class="container mt-5">
    <h2>Transaksi Penjualan</h2>
    <form id="purchaseForm" action="{{ route('pengeluaran.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4>Transaksi Penjualan</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" id="productSearch" class="form-control" placeholder="Cari produk...">
                    <select id="productSelect" class="form-control mt-2" size="5">
                        @php
                        // Sort barang based on conditions
                        $sortedBarang = $barang->sortBy(function($item) {
                        // Sorting logic: no warning -> less critical warnings -> more critical warnings
                        if ($item->stok > $item->stok_min && $item->harga_jual >= $item->harga_beli) {
                        return 0; // No warning
                        } elseif ($item->stok <= $item->stok_min) {
                            return 1; // Low stock warning
                            } else {
                            return 2; // Price warning
                            }
                            });
                            @endphp

                            @foreach($sortedBarang as $item)
                            @php
                            // Determine text color based on conditions
                            $textColor = ($item->stok <= $item->stok_min) ? 'text-danger' : (($item->harga_jual < $item->harga_beli) ? 'text-warning' : '');
                                    @endphp
                                    <option value="{{ $item->kd_brg }}" data-nama="{{ $item->nama_brg }}" data-harga_jual="{{ $item->harga_jual }}" data-harga_beli="{{ $item->harga_beli }}" class="{{ $textColor }}">
                                        {{ $item->kd_brg }} - {{ $item->nama_brg }} (Rp{{ $item->harga_jual }})
                                    </option>
                                    @endforeach
                    </select>
                </div>
                <div id="cartContainer">
                    <!-- Produk yang dipilih akan muncul di sini -->
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <h5>Total : <span id="totalHarga">Rp0</span></h5>
                </div>
                <div class="d-flex justify-content-start mt-3">
                    <button type="submit" class="btn ml-2 text-light" style="background-color: #4154f1;">Order Now</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('productSelect');
        const cartContainer = document.getElementById('cartContainer');
        const totalHargaElement = document.getElementById('totalHarga');
        let totalHarga = 0;

        // Ketika produk dipilih dari dropdown
        productSelect.addEventListener('change', function() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const kd_brg = selectedOption.value;
            const nama_brg = selectedOption.getAttribute('data-nama');
            const harga_jual = parseFloat(selectedOption.getAttribute('data-harga_jual'));
            const harga_beli = parseFloat(selectedOption.getAttribute('data-harga_beli'));

            // Check if stock is below minimum
            if (selectedOption.classList.contains('text-danger')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Minimum Tercapai',
                    text: 'Stok untuk barang ini sudah mencapai minimum. Silakan lakukan pembelian barang.',
                    confirmButtonColor: '#4154f1'
                });
                return;
            }

            // Check if harga_jual is less than harga_beli
            if (selectedOption.classList.contains('text-warning')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Harga Merugikan',
                    text: 'Silakan Ke Set Jual, Harga Jual Merugikan Anda',
                    confirmButtonColor: '#4154f1'
                });
                return;
            }

            addProductToCart(kd_brg, nama_brg, harga_jual);
            productSelect.selectedIndex = -1; // Reset select
        });

        // Pencarian produk di dropdown
        document.getElementById('productSearch').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const options = productSelect.options;

            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].textContent.toLowerCase();
                if (optionText.includes(filter)) {
                    options[i].style.display = '';
                } else {
                    options[i].style.display = 'none';
                }
            }
        });

        function addProductToCart(kd_brg, nama_brg, harga_jual) {
            const existingProductRow = document.getElementById('cart-item-' + kd_brg);
            if (existingProductRow) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Produk sudah ada di keranjang',
                    text: 'Produk ini sudah ada di keranjang. Anda dapat mengubah jumlahnya di keranjang.',
                    confirmButtonColor: '#4154f1'
                });
                return;
            }

            const productRow = document.createElement('div');
            productRow.classList.add('input-group', 'mb-3');
            productRow.setAttribute('id', 'cart-item-' + kd_brg);

            productRow.innerHTML = `
                <input type="hidden" name="kd_brg[]" value="${kd_brg}">
                <input type="hidden" name="harga_jual[]" value="${harga_jual}">
                <div class="form-control " style="color:#4154f1;background: #f6f9ff;">${kd_brg} - ${nama_brg}</div>
                <input type="number" name="jumlah[]" class="form-control jumlah " style="color:#4154f1;" placeholder="Jumlah" value="1" min="1">
                <div class="form-control total_harga_jual " style="color:#4154f1;background: #f6f9ff;" data-harga_jual="${harga_jual}">Rp${harga_jual}</div>
                <button type="button" class="btn btn-danger remove" data-kd_brg="${kd_brg}">X</button>
            `;

            productRow.querySelector('input[name="jumlah[]"]').addEventListener('input', function() {
                updateProductTotal(this);
            });

            productRow.querySelector('.remove').addEventListener('click', function() {
                removeProductFromCart(this.getAttribute('data-kd_brg'), harga_jual);
            });

            cartContainer.appendChild(productRow);
            updateTotalHarga();
        }

        function removeProductFromCart(kd_brg, harga_jual) {
            const productRow = document.getElementById('cart-item-' + kd_brg);
            if (productRow) {
                cartContainer.removeChild(productRow);
            }
            updateTotalHarga();
        }

        function updateProductTotal(input) {
            const jumlah = parseFloat(input.value) || 0;
            const harga_jual = parseFloat(input.closest('.input-group').querySelector('.total_harga_jual').getAttribute('data-harga_jual')) || 0;
            const total = jumlah * harga_jual;

            input.closest('.input-group').querySelector('.total_harga_jual').innerText = 'Rp' + total.toLocaleString();
            updateTotalHarga();
        }

        function updateTotalHarga() {
            let total = 0;
            cartContainer.querySelectorAll('.input-group').forEach(group => {
                const jumlah = parseFloat(group.querySelector('input[name="jumlah[]"]').value) || 0;
                const harga_jual = parseFloat(group.querySelector('.total_harga_jual').getAttribute('data-harga_jual')) || 0;
                total += jumlah * harga_jual;
            });
            totalHargaElement.innerText = 'Rp' + total.toLocaleString();
        }

        document.getElementById('purchaseForm').addEventListener('submit', function(event) {
            if (cartContainer.children.length === 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada produk yang dipilih',
                    text: 'Silakan pilih setidaknya satu produk sebelum memesan.',
                    confirmButtonColor: '#4154f1'
                });
            }
        });
    });
</script>
@endsection
