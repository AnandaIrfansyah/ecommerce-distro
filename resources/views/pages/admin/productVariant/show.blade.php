@extends('layouts.admin')

@section('title', 'Detail Varian Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Varian: {{ $product->name }}</h1>
                <div class="section-header-button">
                    <a href="{{ route('productVariant.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="img-fluid" style="max-height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <p><strong>Nama Produk:</strong> {{ $product->name }}</p>
                                <p><strong>Kategori Produk:</strong> {{ $product->category->name }}</p>
                                <p><strong>Total Stok:</strong> {{ $product->variants->sum('stock') }}</p>
                                <p><strong>Harga Produk:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p><strong>Deskripsi Produk:</strong> {{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Daftar Varian</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-white">No</th>
                                    <th class="text-white">Ukuran</th>
                                    <th class="text-white">Warna</th>
                                    <th class="text-white">Stok</th>
                                    <th class="text-white">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->variants as $i => $variant)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $variant->size->name ?? '-' }}</td>
                                        <td>{{ $variant->color->name ?? '-' }}</td>
                                        <td>{{ $variant->stock }}</td>
                                        <td>
                                            <a href="{{ route('productVariant.edit', $variant->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('productVariant.destroy', $variant->id) }}" method="POST"
                                                class="d-inline-block" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                        @if ($product->variants->isEmpty())
                            <div class="alert alert-warning mt-3 text-center">Tidak ada varian untuk produk ini.</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
