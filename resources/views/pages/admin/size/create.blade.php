@extends('layouts.admin')

@section('title', 'Tambah Size')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Size</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Size</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('size.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Size</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('size.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
