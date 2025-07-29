@extends('layouts.user')

@section('title', 'Order Success')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .page-content {
            margin-top: 70px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background-color: #d4edda;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 0.6s ease;
            margin: 0 auto 20px;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }

        .order-box {
            max-width: 800px;
            margin: 0 auto;
        }

        .order-summary-img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 6px;
        }

        .summary-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px 20px;
        }
    </style>
@endpush

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('main')
    <div class="container py-5 page-content">
        <div class="order-box bg-white shadow rounded p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="success-icon">
                    <i class="fas fa-check text-success fa-2x"></i>
                </div>
                <h2 class="font-weight-bold mb-2 text-dark">Order Placed Successfully!</h2>
                <p class="text-muted mb-0">Thank you for your purchase. Your order has been confirmed and will be processed
                    shortly.</p>
            </div>

            <hr>

            <div class="row text-center text-md-left mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <small class="text-muted">Order Number</small>
                    <div class="font-weight-bold">#ORD-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <small class="text-muted">Date</small>
                    <div class="font-weight-bold">{{ $order->created_at->format('F j, Y') }}</div>
                </div>
                <div class="col-md-4">
                    <small class="text-muted">Total</small>
                    <div class="font-weight-bold text-success">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                </div>
            </div>

            <h5 class="mb-3 font-weight-bold text-dark">Order Summary</h5>
            @foreach ($order->items as $item)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('storage/' . $item->product->image) ?? 'https://placehold.co/64x64' }}"
                        class="order-summary-img rounded me-3" alt="{{ $item->product->name }}"
                        style="width: 64px; height: 64px; object-fit: cover;">
                    <div>
                        <div class="font-weight-bold">{{ $item->product->name }}</div>
                        <small class="text-muted">{{ $item->quantity }} × Rp
                            {{ number_format($item->price, 0, ',', '.') }}</small>
                    </div>
                </div>
            @endforeach

            <div class="summary-box mt-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Biaya Pengiriman</span>
                    <strong>Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Metode Pembayaran</span>
                    <strong>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</strong>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('sukses.index') }}" class="btn btn-outline-primary px-4 py-2 rounded me-2">Track Your
                    Order</a>
                <a href="{{ route('home.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded">Continue
                    Shopping</a>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted">Need help? <a href="#" class="text-primary font-weight-bold">Contact
                        support</a></small>
            </div>
        </div>
    </div>
@endsection
