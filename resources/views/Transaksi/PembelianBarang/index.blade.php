@extends('layouts.app')

@section('title', 'Pembelian Barang')

@section('content')

<div class="container mt-5">
    <h2>Pembelian Barang</h2>
    <form id="purchaseForm" action="{{ route('pembelian.store') }}" method="POST">
        @csrf
        <div id="inputContainer">
            <!-- Klik Tambah atau Update untuk melakukan pembelian  -->
        </div>
        <div class="d-flex justify-content-center mb-3">
            <button type="button" id="updateBtn" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> Update
            </button>
            &nbsp;&nbsp;
            <button type="button" id="addMore" class="btn btn-primary">
                <i class="bi bi-plus-square"></i> Tambah
            </button>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn text-light fw-bold" style="background-color: #4154f1;">Checkout</button>
            <button type="button" class="btn btn-secondary fw-bold">Cancel</button>
        </div>
    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateTotal(inputGroup) {
            const harga = parseFloat(inputGroup.querySelector('input[name="harga[]"]').value) || 0;
            const jumlah = parseFloat(inputGroup.querySelector('input[name="jumlah[]"]').value) || 0;
            const total = inputGroup.querySelector('input[name="total_harga[]"]');
            total.value = harga * jumlah;
        }

        function checkDuplicateKode(kd_brg_input) {
            return fetch('{{ route("check.kodebarang") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    kd_brg: kd_brg_input
                })
            }).then(response => response.json());
        }

        function addInputGroup(newInputGroup) {
            const inputContainer = document.getElementById('inputContainer');
            inputContainer.appendChild(newInputGroup);

            newInputGroup.querySelector('input[name="harga[]"]').addEventListener('input', function() {
                updateTotal(newInputGroup);
            });

            newInputGroup.querySelector('input[name="jumlah[]"]').addEventListener('input', function() {
                updateTotal(newInputGroup);
            });

            newInputGroup.querySelector('.remove').addEventListener('click', function() {
                inputContainer.removeChild(newInputGroup);
            });

            newInputGroup.querySelector('input[name="kd_brg[]"]').addEventListener('change', function() {
                const kd_brg_input = this.value;
                checkDuplicateKode(kd_brg_input).then(response => {
                    if (response.exists) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Kode Barang sudah ada',
                            text: 'Harap input kode barang yang lain.',
                            confirmButtonColor: '#4154f1'
                        });
                        this.value = ''; // Kosongkan nilai input jika kode barang sudah ada
                    }
                });
            });

            // Initialize total harga saat pertama kali menambahkan input
            updateTotal(newInputGroup);
        }

        // Tambahkan 3 baris input secara otomatis saat halaman dimuat
        for (let i = 0; i < 2; i++) {
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-3');

            newInputGroup.innerHTML = `
                <input type="text" name="kd_brg[]" class="form-control" placeholder="Kode Barang" required>
                <input type="text" name="nama_brg[]" class="form-control" placeholder="Nama Barang" required>
                <input type="text" name="satuan[]" class="form-control" placeholder="Satuan" required>
                <input type="number" name="harga[]" class="form-control" placeholder="Harga" required>
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                <input type="number" name="total_harga[]" class="form-control" placeholder="Total Harga" readonly disabled>
                <button type="button" class="btn btn-danger remove">X</button>
            `;

            addInputGroup(newInputGroup);
        }

        document.getElementById('addMore').addEventListener('click', function() {
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-3');

            newInputGroup.innerHTML = `
                <input type="text" name="kd_brg[]" class="form-control" placeholder="Kode Barang" required>
                <input type="text" name="nama_brg[]" class="form-control" placeholder="Nama Barang" required>
                <input type="text" name="satuan[]" class="form-control" placeholder="Satuan" required>
                <input type="number" name="harga[]" class="form-control" placeholder="Harga" required>
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                <input type="number" name="total_harga[]" class="form-control" placeholder="Total Harga" readonly disabled>
                <button type="button" class="btn btn-danger remove">X</button>
            `;

            addInputGroup(newInputGroup);
        });

        document.getElementById('updateBtn').addEventListener('click', function() {
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-3');

            newInputGroup.innerHTML = `
                <select name="kd_brg[]" class="form-control">
                    <option value="">Pilih Barang</option>
                    @foreach($barang as $item)
                        <option value="{{ $item->kd_brg }}" class="{{ $item->stok >= $item->stok_max ? 'text-danger fw-bold' : '' }}">{{ $item->kd_brg }} - {{ $item->nama_brg }}</option>
                    @endforeach
                </select>
                <input type="number" name="harga[]" class="form-control" placeholder="Harga Baru" required>
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                <input type="number" name="total_harga[]" class="form-control" placeholder="Total Harga" readonly disabled>
                <button type="button" class="btn btn-danger remove">X</button>
            `;

            addInputGroup(newInputGroup);
        });

        document.getElementById('purchaseForm').addEventListener('submit', function(event) {
            const inputs = document.querySelectorAll('#inputContainer .input-group input[name="kd_brg[]"]');
            let valid = true;

            // Array untuk menyimpan kode barang yang sudah dimasukkan
            const usedCodes = [];

            inputs.forEach(input => {
                if (usedCodes.includes(input.value)) {
                    valid = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplikasi Kode Barang',
                        text: 'Kode Barang tidak boleh sama untuk setiap input.',
                        confirmButtonColor: '#4154f1'
                    });
                    return;
                } else {
                    usedCodes.push(input.value);
                }
            });

            if (!valid) {
                event.preventDefault();
            }
        });
    });
</script>
@endsection
