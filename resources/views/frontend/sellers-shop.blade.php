@extends('layouts.app')

@section('title', $sellers->shop_name . ' | Shop')

@section('css')
<style>
    /* Full Width Banner */
    .seller-hero {
        width: 100%;
        height: 300px;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        position: relative;
        display: flex;
        align-items: flex-end;
        padding-bottom: 80px;
    }

    /* Dark overlay on banner */
    .seller-hero-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .hero-content {
        z-index: 5;
    }

    .seller-info-card {
        border-radius: 15px;
        backdrop-filter: blur(4px);
        background: rgba(255, 255, 255, 0.92);
    }

    .seller-logo-lg {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border: 5px solid #fff;
    }

    .seller-info-card h2 {
        color: #222;
    }

    .seller-info-card p {
        color: #444;
    }
</style>
@endsection

@section('content')

<div class="container-fluid px-0">

    <!-- Seller Header -->
    <div class="seller-hero" style="background-image: url('{{ Storage::url($sellers->banner) }}');">

        <div class="seller-hero-overlay"></div>

        <div class="container position-relative hero-content">

            <div class="row justify-content-center">
                <div class="col-md-10">

                    <!-- Floating Seller Card -->
                    <div class="card shadow-lg border-0 p-4 seller-info-card">

                        <div class="row align-items-center">

                            <div class="col-md-3 text-center">
                                <img src="{{ Storage::url($sellers->logo) }}"
                                    class="img-fluid rounded-circle shadow seller-logo-lg"
                                    alt="{{ $sellers->shop_name }}">
                            </div>

                            <div class="col-md-9">

                                <h2 class="font-weight-bold mb-2">
                                    {{ $sellers->shop_name }}
                                </h2>

                                <p class="mb-1">
                                    <i class="fa fa-phone text-success"></i>
                                    {{ $sellers->phone }}
                                </p>

                                <p class="mb-2">
                                    <i class="fa fa-map-marker-alt text-danger"></i>
                                    {{ $sellers->address }}
                                </p>


                                <a href="https://wa.me/{{ $sellers->phone }}" target="_blank"
                                    class="btn btn-success btn-sm mt-2">
                                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                                </a>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="container py-5">
    <!-- Products Section -->
    <h4 class="border-bottom font-weight-bold mb-4 py-3 rounded section-title text-left text-success">Products from this Seller</h4>

    <div class="row g-4">
        @foreach ($sellers->products as $product)
        <div class="col-lg-3 col-6">
            <div class="product-card mb-3">
                <div class="position-relative">
                    <img src="{{ Storage::url($product->featured_image_1) }}" alt="Product Image" class="product-img">
                    <img src="{{ Storage::url($product->featured_image_2) }}" alt="Hover Image"
                        class="product-img-hover">
                </div>
                <div class="product-info text-left">
                    <h5 class="product-title">
                        <a href="{{ route('product.single',$product->slug) }}" class="text-dark">{{ $product->name
                            }}</a>
                    </h5>
                    <p class="product-grams">{{ $product->unit }}</p>
                    <div class="d-none d-lg-block">
                        <div class="d-flex justify-content-between">
                            <span class="product-price">{{currency()}} {{ number_format($product->sale_price, 2)
                                }}</span>
                            <span class="rating"><i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i> {{ $product->reviews_count }}</span>
                        </div>
                    </div>
                    <div class="d-block d-lg-none">
                        <span class="rating d-block"><i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i> {{ $product->reviews_count }}</span>
                        <span class="product-price d-block">{{currency()}} {{ number_format($product->sale_price, 2)
                            }}</span>
                    </div>
                    <button class="btn-cart mb-2 mt-lg-5 order-now" data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}" data-slug="{{ $product->slug }}"
                        data-image="{{ Storage::url($product->featured_image_1) }}"
                        data-price="{{ $product->sale_price }}"
                        data-has-variant="{{ $product->variants->count() > 0 ? '1' : '0' }}">
                        <span class="cart-icon"><i class="fas fa-shopping-cart"></i></span> Add to Cart
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection