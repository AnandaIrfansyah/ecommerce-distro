@extends('layouts.user')

@section('title', 'Detail')

@push('style')
    <style>
        .out-of-stock {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
@endpush


@section('main')
    @php
        $variantsData = $product->variants
            ->map(function ($v) {
                return [
                    'size_id' => $v->size_id,
                    'color_id' => $v->color_id,
                    'stock' => $v->stock,
                ];
            })
            ->values();
    @endphp

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop Detail</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Shop Detail</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                                    alt="{{ $product->name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{ $product->name }}</h4>
                            <p class="mb-3">Category: {{ $product->category->name ?? 'No Category' }}</p>
                            <h5 class="fw-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h5>
                            <div class="d-flex mb-4">
                                @for ($i = 0; $i < 4; $i++)
                                    <i class="fa fa-star text-secondary"></i>
                                @endfor
                                <i class="fa fa-star"></i>
                            </div>
                            <p class="mb-4">{{ $product->description }}</p>
                            <div class="mb-3">
                                @php
                                    $selectedSize = request('size');
                                    $selectedColor = request('color');
                                    $totalStock = $product->variants
                                        ->filter(function ($variant) use ($selectedSize, $selectedColor) {
                                            return (!$selectedSize || $variant->size_id == $selectedSize) &&
                                                (!$selectedColor || $variant->color_id == $selectedColor);
                                        })
                                        ->sum('stock');
                                @endphp

                                <h6 class="fw-bold">Stok Tersedia: <span id="stok-tersedia"
                                        class="text-primary">{{ $totalStock }}</span></h6>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-bold">Pilih Ukuran:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="d-flex flex-wrap gap-2" id="size-buttons">
                                        @foreach ($product->sizes as $size)
                                            @php
                                                $hasStock =
                                                    $product->variants
                                                        ->where('size_id', $size->id)
                                                        ->when(
                                                            request('color'),
                                                            fn($q) => $q->where('color_id', request('color')),
                                                        )
                                                        ->sum('stock') > 0;

                                                $isActive = request('size') == $size->id;
                                            @endphp
                                            <button type="button"
                                                class="btn {{ $hasStock ? 'btn-outline-secondary' : 'btn-outline-danger disabled out-of-stock' }} {{ $isActive ? 'active' : '' }}"
                                                data-size="{{ $size->id }}" {{ $hasStock ? '' : 'disabled' }}>
                                                {{ $size->name }}
                                            </button>
                                        @endforeach
                                        @if (request('color'))
                                            <input type="hidden" name="color" value="{{ request('color') }}">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Pilih Color --}}
                            <div class="mb-3">
                                <h6 class="fw-bold">Pilih Warna:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="d-flex flex-wrap gap-2" id="color-buttons">
                                        @foreach ($product->colors as $color)
                                            @php
                                                $hasStock =
                                                    $product->variants
                                                        ->where('color_id', $color->id)
                                                        ->when(
                                                            request('size'),
                                                            fn($q) => $q->where('size_id', request('size')),
                                                        )
                                                        ->sum('stock') > 0;

                                                $isActive = request('color') == $color->id;
                                            @endphp
                                            <button type="button"
                                                class="btn {{ $hasStock ? 'btn-outline-secondary' : 'btn-outline-danger disabled out-of-stock' }} {{ $isActive ? 'active' : '' }}"
                                                data-color="{{ $color->id }}" {{ $hasStock ? '' : 'disabled' }}>
                                                {{ $color->name }}
                                            </button>
                                        @endforeach
                                        @if (request('size'))
                                            <input type="hidden" name="size" value="{{ request('size') }}">
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="input-group quantity mb-3" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0"
                                    value="1" id="quantity-input">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="size_id" value="{{ request('size') }}">
                                <input type="hidden" name="color_id" value="{{ request('color') }}">
                                <input type="hidden" name="quantity" id="cart-quantity" value="1">

                                <button type="submit"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary {{ $totalStock == 0 ? 'disabled' : '' }}"
                                    {{ $totalStock == 0 ? 'disabled' : '' }}>
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                    {{ $totalStock == 0 ? 'Stok Habis' : 'Add to cart' }}
                                </button>
                            </form>


                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Description</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="false">Reviews</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel"
                                    aria-labelledby="nav-about-tab">
                                    <p>The generated Lorem Ipsum is therefore always free from repetition injected
                                        humour,
                                        or non-characteristic words etc.
                                        Susp endisse ultricies nisi vel quam suscipit </p>
                                    <p>Sabertooth peacock flounder; chain pickerel hatchetfish, pencilfish snailfish
                                        filefish Antarctic
                                        icefish goldeye aholehole trumpetfish pilot fish airbreathing catfish, electric
                                        ray
                                        sweeper.</p>
                                    <div class="px-2">
                                        <div class="row g-4">
                                            <div class="col-6">
                                                <div
                                                    class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Weight</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">1 kg</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Country of Origin</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">Agro Farm</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="row bg-light text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Quality</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">Organic</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Сheck</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">Healthy</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="row bg-light text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Min Weight</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">250 Kg</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel"
                                    aria-labelledby="nav-mission-tab">
                                    <div class="d-flex">
                                        <img src="user/img/avatar.jpg" class="img-fluid rounded-circle p-3"
                                            style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Jason Smith</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p>The generated Lorem Ipsum is therefore always free from repetition
                                                injected
                                                humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <img src="user/img/avatar.jpg" class="img-fluid rounded-circle p-3"
                                            style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Sam Peters</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark">The generated Lorem Ipsum is therefore always free
                                                from
                                                repetition injected humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et
                                        tempor
                                        sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos
                                        labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                            <div class="input-group w-100 mx-auto d-flex mb-4">
                                <input type="search" class="form-control p-3" placeholder="keywords"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                            <div class="mb-4">
                                <h4>Categories</h4>
                                <ul class="list-unstyled fruite-categorie">
                                    @foreach ($categories as $category)
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('products.byCategory', $category->id) }}">
                                                    <i class="fas fa-apple-alt me-2"></i>{{ $category->name }}
                                                </a>
                                                <span>({{ $category->products_count }})</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="position-relative">
                                <img src="{{ asset('user/img/banner-fruits.jpg') }}" class="img-fluid w-100 rounded"
                                    alt="">
                                <div class="position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%);">
                                    <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Related products</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($relatedProducts as $item)
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <a href="{{ route('detail.show', $item->id) }}">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid w-100 rounded-top"
                                        alt="{{ $item->name }}">
                                </a>
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                style="top: 10px; right: 10px;">
                                {{ $item->category->name ?? 'No Category' }}
                            </div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>{{ $item->name }}</h4>
                                <p>{{ Str::limit($item->description, 60) }}</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">Rp
                                        {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        const variants = @json($variantsData);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedSize = '{{ request('size') }}';
            let selectedColor = '{{ request('color') }}';

            const sizeButtons = document.querySelectorAll('#size-buttons button');
            const colorButtons = document.querySelectorAll('#color-buttons button');
            const stokSpan = document.getElementById('stok-tersedia');
            const quantityInput = document.getElementById('quantity-input');
            const hiddenQuantity = document.getElementById('cart-quantity');

            const sizeInput = document.querySelector('input[name="size_id"]');
            const colorInput = document.querySelector('input[name="color_id"]');

            let maxStock = {{ $totalStock }};

            function getStock(size, color) {
                return variants.filter(v =>
                    (!size || v.size_id == size) &&
                    (!color || v.color_id == color)
                ).reduce((sum, v) => sum + v.stock, 0);
            }

            function updateStockDisplay() {
                const stock = getStock(selectedSize, selectedColor);
                stokSpan.textContent = stock;

                if (parseInt(quantityInput.value) > stock) {
                    quantityInput.value = stock > 0 ? stock : 1;
                    hiddenQuantity.value = quantityInput.value;
                }

                maxStock = stock;
            }

            sizeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    selectedSize = btn.dataset.size;
                    sizeInput.value = selectedSize;
                    sizeButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    updateStockDisplay();
                });
            });

            colorButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    selectedColor = btn.dataset.color;
                    colorInput.value = selectedColor;
                    colorButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    updateStockDisplay();
                });
            });

            document.querySelector('.btn-plus').addEventListener('click', () => {
                let qty = parseInt(quantityInput.value);
                if (qty < maxStock) {
                    qty++;
                    quantityInput.value = qty;
                    hiddenQuantity.value = qty;
                }
            });

            document.querySelector('.btn-minus').addEventListener('click', () => {
                let qty = parseInt(quantityInput.value);
                if (qty > 1) {
                    qty--;
                    quantityInput.value = qty;
                    hiddenQuantity.value = qty;
                }
            });

            quantityInput.value = 1;
            hiddenQuantity.value = 1;

            updateStockDisplay();
        });
    </script>
@endpush
