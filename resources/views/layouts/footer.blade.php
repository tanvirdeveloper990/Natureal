<div class="header container-fluid" style="
 background: url('{{ asset('assets/img/footer-bg.png') }}') no-repeat center center;
  background-size: cover;
  height: 280px;
  width: 100%;"></div>
<footer>

  <div class="container text-center">
    <!-- Company Information -->
    <div class="company-info">
      <div class="element">
        <img src="{{asset('/') }}assets/img/boder-element.png" alt="">
      </div>
      <p><strong>{{$setting->company_name}}</strong></p>
      <img src="{{asset('/') }}assets/img/location.png" alt="">
      <p><strong>UK Office</strong></p>
      <p>{{$setting->address}}</p>
      <img src="{{asset('/') }}assets/img/call.png" alt="">
      <p><strong>Care Line:</strong> {{$setting->phone_one}}</p>
    </div>

    <!-- Social Media Icons -->
    <div class="social-icons">
      <a href="{{$setting->facebook}}" class="fab fa-facebook-square"></a>
      <a href="{{$setting->twitter}}" class="fab fa-twitter-square"></a>
      <a href="{{$setting->linkedin}}" class="fab fa-linkedin"></a>
      <a href="{{$setting->youtube}}" class="fab fa-youtube"></a>
    </div>
    <div class="element">
      <img src="{{asset('/') }}assets/img/boder-element.png" alt="">
    </div>
    <div class="footer-brand">
      <img src="{{ Storage::url($setting->footer_logo) }}" alt="">
    </div>


    <!-- SSL Verified -->
    <div class="verified-logo mt-4">
      <img src="{{asset('/') }}assets/img/payment-methods.png" alt="">
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="logo">{{$setting->copyright}}</div>
    </div>
  </div>
  <!-- <div class="text-center text-dark py-3 extra-links">
    <p><a href="#">About Us |</a>
      <a href="#">Contact Us |</a>
      <a href="#">FAQs |</a>
      <a href="#">Shop |</a>
      <a href="#">Privacy Policy |</a>
      <a href="#">Return Policy |</a>
      <a href="#">T&C</a>
    </p>
  </div> -->
</footer>



<!-- Footer Boottom -->
<div class="d-lg-none d-block">
  <div class="footer-device-mobile visible-xxs clearfix">
    <!-- Left Side: Home and Pearl Button -->
    <div class="mobile_menu_btn">
      <a href="/">
        <img src="{{asset('/') }}assets/img/home-new.png"
          style="width: 25px;">
      </a>
      <span class="icon_text">Home</span>
    </div>

    <div class="mobile_menu_btn">
      <a class="mobil-view-cart" href="{{ route('products') }}">
        <img src="{{asset('/') }}assets/img/home-page-pearl-icon.svg"
          style="width: 25px;">
      </a>
      <span class="icon_text">Products</span>
    </div>

    <!-- Empty space to center the logo -->
    <div class="mobile_menu_btn"></div>

    <!-- Logo (Middle) -->
    <div class="logo-container">
      <a href="/">
        <img id="f_logo" style="width: 100%; transform: rotate(0.683629rad);"
          src="{{asset('/') }}assets/img/round_home.png">
      </a>
    </div>

    <!-- Right Side: Messenger and Call Now Button -->
    <div class="mobile_menu_btn">
      <a href="{{$setting->facebook}}" target="_blank">
        <img src="{{asset('/') }}assets/img/messenger.png"
          style="width: 25px;">
      </a>
      <span class="icon_text">Messenger</span>
    </div>

    <div class="mobile_menu_btn">
      <a href="tel:{{$setting->phone_one}}" style="color: #00a651;">
        <img src="{{asset('/') }}assets/img/call-new.png"
          style="width: 25px;">
      </a>
      <span class="icon_text">Call Now</span>
    </div>
  </div>
</div>
<!-- Footer Bottom -->