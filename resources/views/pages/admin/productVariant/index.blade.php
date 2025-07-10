@extends('layouts.admin')

@section('title', 'Varian Produk')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Varian Produk</h1>
                <div class="section-header-button">
                    <a href="{{ route('productVariant.create') }}" class="btn btn-primary">Tambah Varian</a>
                </div>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped text-center">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-white">No</th>
                                    <th class="text-white">Produk</th>
                                    <th class="text-white">Ukuran</th>
                                    <th class="text-white">Warna</th>
                                    <th class="text-white">Stok</th>
                                    <th class="text-white">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($variants as $v)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $v->product->name ?? '-' }}</td>
                                        <td>{{ $v->size->name ?? '-' }}</td>
                                        <td>{{ $v->color->name ?? '-' }}</td>
                                        <td>{{ $v->stock }}</td>
                                        <td>
                                            <a href="{{ route('productVariant.edit', $v->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('productVariant.destroy', $v->id) }}" method="POST"
                                                class="d-inline-block" onsubmit="return confirm('Hapus varian ini?')">
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

                        {{ $variants->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
