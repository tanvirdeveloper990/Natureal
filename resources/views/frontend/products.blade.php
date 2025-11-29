@extends('layouts.app')
@section('title','Products')
@section('content')

<section id="new-products" class="bg-light py-5">
    <div class="container">
       <h2 class="text-left mb-4 py-3 section-title text-dark rounded border-bottom">
    {{ $categoryName }}
</h2>

        <div class="row g-4">
            @foreach ($products as $product)
            <div class="col-lg-3 col-6">
                <div class="product-card mb-3">
                    <div class="position-relative">
                        <img src="{{ Storage::url($product->featured_image_1) }}" alt="Product Image" class="product-img">
                        <img src="{{ Storage::url($product->featured_image_2) }}" alt="Hover Image" class="product-img-hover">
                    </div>
                    <div class="product-info text-left">
                        <h5 class="product-title">
                            <a href="{{ route('product.single',$product->slug) }}" class="text-dark">{{ $product->name }}</a>
                        </h5>
                        <p class="product-grams">{{ $product->unit }}</p>
                        <div class="d-none d-lg-block">
                            <div class="d-flex justify-content-between">
                                <span class="product-price">{{currency()}} {{ number_format($product->sale_price, 2) }}</span>
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
                            <span class="product-price d-block">{{currency()}} {{ number_format($product->sale_price, 2) }}</span>
                        </div>
                        <button class="btn-cart mb-2 mt-lg-5 order-now" data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-slug="{{ $product->slug }}"
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
</section>
@endsection