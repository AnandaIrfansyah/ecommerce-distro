@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Produk</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Edit Produk</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}"
                                            {{ $product->category_id == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" name="price" value="{{ $product->price }}" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Gambar Produk</label><br>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" width="120" class="mb-2">
                                @endif
                                <input type="file" name="image" class="form-control-file">
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
