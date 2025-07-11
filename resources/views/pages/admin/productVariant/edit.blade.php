@extends('layouts.admin')

@section('title', 'Edit Varian Produk')

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
                                <select name="product_id" class="form-control selectric" required>
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
                                <select name="size_id" class="form-control selectric" required>
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
