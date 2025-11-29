@extends('layouts.app')
@section('title', $item->slug)


@section('content')


<div class="container product-page">
    <div class="row g-5">

        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb" style="background: transparent;">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">{{ $item->category->name }}</a></li>
                    <li class="breadcrumb-item active">{{ $item->name }}</li>
                </ol>
            </nav>
        </div>
        <!-- LEFT IMAGES -->
        <div class="col-lg-5">

            <div class="product-main-image">
                <img id="mainImage" src="{{ Storage::url($item->featured_image_1) }}">
            </div>

            <div class="product-thumbs">
                @if($item->images && $item->images->count() > 0)
                @foreach($item->images as $key => $img)
                <div class="thumb-item {{ $key == 0 ? 'active' : '' }}">
                    <img
                        src="{{ Storage::url($img->image) }}"
                        data-large="{{ Storage::url($img->image) }}">
                </div>

                @endforeach
                @endif
            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-lg-7">

            <div class="text-left">
                <h1 class="product-titles">{{ $item->name }}</h1>
                <div class="product-sub">{{ $item->unit }}</div>

                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                     <span>2 customer reviews</span></div>

                <div class="product-price"><del class="text-danger" style="font-size:18px;">{{currency() }} {{ $item->regular_price }}</del> {{currency() }} {{ $item->sale_price }}</div>
                @if($item->category)
                <div class="mb-3">Category: <span class="badge bg-secondary me-2 text-light">{{ $item->category->name ?? '-' }}</span></div>
                @endif
                @if($item->brand)
                <div class="mb-3">Brand: <span class="badge bg-secondary">{{ $item->brand->name ?? '-' }}</span></div>
                @endif

                @if($item->vendor_id)
                <div class="mb-3">Seller: <span class="badge bg-secondary">{{ $item->vendor->name ?? '-' }}</span></div>
                @endif


                {{-- Variants --}}
                @php
                $firstVariant = $item->variants->first();
                @endphp
                @if($item->variants->count() > 0)
                <div class="variants mb-3">
                    @if($item->variants->pluck('color_id')->filter()->count() > 0)
                    <div class="mb-2">
                        <label>Color:</label>
                        <select id="variant-color" class="form-select">
                            @foreach($item->variants->whereNotNull('color_id')->unique('color_id') as $variant)
                            <option value="{{ $variant->id }}" data-price="{{ $variant->price }}" data-stock="{{ $variant->stock }}" data-color="{{ $variant->color->name ?? '' }}" data-size="{{ $variant->size?->name ?? '' }}">
                                {{ $variant->color->name ?? 'N/A' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    @if($item->variants->pluck('size_id')->filter()->count() > 0)
                    <div class="mb-2">
                        <label>Size:</label>
                        <select id="variant-size" class="form-select">
                            @foreach($item->variants->whereNotNull('size_id')->unique('size_id') as $variant)
                            <option value="{{ $variant->id }}" data-price="{{ $variant->price }}" data-stock="{{ $variant->stock }}" data-color="{{ $variant->color?->name ?? '' }}" data-size="{{ $variant->size->name }}">
                                {{ $variant->size->name ?? 'N/A' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-2">Price: {{currency()}}<span id="variant-price">{{ $firstVariant->price ?? $item->sale_price ?? $item->regular_price }}</span></div>
                    <div class="mb-2">Stock: <span id="variant-stock">{{ $firstVariant->stock ?? 100 }}</span></div>
                </div>
                @endif


                <!-- Quantity -->
                <div class="d-block d-lg-flex">
                    <div class="d-flex align-items-center">
                        <span class="me-3 fw-semibold">Quantity : </span>

                        <div class="input-group ml-2" style="max-width:160px;">
                            <button class="btn btn-outline-secondary btn-minus" style="border-radius: 0px;border-right: none;border-color: #ced4da;">-</button>
                            <input type="text" class="form-control text-center" id="qty" value="1" style="border-radius: 0px;border-right: none;border-left: none;">
                            <button class="btn btn-outline-secondary btn-plus" style="border-radius: 0px;border-left: none;border-color: #ced4da;">+</button>
                        </div>
                    </div>

                    <button
                        class="btn btn-lg btn-success ml-5 mt-3 mt-lg-0 text-light order-now-new"
                        data-id="{{ $item->id }}"
                        data-name="{{ $item->name }}"
                        data-slug="{{ $item->slug }}"
                        data-image="{{ Storage::url($item->featured_image_1) }}"
                        data-price="{{ $item->sale_price }}"
                        style="background-color:#00c753;color:#fff;padding:0 30px;line-height:42px;font-size:13px;text-transform:uppercase;border:1px solid #00c753;border-radius:5px;">
                        <i class="fas fa-shopping-cart cart-icon me-2 text-light"></i> ADD TO CART
                    </button>




                </div>
            </div>


        </div>
    </div>

</div>

<div class="container mt-4">
    <div class="row">


        <!-- Tabs Section -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Tab Navigation (Buttons) -->
                    <ul class="nav nav-pills" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a style="background-color: #00c753;" class="nav-link active" id="tab-description-tab" data-bs-toggle="pill" href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-additional-information-tab" data-bs-toggle="pill" href="#tab-additional-information" role="tab" aria-controls="tab-additional-information" aria-selected="false">Additional Information</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-reviews-tab" data-bs-toggle="pill" href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">Reviews (2)</a>
                        </li> -->
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="productTabsContent">

                        <!-- Description Tab -->
                        <div class="tab-pane fade show active text-left" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
                            {!! $item->description !!}
                        </div>

                        <!-- Additional Information Tab -->
                        <div class="tab-pane fade" id="tab-additional-information" role="tabpanel" aria-labelledby="tab-additional-information-tab">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Weight</th>
                                        <td>130 g</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                            <h5>Customer reviews</h5>
                            <div class="reviews-summary">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p>Rated <strong>3.00</strong> out of 5 by <span>2</span> ratings</p>
                                            </div>
                                            <div class="d-flex">
                                                <div class="progress me-2" style="width: 100px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">5 Star</div>
                                                </div>
                                                <div class="progress" style="width: 100px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">4 Star</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5>2 reviews for <span>ন্যাচারালস চিয়া সীড</span></h5>
                            <ul class="list-unstyled">
                                <li>
                                    <div class="media">
                                        <img src="https://secure.gravatar.com/avatar/31e989a5d866865860e60185e399c87e4448f66b078a11ae10c3a5e26fddda96?s=60" class="avatar me-3" alt="avatar">
                                        <div class="media-body">
                                            <h6 class="mt-0">mohiuddinsadique</h6>
                                            <p>October 18, 2020</p>
                                            <div class="star-rating" aria-label="Rated 5 out of 5">
                                                <span style="width:100%"></span>
                                            </div>
                                            <p>Good food..</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <img src="https://secure.gravatar.com/avatar/ff8c05788e56ef6624baa39f9f891bcc050110561ed32cf4d17c06215d47fc62?s=60" class="avatar me-3" alt="avatar">
                                        <div class="media-body">
                                            <h6 class="mt-0">Zannat</h6>
                                            <p>June 28, 2022</p>
                                            <div class="star-rating" aria-label="Rated 1 out of 5">
                                                <span style="width:20%"></span>
                                            </div>
                                            <p>Totally disappointed…seeds were mixed with black impurities like ashes and dirt..i almost felt nasueated when mixed with oatmeal. Not recommended.</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



@endsection



@section('script')


<script>
    // Optional: Activate the first tab if not already active
    document.addEventListener('DOMContentLoaded', function() {
        var firstTab = new bootstrap.Tab(document.querySelector('#productTabs .nav-link.active'));
        firstTab.show();
    });
</script>



<script>
    // ✅ Product View Tracking (fires on page load)
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        event: "view_item",
        ecommerce: {
            items: [{
                item_name: "{{ $item->name }}",
                item_id: "{{ $item->id }}",
                price: "{{ $item->sale_price ?? $item->regular_price }}",
                item_brand: "{{ $item->brand->name ?? '' }}",
                item_category: "{{ $item->category->name ?? '' }}",
                item_variant: "{{ $item->variants->count() > 0 ? 'Has Variant' : 'Single' }}",
                currency: "BDT"
            }]
        }
    });

    // ✅ Add to Cart / Order Now button tracking
    document.getElementById('add-to-cart').addEventListener('click', function() {
        const productName = this.dataset.name;
        const productId = this.dataset.productId;
        const productPrice = this.dataset.price;
        const productImage = this.dataset.image;

        dataLayer.push({
            event: "add_to_cart",
            ecommerce: {
                items: [{
                    item_name: productName,
                    item_id: productId,
                    price: productPrice,
                    item_image: productImage,
                    quantity: document.getElementById('qty').value,
                    currency: "BDT"
                }]
            }
        });
        console.log("✅ DataLayer event pushed: add_to_cart");
    });
</script>

@endsection