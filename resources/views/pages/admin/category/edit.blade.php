@extends('layouts.admin')

@section('title', 'Edit Kategori')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Kategori</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Edit Kategori</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nama Kategori</label>
                                <input type="text" name="name" value="{{ $kategori->name }}" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="icon">Icon (class FontAwesome)</label>
                                <input type="text" name="icon" value="{{ $kategori->icon }}" class="form-control"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
