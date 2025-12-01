@extends('layouts.app')
@section('title','Checkout')

@section('css')

<style>
    /* Custom Styles to Match Tailwind Design */
    .checkout-section {
        padding: 2.5rem 0;
    }

    .card-custom {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    .subsection-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .form-control,
    .form-select {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        transition: all 0.3s ease;
    }

    .payment-option {
        cursor: pointer;
    }

    .payment-option input[type="radio"] {
        margin-right: 0.5rem;
    }

    .payment-option img {
        height: 2rem;
    }

    .btn-add-coupon {
        background-color: #06b6d4;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
    }

    .btn-add-coupon:hover {
        background-color: #0891b2;
    }

    .btn-confirm-order {
        background-color: #16a34a;
        color: white;
        font-weight: 700;
        padding: 1rem;
        border: none;
        border-radius: 0.375rem;
        font-size: 1.125rem;
        transition: background-color 0.3s ease;
    }

    .btn-confirm-order:hover {
        background-color: #15803d;
        color: #FFF;
    }

    .terms-checkbox {
        width: 1rem;
        height: 1rem;
        margin-top: 0.25rem;
        margin-right: 0.75rem;
    }

    .terms-text {
        font-size: 0.875rem;
        color: #4b5563;
    }

    .terms-text a {
        color: #2563eb;
        text-decoration: none;
    }

    .terms-text a:hover {
        text-decoration: underline;
    }

    /* Cart Overview Styles */
    .cart-overview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .cart-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
    }

    .modify-link {
        color: #2563eb;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .modify-link:hover {
        text-decoration: underline;
    }

    .product-item {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .product-image-wrapper {
        position: relative;
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        background-color: #f3f4f6;
        border-radius: 0.375rem;
        /* overflow: hidden; */
    }

    .remove-btn {
        position: absolute;
        top: -0.5rem;
        left: -0.5rem;
        z-index: 10;
        width: 1.25rem;
        height: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        background-color: #ef4444;
        border: none;
        border-radius: 50%;
        transition: background-color 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .remove-btn:hover {
        background-color: #dc2626;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background-color: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
    }

    .info-badge i {
        color: #4b5563;
    }

    .info-badge span {
        font-weight: 500;
        color: #374151;
    }

    .info-badge .value {
        font-weight: 600;
        color: #111827;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .qty-btn {
        width: 1.75rem;
        height: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 0.25rem;
        transition: background-color 0.3s ease;
    }

    .qty-btn:hover {
        background-color: #f3f4f6;
    }

    .qty-btn i {
        font-size: 0.75rem;
        color: #4b5563;
    }

    .qty-display {
        width: 2.5rem;
        text-align: center;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .price-original {
        font-size: 0.875rem;
        text-decoration: line-through;
        color: #9ca3af;
    }

    .price-current {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    .cart-summary {
        margin-bottom: 1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
    }

    .summary-label {
        color: #4b5563;
    }

    .summary-value {
        font-weight: 600;
        color: #111827;
    }

    .summary-value.shipping {
        color: #16a34a;
    }

    .summary-total {
        border-top: 1px solid #e5e7eb;
        padding-top: 0.75rem;
        display: flex;
        justify-content: space-between;
    }

    .summary-total .label {
        font-weight: 600;
        color: #1f2937;
    }

    .summary-total .value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #16a34a;
    }

    .sticky-cart {
        position: sticky;
        top: 90px;
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .sticky-cart {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 767px) {
        .checkout-section {
            padding: 1.5rem 0;
        }

        .card-custom {
            padding: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
        }
    }
</style>


@endsection



@section('content')

<section class="checkout-section py-5" style="background: #ebdede;">
    <div class="container">
        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-8">
                <div class="card-custom p-4">
                    <h2 class="bg-warning p-2 section-title text-left">Checkout Info</h2>

                    <!-- CONTACT INFO -->
                    <div class="mb-4 text-left">
                        <h3 class="subsection-title">Billing & Shipping</h3>
                        <input type="text" class="form-control mb-3 p-4" id="name" placeholder="Full Name" required>
                        <input type="tel" class="form-control mb-3 p-4" id="phone" placeholder="Phone Number" required>
                        <input type="text" class="form-control mb-3 p-4" id="address"
                            placeholder="District, Upazila, Thana, Municipality" required>
                    </div>

                    <!-- SHIPPING -->
                    <div class="mb-4 text-left">
                        <h3 class="subsection-title">Shipping Info</h3>
                        <select class="form-select form-control" id="delivery_area">
                            <option value="" disabled selected>Select Shipping Area</option>
                            <option value="Inside Dhaka" data-value="100">Inside Dhaka - ৳100</option>
                            <option value="Outside Dhaka" data-value="130">Outside Dhaka - ৳130</option>
                        </select>
                    </div>

                    <!-- PAYMENT -->
                    <div class="mb-4 text-left">
                        <h3 class="subsection-title">Payment Options</h3>

                        <div class="d-flex flex-wrap gap-3">
                            <label class="payment-option d-flex align-items-center">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <img
                                    src="https://d28wu8o6itv89t.cloudfront.net/images/Cashondeliveryjpgjpg-1594648666434.jpeg">
                            </label>

                            @if(!empty($ssl->sslcz_store_id))
                            <label class="payment-option d-flex align-items-center ml-3">
                                <input type="radio" name="payment_method" value="sslcommerz">
                                <img src="https://sslcommerz.com/wp-content/uploads/2021/11/logo.png">
                            </label>
                            @endif
                        </div>
                    </div>

                    <!-- TERMS -->
                    <label class="d-flex align-items-start mb-4">
                        <input type="checkbox" class="terms-checkbox" checked>
                        <span class="ms-2">I agree to Terms & Conditions.</span>
                    </label>

                    <button id="place-order" class="btn btn-confirm-order w-100">Confirm Order <span
                            id="grand-total1"></span></button>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <div class="card-custom p-3">

                    <div class="cart-summary mt-3">
                        <div class="d-flex justify-content-between border-bottom pb-2">
                            <span>Total:</span>
                            <span id="cart-total">৳ 0</span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom pb-2 mt-2">
                            <span>Shipping (+):</span>
                            <span id="delivery-charge">৳ 0</span>
                        </div>

                        <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                            <span>Payable:</span>
                            <span id="grand-total">৳ 0</span>
                        </div>
                    </div>
                </div>


                <!-- COUPON -->
                <div class="card mt-4">
                    <div class="card-body text-left">
                        <label>Have a coupon?</label>
                        <div class="input-group">
                            <input type="text" id="coupon-code" class="form-control" placeholder="Enter coupon code">
                            <button id="apply-coupon" class="btn btn-primary" style="background:#16a34a">Apply</button>
                        </div>
                        <div id="coupon-message" class="form-text mt-1"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection


@section('script')
<script>
    $(document).ready(function() {

        var currencySymbol = "{{ currency() }}";

        // Fetch cart
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let deliveryCharge = 0;
        let total = 0;

        // Calculate totals
        function updateTotals() {
            total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            $('#cart-total').text(currencySymbol + total.toFixed(2));
            $('#delivery-charge').text(currencySymbol + deliveryCharge.toFixed(2));
            $('#grand-total').text(currencySymbol + (total + deliveryCharge).toFixed(2));
            $('#grand-total1').text(currencySymbol + (total + deliveryCharge).toFixed(2));
        }

        // Update totals when delivery area changes
        $('#delivery_area').change(function() {
            deliveryCharge = parseFloat($(this).find('option:selected').data('value')) || 0;
            updateTotals();
        });

        // Listen to localStorage changes (other pages removing items)
        window.addEventListener('storage', function() {
            cart = JSON.parse(localStorage.getItem('cart')) || [];
            updateTotals();
        });

        // Optional: Poll for cart changes every second (for same-page removal)
        setInterval(function() {
            let updatedCart = JSON.parse(localStorage.getItem('cart')) || [];
            if (JSON.stringify(updatedCart) !== JSON.stringify(cart)) {
                cart = updatedCart;
                updateTotals();
            }
        }, 1000);

        // Initial totals render
        updateTotals();

        // ---------------------------
        // PLACE ORDER
        // ---------------------------
        $('#place-order').click(function() {
            if (cart.length === 0) {
                alert("Your cart is empty!");
                return;
            }

            // Clear previous errors
            $('.error-text').remove();

            // Collect form values
            let customerName = $('#name').val().trim();
            let phone = $('#phone').val().trim();
            let address = $('#address').val().trim();
            let deliveryArea = $('#delivery_area').val();
            let paymentMethod = $('input[name="payment_method"]:checked').val();

            let hasError = false;

            // Validate fields
            if (!customerName) {
                $('#name').after('<small class="text-danger error-text">Name is required</small>');
                hasError = true;
            }
            if (!phone) {
                $('#phone').after('<small class="text-danger error-text">Phone is required</small>');
                hasError = true;
            }
            if (!address) {
                $('#address').after('<small class="text-danger error-text">Address is required</small>');
                hasError = true;
            }
            if (!deliveryArea) {
                $('#delivery_area').after('<small class="text-danger error-text">Please select delivery area</small>');
                hasError = true;
            }
            if (!paymentMethod) {
                $('input[name="payment_method"]').last().after('<small class="text-danger error-text">Select a payment method</small>');
                hasError = true;
            }

            if (hasError) {
                $('html, body').animate({ scrollTop: 0 }, 'fast'); // scroll to top to show errors
                return; // stop submission
            }

            // Prepare order data
            let orderData = {
                customer_name: customerName,
                phone: phone,
                address: address,
                delivery_area: deliveryArea,
                delivery_charge: deliveryCharge,
                payment_method: paymentMethod,
                items: cart,
                total: total + deliveryCharge,
                _token: '{{ csrf_token() }}'
            };

            // COD
            if (paymentMethod === 'cod') {
                $.post("{{ route('order.store') }}", orderData, function(res) {
                    if (res.success) {
                        localStorage.removeItem('cart'); // clear cart
                        updateTotals(); // update totals immediately
                        window.location.href = `/success/${res.id}`;
                    }
                });
            }


            // SSL Commerz
            if(paymentMethod === 'sslcommerz'){
            let form = $('<form>', { method: 'POST', action: '{{ route("pay") }}' });
            form.append(`<input type='hidden' name='_token' value='{{ csrf_token() }}'>`);
            Object.keys(orderData).forEach(k=>{
                let val = (k === 'items') ? JSON.stringify(orderData[k]) : orderData[k];
                form.append(`<input type='hidden' name='${k}' value='${val}'>`);
            });
            $('body').append(form);
            form.submit();
        }

   
    });


});
</script>
@endsection