@extends('layouts.user')

@section('title', 'Checkout')

@push('style')
@endpush

@section('main')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Checkout</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Checkout</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Billing details</h1>
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="form-item w-100">
                            <label class="form-label my-3">Nama Pembeli</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Pilih Alamat</label>
                            <select class="form-select" name="address_id" required>
                                <option value="">Pilih Alamat</option>
                                @foreach ($addresses as $address)
                                    <option value="{{ $address->id }}">
                                        {{ $address->address_line1 }} - {{ $address->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-item mt-3">
                            <label class="form-label">Alamat Lengkap Penerima</label>
                            <div id="alamat-detail" class="p-3 border rounded bg-light text-secondary mb-3">
                                Alamat akan ditampilkan setelah dipilih.
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-2">
                            + Tambah Alamat Baru
                        </button>

                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        @foreach ($items as $item)
                            <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                        @endforeach

                        <div class="form-item mt-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>

                        <div class="form-item mt-4">
                            <label class="form-label">Catatan Pesanan (Opsional)</label>
                            <textarea name="note" class="form-control" rows="5" placeholder="Tulis catatan jika perlu..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Products</th>
                                        <th>Name</th>
                                        <th>Variasi</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    class="rounded-circle" style="width: 80px; height: 80px;"
                                                    alt="{{ $item->product->name }}">
                                            </td>
                                            <td class="py-5">
                                                {{ $item->product->name }}<br>
                                            </td>
                                            <td class="py-5">
                                                <small>{{ $item->size?->name }} {{ $item->color?->name }}</small>
                                            </td>
                                            <td class="py-5">Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            </td>
                                            <td class="py-5">{{ $item->quantity }}</td>
                                            <td class="py-5">
                                                Rp
                                                {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">Tidak ada item yang dipilih</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="text-end"><strong>Subtotal</strong></td>
                                        <td><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="text-end"><strong>Ongkos Kirim</strong></td>
                                        <td><strong>Rp 10.000</strong></td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="4"></td>
                                        <td class="text-end"><strong>Total</strong></td>
                                        <td><strong>Rp {{ number_format($subtotal + 10000, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mb-5">
                            <h5 class="mb-3">Metode Pengiriman</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input class="btn-check" type="radio" name="shipping_method" id="shipping-hemat"
                                        value="hemat" checked>
                                    <label class="btn btn-outline-success w-100 text-start p-3 rounded shadow-sm"
                                        for="shipping-hemat">
                                        <strong>Hemat</strong><br>
                                        <small class="text-secondary">Rp 10.000 • Estimasi 3–5 hari</small>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <input class="btn-check" type="radio" name="shipping_method" id="shipping-standar"
                                        value="standar">
                                    <label class="btn btn-outline-success w-100 text-start p-3 rounded shadow-sm"
                                        for="shipping-standar">
                                        <strong>Standar</strong><br>
                                        <small class="text-secondary">Rp 20.000 • Estimasi 2–3 hari</small>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <input class="btn-check" type="radio" name="shipping_method" id="shipping-prioritas"
                                        value="prioritas">
                                    <label class="btn btn-outline-success w-100 text-start p-3 rounded shadow-sm"
                                        for="shipping-prioritas">
                                        <strong>Prioritas</strong><br>
                                        <small class="text-secondary">Rp 40.000 • Estimasi 1 hari</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h5 class="mb-3">Metode Pembayaran</h5>
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-3">
                                    <input type="radio" class="btn-check" name="payment_method" id="pay-bank"
                                        value="bank_transfer" checked>
                                    <label class="btn btn-outline-success w-100 p-3 rounded shadow-sm" for="pay-bank">
                                        <strong>Bank Transfer</strong><br>
                                        <small class="text-secondary">Transfer via rekening bank</small>
                                    </label>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <input type="radio" class="btn-check" name="payment_method" id="pay-ewallet"
                                        value="e_wallet">
                                    <label class="btn btn-outline-success w-100 p-3 rounded shadow-sm" for="pay-ewallet">
                                        <strong>Dompet Digital</strong><br>
                                        <small class="text-secondary">OVO / DANA / GOPAY dll</small>
                                    </label>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <input type="radio" class="btn-check" name="payment_method" id="pay-cod"
                                        value="cod">
                                    <label class="btn btn-outline-success w-100 p-3 rounded shadow-sm" for="pay-cod">
                                        <strong>COD</strong><br>
                                        <small class="text-secondary">Bayar saat barang sampai</small>
                                    </label>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <input type="radio" class="btn-check" name="payment_method" id="pay-store"
                                        value="store">
                                    <label class="btn btn-outline-success w-100 p-3 rounded shadow-sm" for="pay-store">
                                        <strong>Gerai Offline</strong><br>
                                        <small class="text-secondary">Bayar di toko terdekat</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-4">
                            <button type="submit"
                                class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const alamatDropdown = document.querySelector('select[name="address_id"]');
        const alamatDetail = document.getElementById('alamat-detail');
        const alamatData = @json($addresses);

        alamatDropdown.addEventListener('change', function() {
            const selected = alamatData.find(a => a.id == this.value);
            if (selected) {
                alamatDetail.innerHTML = `
                ${selected.name} | ${selected.phone}<br>
                ${selected.address_line1}, ${selected.city}, ${selected.province}, ${selected.country}, ${selected.postal_code}.<br>
            `;
            } else {
                alamatDetail.innerText = 'Alamat akan ditampilkan setelah dipilih.';
            }
        });
    </script>
    <script>
        const shippingFees = {
            hemat: 10000,
            standar: 20000,
            prioritas: 40000
        };

        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        const shippingCostCell = document.querySelector('tfoot tr:nth-child(2) td:last-child strong');
        const totalCell = document.querySelector('tfoot tr:nth-child(3) td:last-child strong');

        const subtotal = {{ $subtotal }};

        function updateShippingAndTotal() {
            const selected = document.querySelector('input[name="shipping_method"]:checked');
            const selectedFee = shippingFees[selected.value];

            const formatRupiah = (angka) => {
                return 'Rp ' + angka.toLocaleString('id-ID');
            };

            shippingCostCell.textContent = formatRupiah(selectedFee);
            totalCell.textContent = formatRupiah(subtotal + selectedFee);
        }

        shippingRadios.forEach(radio => {
            radio.addEventListener('change', updateShippingAndTotal);
        });

        updateShippingAndTotal();
    </script>
@endpush
