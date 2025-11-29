@php
$setting = \App\Models\Setting::first();
$categories = \App\Models\Category::all();
$facebook = \App\Models\Facebook::first();
$google = \App\Models\Google::first();
$tagmanager = \App\Models\TagManager::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ $setting->favicon ? Storage::url($setting->favicon) : asset('/assets/img/null.png') }}">
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
        <iframe src="https://www.googletagmanager.com/ns.html?id={{$tagmanager->tag_id}}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
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


    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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


    <script>
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
                        slug: slug
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
    </script>





    @yield('script')


</body>

</html>