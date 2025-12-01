@php
use App\Models\Wishlist;
$wishlistCount = 0;

if (auth()->check()) {
$wishlistCount = Wishlist::where('user_id', auth()->id())->count();
}
@endphp

<header class="d-lg-block d-none top-header">
	<div class="container-fluid">
		<div class="row align-items-center">
			<!-- Logo Section -->
			<div class="col-lg-6 col-md-6 col-6">
				<div class="logo-section">

					<a href="{{ route('index') }}" class="navbar-brand fw-bold">
						@if($setting->header_logo)
						<img class="img-fluid" src="{{ Storage::url($setting->header_logo) }}" alt="{{ $setting->company_name }}">
						@else
						Logo
						@endif
					</a>


					<a href="{{ route('index') }}" class="text-decoration-none text-light ms-3">Home</a>
					<a href="{{ route('products') }}" class="text-decoration-none text-light">Products</a>
					<a href="{{ route('sellers') }}" class="text-decoration-none text-light">Sellers</a>
					<a href="{{ route('affiliate.register') }}" class="text-decoration-none text-light">Affiliate</a>
					<a href="{{ route('about') }}" class="text-decoration-none text-light">about us</a>
					{{-- <a href="{{ route('contacts') }}" class="text-decoration-none text-light">Contact</a> --}}
				</div>
			</div>

			<!-- Search Box -->
			<div class="col-lg-3 col-md-3 col-12 mt-md-0 mt-3">
				<div class="search-container">
					<input type="text" class="search-input" id="searchInput" placeholder="I'm searching for...">
					<button class="search-btn">
						<i class="fas fa-search"></i> SEARCH
					</button>
				</div>

				<!-- 🔍 Live Search Result -->
				<div id="searchResults"
					class="position-absolute bg-white shadow rounded mt-1 w-100 z-10 d-none top-100"
					style="max-height: 350px; overflow-y: auto;">
				</div>
			</div>

			<!-- Cart Section -->
			<div class="col-lg-3 col-md-3 col-6 text-start">
				<div class="cart-section justify-content-center">
					<div class="cart-icon-wrapper" id="cart">
						<i class="fas fa-shopping-cart cart-icon"></i>
						<span class="cart-badge" id="cartCount">0</span>
					</div>
					<div>
						<span class="cart-text" id="cart-toggle">
							My Shopping Cart
							<i class="fas fa-chevron-down dropdown-icon"></i>
						</span>
					</div>
				</div>

				<!-- Cart Details Container -->
				<div id="cart-details" class="cart-details d-none">
					<div class="cart-arrow"></div>

					<!-- Cart Items will be dynamically appended here -->
					<div id="cart-items"></div>

					<!-- Cart Total -->
					<div class="cart-total">
						<p>Subtotal: <span class="cart-total-amount" id="cartTotal">0.00</span></p>
					</div>

					<!-- Cart Actions -->
					<div class="cart-actions">
						<button class="view-cart-btn" onclick="window.location.href='/checkout'">VIEW CART</button>
						<button class="checkout-btn" onclick="window.location.href='/checkout'">CHECKOUT</button>
					</div>
				</div>



			</div>



		</div>
	</div>
</header>


<div class="d-lg-none d-block">
	<div class="mobile-nav">
		<!-- Left Bar (Hamburger Menu) -->
		<div class="hamburger-menu">
			<i class="fa fa-bars"></i>
		</div>

		<!-- Sidebar (Initially Hidden) -->
		<!-- Sidebar (Initially Hidden) -->
		<div class="sidebar">
			<div class="sidebar-header">
				<!-- Menu Button with Icon -->
				<div class="menu-btn">
					<i class="fa fa-bars"></i> <span>Menu</span>
				</div>
				<!-- Categories Button with Icon -->
				<div class="categories-btn">
					<i class="fa fa-th-list"></i> <span>Categories</span>
				</div>
			</div>
			<!-- Sidebar Content -->
			<div class="sidebar-content">
				<!-- Menu Section -->
				<div id="menu-section" class="content-section active">
					<h3>Menu</h3>
					<ul>
						<li class="menu-item" data-id="1"><a class="nav nav-link text-dark" href="{{ route('index') }}">Home</a></li>
						<li class="menu-item" data-id="2"><a class="nav nav-link text-dark" href="{{ route('products') }}">Products</a></li>
						<li class="menu-item" data-id="4"><a class="nav nav-link text-dark" href="{{ route('affiliate.register') }}">Affiliate</a></li>
						<li class="menu-item" data-id="5"><a class="nav nav-link text-dark" href="{{ route('contacts') }}">Contact</a></li>
						<!-- Add other menu items here -->
					</ul>
				</div>

				<!-- Categories Section -->
				<div id="categories-section" class="content-section">
					<h3>Categories</h3>
					<ul>
						@foreach($categories as $item)
						<li class="menu-item" data-id="1"><a class="nav nav-link text-dark" href="{{ route('products') }}?category={{ $item->id }}">{{$item->name}}</a></li>
						@endforeach
						<!-- Add more categories here -->
					</ul>
				</div>
			</div>
		</div>


		<!-- Middle Logo -->
		<div class="logo">
			<img src="{{ Storage::url($setting->mobile_logo) }}" alt="{{$setting->company_name}}" />
		</div>

		<!-- Right Icons (Search and Cart) -->
		<div class="right-icons">
			<div class="search-icon">
				<i class="fa fa-search"></i>
			</div>
			<div class="cart-icon-mobile">
				<a href="/checkout" class="text-dark">
					<i class="fa fa-shopping-cart"></i>
					<span class="cart-badge-mobile" id="cartCountMobile">0</span>	
				</a>
			</div>
		</div>
	</div>
	<!-- Full-Width Search Box -->
	<div class="full-width-search">
		<div class="search-box">
			<input type="text" id="mobileSearchInput" placeholder="I’m searching for..." />
			<button class="search-button">
				<i class="fa fa-search"></i>
			</button>
		</div>

		<!-- Live Search Results -->
		<div id="mobileSearchResults" class="search-results d-none">
			<!-- Results will appear here -->
		</div>
	</div>




</div>