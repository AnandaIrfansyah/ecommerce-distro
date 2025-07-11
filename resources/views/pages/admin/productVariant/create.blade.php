@extends('layouts.admin')

@section('title', 'Tambah Varian Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Varian</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Varian</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('productVariant.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Produk</label>
                                <select name="product_id" class="form-control selectric" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Ukuran</label>
                                <select name="size_id" class="form-control selectric" required>
                                    <option value="">-- Pilih Ukuran --</option>
                                    @foreach ($sizes as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Warna</label>
                                <select name="color_id" class="form-control selectric" required>
                                    <option value="">-- Pilih Warna --</option>
                                    @foreach ($colors as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Stok</label>
                                <input type="number" name="stock" class="form-control" min="0" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('productVariant.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
