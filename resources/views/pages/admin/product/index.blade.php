@extends('layouts.admin')

@section('title', 'Data Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Produk</h1>
                <div class="section-header-button">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Tambah Produk</a>
                </div>
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
                                    <th class="text-white">No</th>
                                    <th class="text-white">Gambar</th>
                                    <th class="text-white">Nama</th>
                                    <th class="text-white">Kategori</th>
                                    <th class="text-white">Harga</th>
                                    <th class="text-white">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($p->image)
                                                <img src="{{ asset('storage/' . $p->image) }}" style="width: 100px;">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->category->name ?? '-' }}</td>
                                        <td>Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('product.edit', $p->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('product.destroy', $p->id) }}" method="POST"
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

                        {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
