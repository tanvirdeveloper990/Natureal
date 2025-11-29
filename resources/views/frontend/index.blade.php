@extends('layouts.app')

@section('title', 'Home')

@section('content')




@if($banner->title || $banner->image)
<section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <img src="{{Storage::url($banner->image ?? '')}}" alt="" class="img-fluid">
      </div>
    </div>
  </div>
</section>
@endif

<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul role="tablist" class="custom-tabs-list nav nav-tabs pt-5">
          @foreach ($categories as $category)
          <li class="custom-tab-item {{ $loop->first ? 'active' : '' }}">
            <a href="#tab-{{ $category->id }}" class="custom-tab-link" data-toggle="tab">
              <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="custom-tab-img">
              {{ $category->name }}
            </a>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  <!-- Product Sections -->
  <div class="container">
    @foreach ($categories as $category)
    <div id="tab-{{ $category->id }}" class="product-section {{ $loop->first ? 'active' : '' }}">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <!-- Product List (Each Product) -->
        @foreach ($category->products as $product)
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
    @endforeach
  </div>
</section>



<!-- Clients Section -->
<div class="container text-center testimonial-slider pt-5">
  <h2 class="mb-5">What Our Happy Customers Say</h2>
  <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">

      @foreach ($customer_reviews->chunk(3) as $chunk) <!-- Group reviews into chunks of 3 for each carousel item -->
      <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
        <div class="row">
          @foreach ($chunk as $review) <!-- Loop through each review in the chunk -->
          <div class="col-12 col-md-4">
            <div class="testimonial-card">
              <img src="{{ asset('storage/' . $review->image) }}" alt="Customer Image">
              <h5>{{ $review->name }}</h5>
              <p>{{ $review->designation ?? 'Customer' }}</p>
              <p>{{ $review->review_text }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach

    </div>

    <!-- Custom indicators -->
    <div class="carousel-indicators">
      @foreach ($customer_reviews->chunk(3) as $index => $chunk)
      <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $index }}"
        class="{{ $loop->first ? 'active' : '' }}"
        aria-current="{{ $loop->first ? 'true' : 'false' }}"
        aria-label="Slide {{ $index + 1 }}"></button>
      @endforeach
    </div>
  </div>
</div>



<!-- Blog -->
<section class="blog-section">
  <!-- Card container -->
  <div class="container">
    <div class="row g-4">
      <!-- card 1 -->
      @foreach($blogs as $item)
      <div class="col-12 col-sm-6 col-lg-3 mb-3">
        <div class="blog-card">
          <!-- card image -->
          <div class="card-image-wrapper">
            <img src="{{Storage::url($item->image) }}" alt="{{$item->title}}" />
          </div>
          <div class="card-content">
            <h3>{{$item->title}}</h3>
            <p>
              {{$item->short_decription}}
            </p>
            <a href="{{route('blogs-single',$item->slug)}}" class="btn btn-primary" style="background-color:#28a745 !important;border:none;">Read more</a>
            <!--<a href="{{route('blogs-single',$item->id)}}" class="read-more-btn">Read more</a>-->
          </div>
        </div>
      </div>
      @endforeach


    </div>
  </div>
</section>

@endsection