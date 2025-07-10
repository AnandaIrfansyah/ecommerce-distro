@extends('layouts.admin')

@section('title', 'Dashboard')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kategori</h1>
                <div class="section-header-button">
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary">Add New</a>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table-bordered table text-center">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="text-white">No</th>
                                                <th class="text-white">Icon</th>
                                                <th class="text-white">Kategori</th>
                                                <th class="text-white">#</th>
                                            </tr>
                                        </thead>
                                        @foreach ($kategoris as $kategori)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <i class="{{ $kategori->icon }} fa-2x"></i>
                                                </td>
                                                <td>{{ $kategori->name }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('kategori.edit', $kategori->id) }}"
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <form action="{{ route('kategori.destroy', $kategori->id) }}"
                                                            method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                {{ $kategoris->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
