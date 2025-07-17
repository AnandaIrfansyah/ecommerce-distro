@extends('layouts.user')

@section('title', 'Cart')

@push('style')
    <style>
        .cart-summary-card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 1.5rem;
        }

        .cart-summary-card h5 {
            font-weight: 600;
        }

        .cart-summary-card ul {
            list-style-type: none;
            padding-left: 0;
        }

        .cart-summary-card li::before {
            content: "🛒 ";
        }

        .cart-summary-card li {
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        .form-check .form-check-input {
            cursor: pointer;
            border: 2px solid #aaa;
        }
    </style>
@endpush



@section('main')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Cart</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="form-check d-flex justify-content-center align-items-center">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                    </div>
                                </th>
                                <th scope="col">Products</th>
                                <th scope="col">Name</th>
                                <th scope="col">Variasi</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cartItems as $item)
                                <tr data-id="{{ $item->id }}" data-price="{{ $item->product->price }}"
                                    data-qty="{{ $item->quantity }}" data-name="{{ $item->product->name }}">
                                    <td class="align-middle text-center">
                                        <div class="form-check d-flex justify-content-center align-items-center">
                                            <input class="form-check-input item-check" type="checkbox"
                                                name="selected_items[]" value="{{ $item->id }}">
                                        </div>
                                    </td>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                                alt="{{ $item->product->name }}">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 mt-4">{{ $item->product->name }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">
                                            {{ $item->size?->name ?? '' }}{{ $item->color?->name ? ' - ' . $item->color->name : '' }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <div class="quantity-wrapper mt-4" style="width: 100px;">
                                            <a href="#" class="edit-qty d-block text-center text-decoration-none"
                                                data-bs-toggle="modal" data-bs-target="#qtyModal"
                                                data-id="{{ $item->id }}" data-quantity="{{ $item->quantity }}">
                                                <span class="form-control form-control-sm border-0 bg-light">
                                                    {{ $item->quantity }}
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </td>
                                    <td>
                                        <button form="delete-form-{{ $item->id }}"
                                            class="btn btn-md rounded-circle bg-light border mt-4">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">Keranjang kamu kosong</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
                <div class="row g-4 justify-content-end mt-2">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light cart-summary-card">
                            <div class="p-4">
                                <h4 class="mb-3 text-center">🧾 Ringkasan Belanja</h4>
                                <div id="selected-items-summary" class="w-100 mb-3">
                                    <ul id="selected-items-list" class="mb-2"></ul>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Subtotal</strong>
                                        <strong>Rp <span id="cart-subtotal">0</span></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 pb-4">
                                <button class="btn btn-primary w-100 rounded-pill py-3 text-uppercase" type="submit">
                                    Proceed to Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @foreach ($cartItems as $item)
                <form id="delete-form-{{ $item->id }}" method="POST" action="{{ route('cart.remove', $item->id) }}"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>
    </div>
    <!-- Cart Page End -->

    <!-- Modal Ubah Quantity -->
    <div class="modal fade" id="qtyModal" tabindex="-1" aria-labelledby="qtyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('cart.updateQuantity') }}" method="POST" class="w-100">
                @csrf
                <input type="hidden" name="id" id="modal-item-id">
                <div class="modal-content border-0 shadow-lg rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="qtyModalLabel">Ubah Quantity</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modal-quantity" class="form-label">Quantity:</label>
                            <input type="number" class="form-control" id="modal-quantity" name="quantity"
                                min="1" required>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-warning text-white" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary text-white">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qtyLinks = document.querySelectorAll('.edit-qty');
            qtyLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const qty = this.getAttribute('data-quantity');

                    document.getElementById('modal-item-id').value = id;
                    document.getElementById('modal-quantity').value = qty;
                });
            });
        });
    </script>

    <script>
        function formatRupiah(angka) {
            return angka.toLocaleString('id-ID');
        }

        function updateSummary() {
            let subtotal = 0;
            const summaryList = document.getElementById('selected-items-list');
            summaryList.innerHTML = '';

            document.querySelectorAll('.item-check:checked').forEach(checkbox => {
                const row = checkbox.closest('tr');
                const price = parseInt(row.dataset.price);
                const qty = parseInt(row.dataset.qty);
                const name = row.dataset.name;
                const total = price * qty;

                subtotal += total;

                const li = document.createElement('li');
                li.textContent = `${name} (${qty}x) - Rp ${formatRupiah(total)}`;
                summaryList.appendChild(li);
            });

            document.getElementById('cart-subtotal').textContent = formatRupiah(subtotal);
        }

        document.querySelectorAll('.item-check').forEach(checkbox => {
            checkbox.addEventListener('change', updateSummary);
        });

        document.getElementById('checkAll').addEventListener('change', function() {
            document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
            updateSummary();
        });

        updateSummary();
    </script>
@endpush
