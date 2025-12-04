@php
$setting = \App\Models\Setting::first();
$categories = \App\Models\Category::all();
$facebook = \App\Models\Facebook::first();
$google = \App\Models\Google::first();
$offer = \App\Models\Offer::first();
$tagmanager = \App\Models\TagManager::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png"
        href="{{ $setting->favicon ? Storage::url($setting->favicon) : asset('/assets/img/null.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/')}}assets/css/style.css">



    {{-- ✅ Google Tag Manager (Head) --}}
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{$google->google_id}}'); // <-- Replace with your Google Analytics ID
    </script>

    {{-- ✅ Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$google->google_id}}"></script>

    {{-- ✅ Facebook Pixel --}}
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{$facebook->facebook_id}}'); // <-- Replace with your Facebook Pixel ID
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
            src="https://www.facebook.com/tr?id={{$facebook->facebook_id}}&ev=PageView&noscript=1" />
    </noscript>

    {{-- ✅ Google Tag Manager (for Data Layer events) --}}
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{$tagmanager->tag_id}}'); // <-- Replace with your GTM ID
    </script>


    @yield('css')

</head>

<body>


    {{-- ✅ Google Tag Manager (Body) --}}
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{$tagmanager->tag_id}}" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')



    <!-- Floating Cart Button & Scroll Arrow -->
    <div class="floating-buttons">
        <div class="cart-btn position-relative" id="cartBtn">
            <a href="/checkout" class="text-dark">
                <i class="fa fa-shopping-cart"></i>
                <span class="cart-badge" id="rightArrowCount">0</span>
            </a>
        </div>
        <div class="top-btn" id="goTopBtn">
            <i class="fa fa-arrow-up"></i>
        </div>
    </div>



    <!-- Offer Modal -->
    <div class="modal fade" id="offerModal" tabindex="-1" role="dialog" aria-labelledby="offerModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-lg shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-primary" id="offerModalLabel">{{ $offer->offer_title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ Storage::url($offer->offer_image) }}" class="img-fluid mb-3"
                        alt="{{ $offer->offer_title }}">
                    <h4>{{ $offer->offer_description_1 }}</h4>
                    <p class="text-muted">{{ $offer->offer_description_2 }}</p>
                    <a href="{{ $offer->offer_button_link }}" class="btn btn-primary btn-lg mt-3">{{
                        $offer->offer_button_text }}</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Live chat launcher -->
    <div class="live-chat-launcher">
        <div class="chat-label">Need help? Chat with us</div>

        <div class="chat-bubble" id="chat-toggle" aria-label="Open live chat" role="button" tabindex="0">
            <!-- Using Font Awesome arrow-up as requested -->
            <i class="fa fa-arrow-up" style="transform: rotate(45deg); font-size:22px;"></i>
            <span class="badge" id="unread-badge">2</span>
        </div>
    </div>

    <!-- Chat window -->
    <div class="live-chat-window fade-in" id="liveChatWindow" role="dialog" aria-hidden="true"
        aria-labelledby="chatTitle">
        <div class="live-chat-header">
            <img src="https://i.pravatar.cc/100?img=12" alt="Agent">
            <div>
                <div id="chatTitle" class="meta">Support Team</div>
                <div class="sub">Usually replies within a few minutes</div>
            </div>

            <!-- optional minimized/close -->
            <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                <button class="small-action" id="open-whatsapp" title="Open WhatsApp (optional)">
                    <i class="fab fa-whatsapp"></i>
                </button>
                <button class="small-action" id="close-chat" aria-label="Close chat">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>

        <div class="live-chat-messages" id="messages" aria-live="polite">
            <!-- sample messages -->
            <div class="msg agent">
                <div class="bubble">হ্যালো! কিভাবে সাহায্য করতে পারি?</div>
            </div>
            <div class="msg user">
                <div class="bubble">আমি পণ্যের বিষয়ে জানতে চাই।</div>
            </div>
            <div class="msg agent">
                <div class="bubble">অবশ্যই — কোন পণ্যটি দেখতে চান?</div>
            </div>
        </div>

        <div class="live-chat-input">
            <input id="chatInput" type="text" placeholder="আপনার বার্তা লিখুন..." aria-label="Type your message">
            <button class="btn-send" id="sendBtn" title="Send message">
                <!-- arrow-up used here too for send -->
                <i class="fa fa-arrow-up" style="transform: rotate(-45deg);"></i>
            </button>
        </div>
    </div>


    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script>
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
    </script> --}}


    <script>
        // Elements
  const chatToggle = document.getElementById('chat-toggle');
  const chatWindow = document.getElementById('liveChatWindow');
  const closeBtn = document.getElementById('close-chat');
  const sendBtn = document.getElementById('sendBtn');
  const input = document.getElementById('chatInput');
  const messagesEl = document.getElementById('messages');
  const unreadBadge = document.getElementById('unread-badge');
  const openWhatsappBtn = document.getElementById('open-whatsapp');

  // Sample WhatsApp number - change to your number in international format without +
  const WHATSAPP_NUMBER = 'YOUR_WHATSAPP_NUMBER'; // e.g. 8801729345196

  // Toggle open/close
  function openChat() {
    chatWindow.style.display = 'flex';
    chatWindow.setAttribute('aria-hidden','false');
    unreadBadge.style.display = 'none';
    scrollToBottom();
  }
  function closeChat() {
    chatWindow.style.display = 'none';
    chatWindow.setAttribute('aria-hidden','true');
  }

  chatToggle.addEventListener('click', openChat);
  chatToggle.addEventListener('keypress', (e) => { if (e.key === 'Enter' || e.key === ' ') openChat(); });
  closeBtn.addEventListener('click', closeChat);

  // Send message (local demo)
  function appendMessage(text, who='user') {
    const wrapper = document.createElement('div');
    wrapper.className = 'msg ' + (who === 'agent' ? 'agent' : 'user');
    const bubble = document.createElement('div');
    bubble.className = 'bubble';
    bubble.innerText = text;
    wrapper.appendChild(bubble);
    messagesEl.appendChild(wrapper);
    scrollToBottom();
  }

  sendBtn.addEventListener('click', () => {
    const txt = input.value.trim();
    if (!txt) return;
    appendMessage(txt, 'user');
    input.value = '';
    // Simulate agent reply after 700ms
    setTimeout(() => {
      appendMessage('ধন্যবাদ— আমরা শীঘ্রই উত্তর দিচ্ছি।', 'agent');
    }, 700);
  });

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      sendBtn.click();
    }
  });

  function scrollToBottom(){
    messagesEl.scrollTop = messagesEl.scrollHeight + 200;
  }

  // Option: open WhatsApp chat in new tab (or behind the scenes)
  openWhatsappBtn.addEventListener('click', () => {
    if (!WHATSAPP_NUMBER || WHATSAPP_NUMBER === 'YOUR_WHATSAPP_NUMBER') {
      // fallback: open whatsapp web homepage
      window.open('https://web.whatsapp.com/', '_blank');
      return;
    }
    const url = `https://wa.me/${WHATSAPP_NUMBER}`;
    window.open(url, '_blank');
  });

  // Small: clicking outside chat window closes it (nice behavior)
  document.addEventListener('click', (e) => {
    const isLauncher = chatToggle.contains(e.target);
    const isWindow = chatWindow.contains(e.target);
    if (!isLauncher && !isWindow) {
      // don't auto-close if chat window is visible? keep it simple: close
      // comment next line if you prefer it to stay open
      // closeChat();
    }
  });

  // Accessibility: close with ESC
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeChat(); });

  // initial unread indicator behaviour (demo)
  setTimeout(() => {
    // you can set unread count dynamically via unreadBadge.innerText = '3'
    unreadBadge.style.display = 'flex';
  }, 900);
    </script>

    <script>
        document.getElementById("goTopBtn").addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>
    @if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif
     @if(session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif

    <script>
        $(document).ready(function() {
            let $searchInput = $('#searchInput');
            let $searchResults = $('#searchResults');
            let typingTimer;
            let doneTypingInterval = 300; // typing delay (ms)

            // 🟢 Typing detection
            $searchInput.on('keyup', function() {
                clearTimeout(typingTimer);
                let query = $(this).val().trim();

                if (query.length > 1) {
                    typingTimer = setTimeout(function() {
                        performSearch(query);
                    }, doneTypingInterval);
                } else {
                    $searchResults.addClass('d-none').empty();
                }
            });

            // 🟢 AJAX Search
            function performSearch(query) {
                $.ajax({
                    url: "{{ route('product.liveSearch') }}", // Adjust this route based on your application
                    method: "GET",
                    data: {
                        q: query
                    },
                    success: function(res) {
                        renderResults(res);
                    },
                    error: function() {
                        $searchResults.addClass('d-none').empty();
                    }
                });
            }

            // 🟢 Render search results
            // 🟢 Render search results
            function renderResults(products) {
                $searchResults.empty();

                if (products.length === 0) {
                    $searchResults.removeClass('d-none').html('<p class="p-2 mb-0 text-muted">No products found.</p>');
                    return;
                }

                products.forEach(function(product) {
                    let salePrice = parseFloat(product.sale_price).toFixed(2);
                    let regularPrice = parseFloat(product.regular_price).toFixed(2);
                    let url = "{{ url('product') }}/" + product.slug;

                    let html = `
            <a href="${url}" class="d-flex justify-content-between align-items-center p-2 border-bottom text-decoration-none text-dark hover-bg-light">
                <div>
                    <div class="fw-semibold">${product.name}</div>
                    <div class="small">
                        <del class="text-muted text-decoration-line-through me-2">{{currency()}}${regularPrice}</del>
                        <span class="fw-bold text-primary">{{currency()}}${salePrice}</span>
                    </div>
                </div>
            </a>
        `;
                    $searchResults.append(html);
                });

                // Make the results visible
                $searchResults.removeClass('d-none').addClass('show');
            }


            // 🟢 Hide results if clicked outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-container').length) {
                    $searchResults.addClass('d-none');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            let $searchInput = $('#liveSearchInput'); // Updated ID for live search input
            let $searchResults = $('#liveSearchResults'); // Updated ID for live search results
            let typingTimer;
            let doneTypingInterval = 300; // Typing delay (ms)

            // 🟢 Typing detection
            $searchInput.on('keyup', function() {
                clearTimeout(typingTimer);
                let query = $(this).val().trim();

                if (query.length > 1) {
                    typingTimer = setTimeout(function() {
                        performSearch(query);
                    }, doneTypingInterval);
                } else {
                    $searchResults.addClass('d-none').empty();
                }
            });

            // 🟢 AJAX Search
            function performSearch(query) {
                $.ajax({
                    url: "{{ route('product.liveSearch') }}", // Adjust this route based on your application
                    method: "GET",
                    data: {
                        q: query
                    },
                    success: function(res) {
                        renderResults(res);
                    },
                    error: function() {
                        $searchResults.addClass('d-none').empty();
                    }
                });
            }

            // 🟢 Render search results
            function renderResults(products) {
                $searchResults.empty();

                if (products.length === 0) {
                    $searchResults.removeClass('d-none').html('<p class="p-2 mb-0 text-muted">No products found.</p>');
                    return;
                }

                products.forEach(function(product) {
                    let salePrice = parseFloat(product.sale_price).toFixed(2);
                    let regularPrice = parseFloat(product.regular_price).toFixed(2);
                    let url = "{{ url('product') }}/" + product.slug;

                    let html = `
                    <a href="${url}" class="d-flex justify-content-between align-items-center p-2 border-bottom text-decoration-none text-dark hover-bg-light">
                        <div>
                            <div class="fw-semibold">${product.name}</div>
                            <div class="small">
                                <span class="text-muted text-decoration-line-through me-2">$${regularPrice}</span>
                                <span class="fw-bold text-primary">$${salePrice}</span>
                            </div>
                        </div>
                    </a>
                `;
                    $searchResults.append(html);
                });

                // Make the results visible
                $searchResults.removeClass('d-none');
            }

            // 🟢 Hide results if clicked outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-box').length) {
                    $searchResults.addClass('d-none');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let $searchInput = $('#mobileSearchInput'); // Input field for live search
            let $searchResults = $('#mobileSearchResults'); // Container for search results
            let typingTimer;
            let doneTypingInterval = 300; // Typing delay (ms)

            // 🟢 Typing detection
            $searchInput.on('keyup', function() {
                clearTimeout(typingTimer);
                let query = $(this).val().trim();

                if (query.length > 1) {
                    typingTimer = setTimeout(function() {
                        performSearch(query);
                    }, doneTypingInterval);
                } else {
                    $searchResults.addClass('d-none').empty(); // Hide results if input is empty
                }
            });

            // 🟢 AJAX Search
            function performSearch(query) {
                $.ajax({
                    url: "{{ route('product.liveSearch') }}", // Adjust this route based on your application
                    method: "GET",
                    data: {
                        q: query
                    },
                    success: function(res) {
                        renderResults(res); // Render results on success
                    },
                    error: function() {
                        $searchResults.addClass('d-none').empty(); // Hide results if there is an error
                    }
                });
            }

            // 🟢 Render search results
            function renderResults(products) {
                $searchResults.empty(); // Clear previous results

                if (products.length === 0) {
                    $searchResults.removeClass('d-none').html('<p class="p-2 mb-0 text-muted">No products found.</p>');
                    return;
                }

                products.forEach(function(product) {
                    let salePrice = parseFloat(product.sale_price).toFixed(2);
                    let regularPrice = parseFloat(product.regular_price).toFixed(2);
                    let url = "{{ url('product') }}/" + product.slug;

                    let html = `
                    <a href="${url}" class="d-flex justify-content-between align-items-center p-2 border-bottom text-decoration-none text-dark hover-bg-light">
                        <div>
                            <div class="fw-semibold">${product.name}</div>
                            <div class="small">
                                <span class="text-muted text-decoration-line-through me-2">$${regularPrice}</span>
                                <span class="fw-bold text-primary">$${salePrice}</span>
                            </div>
                        </div>
                    </a>
                `;
                    $searchResults.append(html); // Append each result to the list
                });

                // Make the results visible (display block)
                $searchResults.removeClass('d-none').css('display', 'block'); // Show the results by setting display to block
            }

            // 🟢 Hide results if clicked outside the search box
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-box').length) { // Close search results if clicked outside
                    $searchResults.addClass('d-none'); // Hide search results
                }
            });
        });
    </script>





    <script>
        // IMAGE CHANGE
        $(".thumb-item img").on("click", function() {

            let largeImg = $(this).data("large");
            $("#mainImage").attr("src", largeImg);

            $(".thumb-item").removeClass("active");
            $(this).closest(".thumb-item").addClass("active");
        });

        // QUANTITY FUNCTION
        $('.btn-plus').click(function() {
            let q = parseInt($("#qty").val());
            $("#qty").val(q + 1);
        });

        $('.btn-minus').click(function() {
            let q = parseInt($("#qty").val());
            if (q > 1) $("#qty").val(q - 1);
        });
    </script>

    <!-- jQuery -->
    <script>
        // JavaScript to handle cart details toggle
        document.getElementById('cart-toggle').addEventListener('click', function() {
            var cartDetails = document.getElementById('cart-details');
            cartDetails.classList.toggle('show');
        });

        // Get the search icon and full-width search box
        const searchIcon = document.querySelector('.search-icon');
        const fullWidthSearch = document.querySelector('.full-width-search');

        // Toggle the visibility of the full-width search box
        searchIcon.addEventListener('click', () => {
            fullWidthSearch.style.display = (fullWidthSearch.style.display === 'none' || fullWidthSearch.style.display === '') ? 'block' : 'none';
        });
    </script>


    <script>
        // Get the sidebar elements
        const menuBtn = document.querySelector('.menu-btn');
        const categoriesBtn = document.querySelector('.categories-btn');
        const sidebar = document.querySelector('.sidebar');
        const menuSection = document.querySelector('#menu-section');
        const categoriesSection = document.querySelector('#categories-section');
        const hamburgerMenu = document.querySelector('.hamburger-menu');

        // Add event listener to the hamburger menu to toggle sidebar visibility
        hamburgerMenu.addEventListener('click', () => {
            sidebar.classList.toggle('show'); // Toggle sidebar visibility
        });

        // ---- DEFAULT ACTIVE ----
        menuBtn.classList.add('active');
        menuSection.classList.add('active');

        // ---- WHEN MENU CLICKED ----
        menuBtn.addEventListener('click', () => {
            menuBtn.classList.add('active');
            categoriesBtn.classList.remove('active');

            menuSection.classList.add('active');
            categoriesSection.classList.remove('active');
        });

        // ---- WHEN CATEGORIES CLICKED ----
        categoriesBtn.addEventListener('click', () => {
            categoriesBtn.classList.add('active');
            menuBtn.classList.remove('active');

            categoriesSection.classList.add('active');
            menuSection.classList.remove('active');
        });

        // ---- CLOSE SIDEBAR WHEN CLICKING OUTSIDE ----
        document.addEventListener('click', (event) => {
            // Check if the click is outside the sidebar and the hamburger menu
            if (!sidebar.contains(event.target) && !hamburgerMenu.contains(event.target)) {
                sidebar.classList.remove('show'); // Close the sidebar
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Detect scroll event and apply rotation
            $(window).scroll(function() {
                // Get the current scroll position
                var scrollTop = $(window).scrollTop();

                // Calculate the rotation based on scroll position
                var rotation = scrollTop / 5; // Adjust this value to control the rotation speed

                // Apply the rotation to the logo
                $('#f_logo').css('transform', 'rotate(' + rotation + 'deg)');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // When a tab is clicked
            $('.custom-tab-link').on('click', function(event) {
                event.preventDefault(); // Prevent default anchor behavior

                // Remove 'active' class from all tabs and sections
                $('.custom-tab-item').removeClass('active');
                $('.product-section').removeClass('active');

                // Add 'active' class to the clicked tab and target section
                $(this).closest('.custom-tab-item').addClass('active');
                var target = $(this).attr('href');
                $(target).addClass('active');
            });
        });
    </script>

    <script>
        // Store the currency symbol in a JavaScript variable
        var currencySymbol = "{{ currency() }}"; // Laravel Blade to JavaScript
    </script>


    {{-- <script>
        $(document).ready(function() {
            // Add to Cart Button Click Event for both 'order-now' and 'order-now-new'
            $(document).on('click', '.order-now, .order-now-new', function(e) {
                e.preventDefault();

                // Get product details from the button data attributes
                var productId = $(this).data("id");
                var name = $(this).data("name");
                var image = $(this).data("image");
                var price = parseFloat($(this).data("price"));
                var slug = $(this).data("slug");
                var quantity = parseInt($('#qty').val()) || 1; // Get quantity from input (default to 1 if empty)
                var affiliateId = $(this).data('affiliate-id'); // Affiliate ID from the button

                // Get the current cart from localStorage or initialize it
                var cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Check if the product is already in the cart
                var existingProduct = cart.find(item => item.productId == productId);

                if (existingProduct) {
                    // If the product already exists, increase the quantity
                    existingProduct.quantity += quantity;
                    toastr.success(name + " quantity increased!");
                } else {
                    // If the product doesn't exist, add it to the cart
                    cart.push({
                        productId: productId,
                        name: name,
                        image: image,
                        price: price,
                        quantity: quantity,
                        slug: slug,
                        affiliateId: affiliateId // Add affiliate ID to the cart item
                    });
                    toastr.success(name + " added to cart!");
                }

                // Save the updated cart to localStorage
                localStorage.setItem('cart', JSON.stringify(cart));

                // Update cart display
                updateCart();
            });

            // Function to update cart display
            function updateCart() {
                var cart = JSON.parse(localStorage.getItem('cart')) || [];
                var cartCount = cart.reduce((sum, item) => sum + item.quantity, 0); // Count total items
                var cartTotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0); // Calculate total price

                // Update cart count and total in the UI
                $('#cartCount').text(cartCount);
                $('#cartCountMobile').text(cartCount);
                $('#rightArrowCount').text(cartCount);
                $('#cartTotal').text(currencySymbol + cartTotal.toFixed(2));

                // Render cart items
                var cartItemsHtml = '';
                cart.forEach(function(item) {
                    cartItemsHtml += `
                    <div class="cart-item">
                        <div class="cart-item-info d-flex">
                            <img src="${item.image}" alt="Product" class="cart-item-image">
                            <p class="cart-item-name">${item.name}</p>
                            <a href="#" class="remove-item" data-id="${item.productId}">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="cart-item-quantity ml-5 pl-3">
                                <button class="quantity-btn decrement" data-id="${item.productId}">-</button>
                                <input readonly value="${item.quantity}" class="quantity-input">
                                <button class="quantity-btn increment" data-id="${item.productId}">+</button>
                            </div>
                            <p class="cart-item-price">৳ ${item.price * item.quantity}</p>
                        </div>
                    </div>
                `;
                });

                $('#cart-items').html(cartItemsHtml);

                // Show cart details if items exist
                if (cartCount > 0) {
                    $('#cart-details').removeClass('d-none');
                } else {
                    $('#cart-details').addClass('d-none');
                }
            }

            // Increment Quantity
            $(document).on("click", ".increment", function() {
                var productId = $(this).data("id");
                var cart = JSON.parse(localStorage.getItem('cart')) || [];
                var product = cart.find(item => item.productId == productId);
                if (product) {
                    product.quantity++;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCart();
                }
            });

            // Decrement Quantity
            $(document).on("click", ".decrement", function() {
                var productId = $(this).data("id");
                var cart = JSON.parse(localStorage.getItem('cart')) || [];
                var product = cart.find(item => item.productId == productId);
                if (product) {
                    if (product.quantity > 1) {
                        product.quantity--;
                    } else {
                        cart = cart.filter(item => item.productId != productId);
                        toastr.success("Item removed from cart");
                    }
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCart();
                }
            });

            // Remove Item from Cart
            $(document).on("click", ".remove-item", function() {
                var productId = $(this).data("id");
                var cart = JSON.parse(localStorage.getItem('cart')) || [];
                cart = cart.filter(item => item.productId != productId);
                localStorage.setItem('cart', JSON.stringify(cart));
                toastr.success("Item removed from cart");
                updateCart();
            });

            // Initial load - Render cart
            updateCart();
        });
    </script> --}}

    <script>
$(document).ready(function() {

    // ====== Update Variant Info ======
    function updateVariant() {
        var colorOpt = $('#variant-color option:selected');
        var sizeOpt = $('#variant-size option:selected');

        var basePrice = parseFloat($('#variant-price').data('base-price')) || 0;
        var price = parseFloat(sizeOpt.data('price') || colorOpt.data('price') || basePrice);
        var stock = parseInt(sizeOpt.data('stock') || colorOpt.data('stock') || parseInt($('#variant-stock').text()) || 100);
        var colorName = colorOpt.data('color') || '';
        var sizeName = sizeOpt.data('size') || '';

        $('#variant-price').text(price.toFixed(2));
        $('#variant-stock').text(stock);
        $('#qty').val(Math.min(parseInt($('#qty').val()) || 1, stock));
    }

    // ====== Variant change event ======
    $('#variant-color, #variant-size').on('change', updateVariant);

    // ====== Quantity buttons ======
    $('#increment').click(function() {
        var stock = parseInt($('#variant-stock').text()) || 100;
        var val = parseInt($('#qty').val()) || 1;
        if(val < stock) $('#qty').val(val + 1);
    });
    $('#decrement').click(function() {
        var val = parseInt($('#qty').val()) || 1;
        if(val > 1) $('#qty').val(val - 1);
    });
    $('#qty').on('input', function() {
        var stock = parseInt($('#variant-stock').text()) || 100;
        var val = parseInt($(this).val()) || 1;
        if(val < 1) $(this).val(1);
        if(val > stock) $(this).val(stock);
    });

    // ====== Add to Cart Click Event ======
    $(document).on('click', '.order-now, .order-now-new', function(e) {
        e.preventDefault();

        var button = $(this);
        var productId = button.data('id');
        var name = button.data('name');
        var slug = button.data('slug');
        var image = button.data('image');
        var affiliateId = button.data('affiliate-id') || null;

        // Variant info
        var colorOpt = $('#variant-color option:selected');
        var sizeOpt = $('#variant-size option:selected');

        var price = parseFloat(sizeOpt.data('price') || colorOpt.data('price') || button.data('price')) || 0;
        var stock = parseInt(sizeOpt.data('stock') || colorOpt.data('stock') || 100);
        var color = colorOpt.length ? colorOpt.text() : '';
        var size = sizeOpt.length ? sizeOpt.text() : '';

        var quantity = parseInt($('#qty').val()) || 1;
        if(quantity > stock) {
            toastr.error("Quantity exceeds stock!");
            return;
        }

        // Get cart from localStorage
        var cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if product with same variant already exists
        var existing = cart.find(item => item.productId == productId && item.color == color && item.size == size);

        if(existing) {
            existing.quantity += quantity;
            if(existing.quantity > stock) existing.quantity = stock;
            toastr.success(name + " quantity updated!");
        } else {
            cart.push({
                productId: productId,
                name: name,
                slug: slug,
                image: image,
                price: price,
                quantity: quantity,
                color: color,
                size: size,
                affiliateId: affiliateId
            });
            toastr.success(name + " added to cart!");
        }

        // Save cart
        localStorage.setItem('cart', JSON.stringify(cart));

        // Update cart UI
        updateCartUI();
    });

    // ====== Update Cart UI ======
    function updateCartUI() {
        var cart = JSON.parse(localStorage.getItem('cart')) || [];
        var cartCount = cart.reduce((sum, item) => sum + item.quantity, 0);
        var cartTotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        $('#cartCount').text(cartCount);
        $('#cartCountMobile').text(cartCount);
        $('#rightArrowCount').text(cartCount);
        $('#cartTotal').text(cartTotal.toFixed(2));

        var html = '';
        cart.forEach(function(item) {
            html += `
            <div class="cart-item d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                    <img src="${item.image}" class="cart-item-img me-2" style="width:50px;height:50px;">
                    <div>
                        <p class="mb-0">${item.name} ${item.color ? '('+item.color+')' : ''} ${item.size ? '('+item.size+')' : ''}</p>
                        <small>Price: ${item.price.toFixed(2)} x ${item.quantity}</small>
                    </div>
                </div>
                <div>
                    <button class="btn btn-sm btn-secondary increment" data-id="${item.productId}">+</button>
                    <button class="btn btn-sm btn-secondary decrement" data-id="${item.productId}">-</button>
                    <button class="btn btn-sm btn-danger remove-item" data-id="${item.productId}">x</button>
                </div>
            </div>`;
        });
        $('#cart-items').html(html);

        if(cartCount > 0) $('#cart-details').removeClass('d-none');
        else $('#cart-details').addClass('d-none');
    }

    // ====== Increment / Decrement / Remove Item ======
    $(document).on('click', '.increment', function() {
        var productId = $(this).data('id');
        var cart = JSON.parse(localStorage.getItem('cart')) || [];
        var item = cart.find(x => x.productId == productId);
        if(item) {
            item.quantity++;
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
        }
    });

    $(document).on('click', '.decrement', function() {
        var productId = $(this).data('id');
        var cart = JSON.parse(localStorage.getItem('cart')) || [];
        var item = cart.find(x => x.productId == productId);
        if(item) {
            if(item.quantity > 1) item.quantity--;
            else cart = cart.filter(x => x.productId != productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
        }
    });

    $(document).on('click', '.remove-item', function() {
        var productId = $(this).data('id');
        var cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(x => x.productId != productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        toastr.success("Item removed from cart");
        updateCartUI();
    });

    // Initial render
    updateCartUI();
});
</script>


    @yield('script')


</body>

</html>