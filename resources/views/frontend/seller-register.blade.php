@extends('layouts.app')

@section('title', 'Seller Registration')

@section('css')
<style>
    .seller-bg {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-image: url({{ asset('/assets/img/seller-register.png')}});
        background-size: cover;
    }

    .seller-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    }

    .seller-title {
        font-weight: 700;
        color: #1e3c72;
    }
</style>
@endsection

@section('content')

<div class="seller-bg py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="seller-card">
                    <div class="text-center mb-4">
                        <h2 class="seller-title">Become a Hostilica Seller</h2>
                        <p class="seller-sub">Join our platform and start selling your services today 🚀</p>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('seller.register.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Full Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Shop Name *</label>
                                <input type="text" name="shop_name"
                                    class="form-control @error('shop_name') is-invalid @enderror"
                                    value="{{ old('shop_name') }}" required>
                                @error('shop_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email *</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Phone *</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" required>
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Password *</label>

                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required>

                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                            onclick="togglePassword('password', 'togglePasswordIcon1')"
                                            style="cursor:pointer;">
                                            <i id="togglePasswordIcon1" class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label>Confirm Password *</label>

                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>

                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                            onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')"
                                            style="cursor:pointer;">
                                            <i id="togglePasswordIcon2" class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Postal Code</label>
                                <input type="text" name="postal_code" class="form-control"
                                    value="{{ old('postal_code') }}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Upload Logo</label>
                                <input type="file" name="logo"
                                    class="form-control p-1 @error('logo') is-invalid @enderror" required>
                                @error('logo') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Upload Banner</label>
                                <input type="file" name="banner"
                                    class="form-control p-1 @error('banner') is-invalid @enderror">
                                @error('banner') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            
                            <!-- Terms -->
                            <div>
                                <div class="form-check">
                                    <input type="checkbox" name="terms" class="form-check-input @error('terms') is-invalid @enderror" 
                                        id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-primary font-weight-bold">Terms & Conditions</a>
                                    </label>
                                    @error('terms')
                                        <br><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Already Account -->
                                <small class="text-muted">
                                    Already have an account?
                                    <a href="{{ route('seller.login') }}" class="text-primary font-weight-bold">Login</a>
                                </small>
                            </div>

                            <!-- Register Button -->
                            <div>
                                <button class="btn btn-primary mt-2 px-4">
                                    Register as Seller
                                </button>
                            </div>

                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function togglePassword(fieldId, iconId) {
    let field = document.getElementById(fieldId);
    let icon = document.getElementById(iconId);

    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        field.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

@endsection