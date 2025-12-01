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




<!-- <section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-lg">
          <div class="card-body p-5">
            <h2 class="text-center mb-2">Become a Holistica Seller</h2>
            <p class="text-center text-muted mb-4">Join our platform and start selling your service today 🚀</p>

            <form>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Full Name</label>
                  <input type="text" class="form-control" placeholder="Enter your full name">
                </div>
                <div class="form-group col-md-6">
                  <label>Email Address</label>
                  <input type="email" class="form-control" placeholder="Enter your email">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Phone Number</label>
                  <input type="text" class="form-control" placeholder="Enter phone number">
                </div>
                <div class="form-group col-md-6">
                  <label>Service Category</label>
                  <select class="form-control">
                    <option selected disabled>Select a category</option>
                    <option>Web Development</option>
                    <option>Graphic Design</option>
                    <option>Digital Marketing</option>
                    <option>Content Writing</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control" rows="3" placeholder="Tell us about your service"></textarea>
              </div>

              <div class="form-group">
                <label>Portfolio / Website (optional)</label>
                <input type="url" class="form-control" placeholder="https://">
              </div>

              <button type="submit" class="btn btn-primary btn-block btn-lg mt-4">Register as Seller</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> -->

<!-- Holistica Approved Certificate Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2>Holistica Approved & Certified</h2>
      <p class="text-muted">We are officially recognized and trusted platform</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow text-center p-4">
          <div class="mb-3">
            <i class="fas fa-certificate fa-3x text-primary"></i>
          </div>
          <h5>ISO Certified</h5>
          <p class="text-muted">International quality and service standard approval</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow text-center p-4">
          <div class="mb-3">
            <i class="fas fa-shield-alt fa-3x text-success"></i>
          </div>
          <h5>Secure Platform</h5>
          <p class="text-muted">Protected data and verified seller environment</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow text-center p-4">
          <div class="mb-3">
            <i class="fas fa-award fa-3x text-warning"></i>
          </div>
          <h5>Trusted by Clients</h5>
          <p class="text-muted">Hundreds of happy and verified customers........</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Brand Section -->
<section class="py-5 bg-white">
  <div class="container text-center">
    <h3 class="mb-4 text-primary">Trusted by Leading Brands</h3>
    <p class="text-muted mb-5">Holistica works with top companies and trusted partners around the globe.</p>

    <div class="row justify-content-center align-items-center">
      <div class="col-6 col-md-2 mb-4">
        <img src="{{asset('/assets/img/brand.png')}}" class="img-fluid shadow grayscale" alt="Brand 1">
      </div>
      <div class="col-6 col-md-2 mb-4">
        <img src="{{asset('/assets/img/brand.png')}}" class="img-fluid shadow grayscale" alt="Brand 2">
      </div>
      <div class="col-6 col-md-2 mb-4">
        <img src="{{asset('/assets/img/brand.png')}}" class="img-fluid shadow grayscale" alt="Brand 3">
      </div>
      <div class="col-6 col-md-2 mb-4">
        <img src="{{asset('/assets/img/brand.png')}}" class="img-fluid shadow grayscale" alt="Brand 4">
      </div>
      <div class="col-6 col-md-2 mb-4">
        <img src="{{asset('/assets/img/brand.png')}}" class="img-fluid shadow grayscale" alt="Brand 5">
      </div>
    </div>
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




<!-- Holistica অনুমোদিত / সার্টিফাইড প্রোডাক্ট সেকশন -->
<section class="py-5" style="background: linear-gradient(135deg, #e6f0ff, #ffffff);">
  <div class="container">
    <div class="row align-items-center">

      <!-- বাম দিক: সার্টিফিকেট ইমেজ -->
      <div class="col-lg-5 text-center mb-4 mb-lg-0">
        <div class="card shadow-lg border-0 rounded-lg p-4" style="background: rgba(255,255,255,0.9);">
          <img src="https://image.slidesharecdn.com/7990d783-3a39-421a-b334-085d00057eaf-160513111659/75/BDA-Certificated-1-2048.jpg" class="img-fluid" alt="Holistica সার্টিফিকেট">
        </div>
      </div>

      <!-- ডান দিক: বিস্তারিত -->
      <div class="col-lg-7">
        <h2 class="text-success mb-3">Holistica অনুমোদিত প্রোডাক্ট</h2>
        <p class="text-muted mb-4">
          আমাদের প্রোডাক্টগুলো Holistica কর্তৃক আনুষ্ঠানিকভাবে অনুমোদিত ও সার্টিফাইড। তাই আপনি আমাদের সলিউশন ব্যবহার করে নিশ্চিন্তে আপনার ব্যবসার কার্যক্ষমতা বৃদ্ধি করতে পারেন। 
          আমাদের লক্ষ্য: বিশ্বাসযোগ্যতা, নিরাপত্তা এবং ব্যবহারবান্ধবতা।
        </p>

        <ul class="list-unstyled text-muted">
          <li class="mb-3">
            <i class="fa fa-check text-success mr-2"></i>
            সারা বিশ্বের শত শত সন্তুষ্ট গ্রাহক দ্বারা বিশ্বাসযোগ্য
          </li>
          <li class="mb-3">
            <i class="fa fa-check text-success mr-2"></i>
            উচ্চ মানের স্ট্যান্ডার্ড এবং ISO-স্তরের যাচাই
          </li>
          <li class="mb-3">
            <i class="fa fa-check text-success mr-2"></i>
            নিরাপদ, নির্ভরযোগ্য এবং সহজে ব্যবহারযোগ্য প্ল্যাটফর্ম
          </li>
          <li class="mb-3">
            <i class="fa fa-check text-success mr-2"></i>
            মসৃণ অভিজ্ঞতা নিশ্চিত করতে ডেডিকেটেড সাপোর্ট
          </li>
        </ul>

        <a href="#contact" class="btn btn-primary btn-lg mt-3" style="background-color:#28a745 !important;border:none;">আরও জানুন / সার্টিফাইড পণ্য পান</a>
      </div>

    </div>
  </div>
</section>



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



<!-- Offer Modal -->
<div class="modal fade" id="offerModal" tabindex="-1" role="dialog" aria-labelledby="offerModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content rounded-lg shadow-lg">
      <div class="modal-header border-0">
        <h5 class="modal-title text-primary" id="offerModalLabel">Special Offer Just for You!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="{{asset('/assets/img/offer.png')}}" class="img-fluid mb-3" alt="Offer">
        <h4>Get 20% Discount on Your First Purchase 🚀</h4>
        <p class="text-muted">Hurry! This special offer is only valid for a limited time. Join Holistica now and enjoy premium benefits.</p>
        <a href="#register" class="btn btn-primary btn-lg mt-3">Claim Offer</a>
      </div>
    </div>
  </div>
</div>


<section class="py-5" style="background: #f5f5f5;">
  <div class="container">
    <!-- Header -->
    <div class="text-center mb-5">
      <h1 style="color:#28A745;">Holistica অ্যাফিলিয়েট & সেলার প্রোগ্রাম</h1>
      <p class="text-muted">Holistica প্ল্যাটফর্মে সেলার বা অ্যাফিলিয়েট হিসাবে যোগ দিন এবং আমাদের প্রোডাক্ট প্রোমোট করে কমিশন অর্জন করুন। আজই আপনার ব্যবসা শুরু করুন!</p>
    </div>

    <!-- কিভাবে কাজ করে Section -->
    <div class="row mb-5">
      <div class="col-md-4 text-center mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <i class="fa fa-user-plus fa-3x text-success mb-3"></i>
          <h5>রেজিস্ট্রেশন করুন</h5>
          <p class="text-muted">সাধারণ ব্যবহারকারী বা সেলার/ভেন্ডর হিসেবে রেজিস্টার করে Holistica ইকোসিস্টেমে যোগ দিন।</p>
        </div>
      </div>
      <div class="col-md-4 text-center mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <i class="fa fa-shopping-cart fa-3x text-success mb-3"></i>
          <h5>প্রোডাক্ট প্রোমোট করুন</h5>
          <p class="text-muted">আপনার অ্যাফিলিয়েট লিঙ্ক শেয়ার করুন বা সেলার হিসেবে প্রোডাক্ট লিস্ট করুন এবং কমিশন অর্জন শুরু করুন।</p>
        </div>
      </div>
      <div class="col-md-4 text-center mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <i class="fa fa-money-bill-wave fa-3x text-success mb-3"></i>
          <h5>কমিশন অর্জন করুন</h5>
          <p class="text-muted">আপনার লিঙ্ক বা সেলার অ্যাকাউন্টের মাধ্যমে প্রতিটি সফল অর্ডারের জন্য কমিশন পান।</p>
        </div>
      </div>
    </div>

    <!-- কমিশন লেভেল Section -->
    <div class="row mb-5">
      <div class="col-md-12 text-center mb-4">
        <h3 style="color:#28A745;">অ্যাফিলিয়েট কমিশন লেভেল</h3>
        <p class="text-muted">প্রোডাক্ট ক্যাটেগরি এবং অর্ডার ভলিউম অনুযায়ী কমিশন হার নির্ধারিত</p>
      </div>
      <div class="col-md-12">
        <div class="table-responsive shadow-sm">
          <table class="table table-bordered table-hover">
            <thead class="thead-light">
              <tr>
                <th>লেভেল</th>
                <th>অর্ডার ভলিউম</th>
                <th>কমিশন হার</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>লেভেল ১</td>
                <td>১-৫০ অর্ডার</td>
                <td>৫%</td>
              </tr>
              <tr>
                <td>লেভেল ২</td>
                <td>৫১-২০০ অর্ডার</td>
                <td>৭%</td>
              </tr>
              <tr>
                <td>লেভেল ৩</td>
                <td>২০১+ অর্ডার</td>
                <td>১০%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- সেলার / ভেন্ডর সুবিধা Section -->
    <div class="row mb-5 align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="{{asset('/assets/img/seller-commision.png')}}" class="img-fluid rounded" alt="Vendor Benefits">
      </div>
      <div class="col-lg-6">
        <h3 style="color:#28A745;">কেন Holistica সেলার/ভেন্ডর হওয়া উচিত?</h3>
        <ul class="list-unstyled text-muted mt-3">
          <li class="mb-3"><i class="fa fa-check text-success mr-2"></i>কম বিনিয়োগে আপনার নিজস্ব ব্যবসা শুরু করুন</li>
          <li class="mb-3"><i class="fa fa-check text-success mr-2"></i>গ্লোবাল কাস্টমার এবং হোলসেল ক্রেতাদের অ্যাক্সেস</li>
          <li class="mb-3"><i class="fa fa-check text-success mr-2"></i>অর্ডার ট্র্যাক, সেল ম্যানেজ এবং কমিশন সহজে পান</li>
          <li class="mb-3"><i class="fa fa-check text-success mr-2"></i>বিশ্বাসযোগ্য ও নিরাপদ প্ল্যাটফর্মে ডেডিকেটেড সাপোর্ট</li>
        </ul>
        <a href="#register" class="btn btn-success btn-lg mt-3" style="background:#00B652; border:none;">সেলার/ভেন্ডর হিসেবে যোগ দিন</a>
      </div>
    </div>

    <!-- নতুন উদ্যোক্তাদের জন্য Section -->
    <div class="row mb-5">
      <div class="col-md-12 text-center">
        <h3 style="color:#28A745;">নতুন উদ্যোক্তাদের জন্য সুযোগ</h3>
        <p class="text-muted mb-4">Holistica এর প্রোডাক্ট এবং প্ল্যাটফর্ম ব্যবহার করে আপনার ব্যবসা শুরু করুন। হোলসেল ডিটেইল, অফার এবং অ্যাফিলিয়েট সাপোর্টসহ।</p>
      </div>
      <div class="col-md-4 text-center mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <i class="fa fa-box fa-3x text-success mb-3"></i>
          <h5>হোলসেল প্রোডাক্ট</h5>
          <p class="text-muted">বিশেষ মূল্যে বড় পরিমাণে প্রোডাক্ট অ্যাক্সেস করুন।</p>
        </div>
      </div>
      <div class="col-md-4 text-center mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <i class="fa fa-rocket fa-3x text-success mb-3"></i>
          <h5>দ্রুত সেটআপ</h5>
          <p class="text-muted">আপনার সেলার অ্যাকাউন্ট দ্রুত রেডি করুন এবং প্রোডাক্ট লিস্টিং শুরু করুন।</p>
        </div>
      </div>
      <div class="col-md-4 text-center mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <i class="fa fa-users fa-3x text-success mb-3"></i>
          <h5>অ্যাফিলিয়েট সাপোর্ট</h5>
          <p class="text-muted">প্রোডাক্ট প্রোমোট করে সহজেই কমিশন অর্জন করুন।</p>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="row">
      <div class="col-md-12 text-center">
        <a href="#register" class="btn btn-lg btn-success" style="background:#00B652; border:none;">আজই Holistica এর সাথে আপনার ব্যবসা শুরু করুন</a>
      </div>
    </div>

  </div>
</section>


@endsection



@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // 5 সেকেন্ড পরে modal open হবে
  setTimeout(function() {
    $('#offerModal').modal({
      backdrop: 'static', // backdrop click করলে close হবে না
      keyboard: false     // ESC key চাপলেও close হবে না
    });
    $('#offerModal').modal('show');
  }, 5000);

  // শুধু close button এ click করলে modal hide হবে
  document.querySelector('#offerModal .close').addEventListener('click', function() {
    $('#offerModal').modal('hide');
  });
});
</script>

@endsection