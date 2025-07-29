{{-- Card Title --}}
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 text-dark">{{ $title }}</h5>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-striped mb-0">
            <thead class="bg-primary">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-center">#</th>
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
                            <span
                                class="badge
                                @if ($order->status == 'processed') badge-primary
                                @elseif($order->status == 'shipped') badge-info
                                @elseif($order->status == 'cancelled') badge-danger
                                @else badge-secondary @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pesanan.show', $order->id) }}" class="btn btn-sm btn-light shadow-sm">
                                <i class="fas fa-eye text-info"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
