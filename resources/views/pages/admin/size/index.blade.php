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
                                        <th class="text-white">Size</th>
                                        <th class="text-white">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sizes as $size)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $size->name }}</td>
                                            <td>
                                                <a href="{{ route('size.edit', $size->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('size.destroy', $size->id) }}" method="POST"
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
                            {{ $sizes->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
