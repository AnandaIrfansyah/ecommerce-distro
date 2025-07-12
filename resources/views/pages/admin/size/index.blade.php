@extends('layouts.admin')

@section('title', 'Data Size')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Size</h1>
                <div class="section-header-button">
                    <a href="{{ route('size.create') }}" class="btn btn-primary">Tambah Size</a>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">No</th>
                                        <th class="text-white">Kategori</th>
                                        <th class="text-white">Size</th>
                                        <th class="text-white">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categoriesWithSizes as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                {{ $category->sizes->pluck('name')->implode(', ') }}
                                            </td>
                                            <td>
                                                @foreach ($category->sizes as $size)
                                                    <form action="{{ route('size.destroy', $size->id) }}" method="POST"
                                                        class="d-inline-block"
                                                        onsubmit="return confirm('Yakin hapus size {{ $size->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger mb-1">
                                                            <i class="fas fa-trash"></i> {{ $size->name }}
                                                        </button>
                                                    </form>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
