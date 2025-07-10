@extends('layouts.admin')

@section('title', 'Data Warna')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Warna</h1>
                <div class="section-header-button">
                    <a href="{{ route('color.create') }}" class="btn btn-primary">Tambah Warna</a>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">No</th>
                                        <th class="text-white">Nama Warna</th>
                                        <th class="text-white">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($colors as $color)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $color->name }}</td>
                                            <td>
                                                <a href="{{ route('color.edit', $color->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('color.destroy', $color->id) }}" method="POST"
                                                    class="d-inline-block" onsubmit="return confirm('Yakin hapus?')">
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
                            {{ $colors->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
