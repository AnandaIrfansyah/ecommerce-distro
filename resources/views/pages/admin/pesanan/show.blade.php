@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h1>Order Detail</h1>
                <a href="{{ route('pesanan.index') }}" class="btn btn-danger">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <h5 class="mb-2 mb-md-0">Order #ORD-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</h5>
                        <p class="text-muted mb-0">Order Date: {{ $order->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    {{-- LEFT SIDE --}}
                    <div class="col-lg-8">

                        {{-- Order Items --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-4">Order Items</h5>

                                @foreach ($order->items as $item)
                                    <div class="d-flex align-items-center mb-4">
                                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/70x70' }}"
                                            alt="product" class="rounded"
                                            style="width: 70px; height: 70px; object-fit: cover;">
                                        <div class="ml-3 flex-grow-1">
                                            <strong>{{ $item->product->name ?? 'Produk dihapus' }}</strong><br>
                                            <small>
                                                Color: {{ $item->color->name ?? '-' }} |
                                                {{ $item->size->name ? 'Size: ' . $item->size->name : '' }}
                                            </small><br>
                                            <small>Quantity: {{ $item->quantity }}</small>
                                        </div>
                                        <div class="text-right">
                                            <strong>Rp{{ number_format($item->total, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                    @if (!$loop->last)
                                        <hr>
                                    @endif
                                @endforeach

                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Shipping</span>
                                    <span>Rp{{ number_format($order->shipping_fee, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between font-weight-bold">
                                    <span>Total</span>
                                    <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Customer Info --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="mb-3">Customer Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Contact Information</strong><br>
                                            {{ $order->user->email }}<br>
                                            {{ $order->address->phone ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Shipping Address</strong><br>
                                            {{ $order->address->name ?? '-' }}<br>
                                            {{ $order->address->address_line1 }}<br>
                                            {{ $order->address->city }}, {{ $order->address->province }}<br>
                                            {{ $order->address->postal_code }}, {{ $order->address->country }}</p>
                                    </div>
                                </div>

                                {{-- Payment Method --}}
                                <p class="mt-4"><strong>Payment Method</strong></p>
                                @php
                                    $iconMap = [
                                        'bank_transfer' => 'bank.png',
                                        'e_wallet' => 'wallet.jpg',
                                        'cod' => 'cod.webp',
                                        'store' => 'offline.png',
                                    ];
                                    $icon = $iconMap[$order->payment_method] ?? 'default.png';
                                @endphp
                                <img src="{{ asset('img/payment/' . $icon) }}" alt="Metode Pembayaran"
                                    style="width: 150px; height: auto;">
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT SIDE --}}
                    <div class="col-lg-4">

                        {{-- Order Status --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Order Status</h5>
                                <div class="mb-2">
                                    <span class="badge badge-success">{{ ucfirst($order->status) }}</span><br>
                                    <small class="text-muted">Updated at:
                                        {{ $order->updated_at->format('F d, Y H:i') }}</small>
                                </div>

                                <form action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="status">Update Status</label>
                                        <select class="form-control selectric" name="status" id="status">
                                            <option value="pending" @selected($order->status == 'pending')>Pending</option>
                                            <option value="processing" @selected($order->status == 'processing')>Processing</option>
                                            <option value="delivered" @selected($order->status == 'delivered')>Delivered</option>
                                            <option value="cancelled" @selected($order->status == 'cancelled')>Cancelled</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary btn-block">Update Status</button>
                                </form>
                            </div>
                        </div>

                        {{-- Order Notes --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Order Notes</h5>
                                @foreach ($order->notes ?? [] as $note)
                                    <div class="mb-2">
                                        <strong>{{ $note->title }}</strong><br>
                                        <small>Admin -
                                            {{ \Carbon\Carbon::parse($note->created_at)->format('F d, Y') }}</small>
                                    </div>
                                @endforeach
                                <p class="text-muted">{{ $order->note }}</p>
                            </div>
                        </div>

                        {{-- Order Actions --}}
                        <div class="card">
                            <div class="card-body">
                                <h5>Order Actions</h5>
                                <div class="d-grid gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-block">Print Invoice</a>
                                    <a href="#" class="btn btn-outline-secondary btn-block">Resend Invoice</a>
                                    <a href="#" class="btn btn-outline-info btn-block">Send Tracking</a>
                                    <a href="#" class="btn btn-outline-danger btn-block">Refund</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
