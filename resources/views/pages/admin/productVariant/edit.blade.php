@extends('layouts.admin')

@section('title', 'Edit Varian Produk')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Varian</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Edit Varian</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('productVariant.update', $variant->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Produk</label>
                                <select name="product_id" id="product_id" class="form-control selectric" required
                                    onchange="loadSizes(this.value)">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}"
                                            {{ $variant->product_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Ukuran</label>
                                <select name="size_id" id="size_id" class="form-control selectric" required
                                    {{ !$variant->product_id ? 'disabled' : '' }}>
                                    @foreach ($sizes as $s)
                                        <option value="{{ $s->id }}"
                                            {{ $variant->size_id == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Warna</label>
                                <select name="color_id" class="form-control selectric" required>
                                    @foreach ($colors as $c)
                                        <option value="{{ $c->id }}"
                                            {{ $variant->color_id == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Stok</label>
                                <input type="number" name="stock" class="form-control" min="0"
                                    value="{{ $variant->stock }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('productVariant.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const currentSizeId = {{ $variant->size_id }};
        const sizeSelect = document.getElementById('size_id');

        function loadSizes(productId) {
            sizeSelect.innerHTML = '<option value="">-- Pilih Ukuran --</option>';

            if (!productId) {
                sizeSelect.disabled = true;
                if ($.fn.selectric) $(sizeSelect).selectric('refresh');
                return;
            }

            fetch(`/admin/product/${productId}/sizes`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(size => {
                        const option = document.createElement('option');
                        option.value = size.id;
                        option.textContent = size.name;
                        if (size.id == currentSizeId) option.selected = true;
                        sizeSelect.appendChild(option);
                    });

                    sizeSelect.disabled = false;
                    if ($.fn.selectric) $(sizeSelect).selectric('refresh');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const productId = document.getElementById('product_id').value;
            if (productId) {
                loadSizes(productId);
            } else {
                sizeSelect.disabled = true;
            }
        });
    </script>
@endpush
