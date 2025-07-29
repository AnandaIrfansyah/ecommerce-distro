@extends('layouts.admin')

@section('title', 'Data Pesanan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Semua Pesanan</h1>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-white">Order ID</th>
                                    <th class="text-white">Costumer</th>
                                    <th class="text-white">Tanggal Pesanan</th>
                                    <th class="text-white">Total</th>
                                    <th class="text-white">Status</th>
                                    <th class="text-white">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>#ORD-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pesanan.show', $order->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-muted">Belum ada pesanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $orders->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
