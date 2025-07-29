@extends('layouts.user')

@section('title', 'My Orders')

@push('style')
    <style>
        .badge-custom {
            display: inline-block;
            padding: 12px 12px;
            background-color: #7ACC00;
            /* hijau cerah */
            color: #fff;
            border-radius: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .order-card {
            transition: transform 0.2s;
        }

        .order-card:hover {
            transform: scale(1.02);
        }
    </style>
@endpush

@section('main')
    <div class="container-fluid">
        <div class="container py-5">
            <div class="row g-4 mb-4">
                <div class="col-xl-12">
                    <div class="container-fluid page-header py-4 rounded" style="background-color: #732734">
                        <h1 class="text-center display-6 text-white">Daftar Pesanan</h1>
                    </div>
                </div>
            </div>
            <div class="align-items-start p-3 py-3 shadow-lg rounded">
                <div class="container-fluid fruite py-2">
                    <div class="container py-2">
                        <div class="tab-class">
                            <div class="row g-4">
                                <div class="col-lg-2 text-start">
                                    <p class="fw-bold" style="font-size: 220%; color:black;">Status</p>
                                </div>
                                <div class="col-lg-10 text-start">
                                    <ul class="nav nav-pills d-inline-flex text-center mb-2">
                                        @php
                                            $statuses = [
                                                'processed' => 'Diproses',
                                                'shipped' => 'Dikirim',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                        @endphp
                                        @foreach ($statuses as $key => $label)
                                            <li class="nav-item">
                                                <a class="d-flex m-2 py-2 bg-light rounded-pill {{ $loop->first ? 'active' : '' }}"
                                                    data-bs-toggle="pill" href="#tab-{{ $key }}">
                                                    <span class="text-dark" style="width: 130px;">{{ $label }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                @foreach ($statuses as $key => $label)
                                    <div id="tab-{{ $key }}"
                                        class="tab-pane fade show p-0 {{ $loop->first ? 'active' : '' }}">
                                        <div class="row g-4">
                                            @forelse ($ordersByStatus[$key] ?? [] as $order)
                                                <div class="col-lg-12">
                                                    <div class="rounded card order-card o-hidden border-0 shadow-lg">
                                                        <div class="p-4">
                                                            <div class="header mb-4 d-flex justify-content-between">
                                                                <div>
                                                                    <strong>#ORD-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</strong><br>
                                                                    <small>{{ $order->created_at->format('d F Y') }}</small>
                                                                </div>
                                                                <span class="badge-custom">{{ ucfirst($label) }}</span>
                                                            </div>

                                                            @foreach ($order->items as $item)
                                                                <div class="details mb-3 d-flex">
                                                                    <img src="{{ asset('storage/' . ($item->product->image ?? 'img/default.png')) }}"
                                                                        alt="Gambar Produk" class="rounded"
                                                                        style="width: 100px; height: 100px; object-fit: cover;">
                                                                    <div class="ms-3">
                                                                        <h5>{{ $item->product->name ?? 'Produk Dihapus' }}
                                                                        </h5>
                                                                        <p>{{ $item->quantity }} x Rp
                                                                            {{ number_format($item->price, 0, ',', '.') }}
                                                                        </p>
                                                                        <p class="text-muted">
                                                                            @if ($item->size)
                                                                                Ukuran: {{ $item->size->name }}
                                                                            @endif
                                                                            <br>
                                                                            @if ($item->color)
                                                                                Warna: {{ $item->color->name }}
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            <div class="mt-2">
                                                                <h5>Total Belanja: Rp
                                                                    {{ number_format($order->total, 0, ',', '.') }}</h5>
                                                            </div>

                                                            @if ($order->note)
                                                                <div class="mt-2">
                                                                    <strong>Catatan Pembelian:</strong> {{ $order->note }}
                                                                </div>
                                                            @endif

                                                            <div class="mt-3 d-flex flex-wrap gap-2">
                                                                <a href="" class="btn btn-primary text-white">Lihat
                                                                    Detail</a>
                                                                <a href="{{ route('home.index') }}"
                                                                    class="btn btn-secondary text-white">Beli
                                                                    Lagi</a>

                                                                @if ($key === 'processed')
                                                                    <form
                                                                        action="{{ route('user.orders.cancel', $order->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button type="submit"
                                                                            class="btn btn-danger text-white">Batalkan
                                                                            Pesanan</button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-lg-12">
                                                    <div class="rounded card o-hidden border-0 shadow-lg text-center">
                                                        <div class="p-4">
                                                            <img src="{{ asset('img/oops.png') }}" alt=""
                                                                style="width: 200px; height: 200px;">
                                                            <h4>OOPS! Belum ada transaksi dengan status
                                                                <strong>{{ $label }}</strong>.
                                                            </h4>
                                                            <p>Temukan produk lainnya dan beberapa promo menarik!</p>
                                                            <a href="{{ route('home.index') }}"
                                                                class="btn btn-primary py-2 mb-3 text-white">Cari Produk
                                                                Lain</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@endpush
