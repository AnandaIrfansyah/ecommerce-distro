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
                        <table class="table table-bordered table-striped text-center">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-white">No</th>
                                    <th class="text-white">Produk</th>
                                    <th class="text-white">Ukuran Tersedia</th>
                                    <th class="text-white">Warna Tersedia</th>
                                    <th class="text-white">Total Stok</th>
                                    <th class="text-white">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product)
                                    @if ($product->variants->count() > 0)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                @foreach ($product->variants->pluck('size.name')->unique() as $size)
                                                    <span class="badge badge-primary">{{ $size }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($product->variants->pluck('color.name')->unique() as $color)
                                                    <span class="badge badge-warning">{{ $color }}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $product->variants->sum('stock') }}</td>
                                            <td>
                                                <a href="{{ route('productVariant.show', $product->id) }}"
                                                    class="btn btn-sm btn-info">Detail</a>
                                            </td>
                                        </tr>
                                    @endif
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
