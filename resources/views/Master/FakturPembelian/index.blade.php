@extends('layouts.app')

@section('title', 'Faktur Pembelian')

@section('content')
<div class="container">
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari faktur...">
    <div class="row" id="card-container">
        @foreach($fakturPembelian as $index => $faktur)
        <div class="col-md-4 card-item {{ $index >= 6 ? 'd-none' : '' }}">
            <div class="card mb-4 shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $faktur->no_faktur }}</h5>
                    <p class="card-text total-barang"><span class="small">Total Barang : </span>{{ $faktur->total_barang }}</p>
                    <p class="card-text grand-total"><span class="small">Grand Total : </span>Rp{{ number_format($faktur->total_keseluruhan, 0, ',', '.') }}</p>
                    <div class="d-flex card-footer justify-content-between align-items-center">
                        <p class="mb-0">{{ $faktur->tgl_faktur }}</p>
                        <a href="{{ route('fakturPembelian.view', $faktur->no_faktur) }}" class="btn text-light" style="background-color: #4154f1;">View</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button id="loadMore" class="btn btn-dark">More</button>
        </div>
    </div>
</div>

<!-- Fitur Pencarian -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cardItems = document.querySelectorAll('.card-item');
        let loadMoreButton = document.getElementById('loadMore');
        let searchInput = document.getElementById('searchInput');
        let itemsToShow = 6;
        let itemsLoaded = itemsToShow;

        loadMoreButton.addEventListener('click', function() {
            for (let i = itemsLoaded; i < itemsLoaded + itemsToShow && i < cardItems.length; i++) {
                cardItems[i].classList.remove('d-none');
            }
            itemsLoaded += itemsToShow;
            if (itemsLoaded >= cardItems.length) {
                loadMoreButton.style.display = 'none';
            }
        });

        // Handle search input change
        searchInput.addEventListener('input', function() {
            let searchText = searchInput.value.trim().toLowerCase();

            cardItems.forEach(function(item) {
                let cardTitle = item.querySelector('.card-title').textContent.trim().toLowerCase();
                let totalBarang = item.querySelector('.card-text.total-barang').textContent.trim().toLowerCase();
                let grandTotal = item.querySelector('.card-text.grand-total').textContent.trim().toLowerCase();

                if (cardTitle.includes(searchText) || totalBarang.includes(searchText) || grandTotal.includes(searchText)) {
                    item.classList.remove('d-none');
                } else {
                    item.classList.add('d-none');
                }
            });
        });
    });
</script>
@endsection
