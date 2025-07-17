@extends('layouts.user')

@section('title', 'Kelola Alamat')

@push('style')
@endpush

@section('main')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Kelola Alamat</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Kelola Alamat</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Address Management Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <!-- Form Tambah Alamat -->
                    <div class="col-lg-5">
                        <div class="text-center mb-3">
                            <h4 class="text-primary">Tambah Alamat</h4>
                        </div>
                        <div class="card shadow-sm">
                            <div class="card-body">

                                <form action="{{ route('addres.store') }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" name="name" class="form-control" placeholder="Nama"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="phone" class="form-control" placeholder="Telepon"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="province" class="form-control"
                                                placeholder="Provinsi" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="city" class="form-control" placeholder="Kota"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="kecamatan" class="form-control"
                                                placeholder="Kecamatan" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="postal_code" class="form-control"
                                                placeholder="Kode Pos" required>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="address_line1" class="form-control" rows="2" placeholder="Alamat Lengkap" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_default"
                                                    value="1" id="isDefault">
                                                <label class="form-check-label" for="isDefault">Jadikan alamat utama</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary w-100">Simpan Alamat</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Alamat -->
                    <div class="col-lg-7">
                        <div class="text-center mb-3">
                            <h4 class="text-primary">Daftar Alamat</h4>
                        </div>
                        @foreach ($addresses as $address)
                            <div class="card mb-3 shadow-sm {{ $address->is_default ? 'border-primary' : '' }}">
                                <div class="card-body">
                                    <h5 class="card-title mb-1">{{ $address->name }} |
                                        @if ($address->is_default)
                                            <span class="badge bg-primary">Utama</span>
                                        @endif
                                    </h5>
                                    <p class="mb-1">{{ $address->phone }}</p>
                                    <p class="mb-1">
                                        {{ $address->address_line1 }},
                                        {{ $address->kecamatan }}, {{ $address->city }},
                                        {{ $address->province }}, {{ $address->postal_code }}
                                    </p>
                                    <div class="d-flex justify-content-end">
                                        <!-- Hapus -->
                                        <form action="{{ route('addres.destroy', $address->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin hapus alamat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger me-2">Hapus</button>
                                        </form>

                                        <!-- Edit -->
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#editAddressModal{{ $address->id }}">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Alamat -->
                            <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1"
                                aria-labelledby="editAddressModalLabel{{ $address->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('addres.update', $address->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAddressModalLabel{{ $address->id }}">Edit
                                                    Alamat</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ $address->name }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="phone" class="form-control"
                                                            value="{{ $address->phone }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="province" class="form-control"
                                                            value="{{ $address->province }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="city" class="form-control"
                                                            value="{{ $address->city }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="kecamatan" class="form-control"
                                                            value="{{ $address->kecamatan }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="postal_code" class="form-control"
                                                            value="{{ $address->postal_code }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <textarea name="address_line1" class="form-control" rows="2" required>{{ $address->address_line1 }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_default" value="1"
                                                                id="isDefault{{ $address->id }}"
                                                                {{ $address->is_default ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="isDefault{{ $address->id }}">Jadikan alamat
                                                                utama</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Address Management End -->
@endsection

@push('scripts')
@endpush
