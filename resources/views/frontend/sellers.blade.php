@extends('layouts.app')

@section('title', 'Sellers Register')
@section('css')

<style>
   
    .seller-bg {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-image: url({{ asset('/assets/img/seller-register.png') }});
    }

    .seller-card{
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    }

    .seller-title{
        font-weight: 700;
        color: #1e3c72;
    }

    .seller-sub{
        color: #666;
        font-size: 15px;
    }

    .btn-primary{
        background: #1e3c72;
        border:none;
        border-radius:50px;
        padding: 10px 25px;
    }

    .btn-primary:hover{
        background:#162f5c;
        transform: translateY(-1px);
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
                    <p class="seller-sub">Join our platform and start selling your service today 🚀</p>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Company / Shop Name</label>
                            <input type="text" class="form-control" name="company" value="{{ old('company') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" id="password" class="form-control" name="password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Business Type</label>
                        <select class="custom-select" name="business_type">
                            <option>Select One</option>
                            <option>Individual</option>
                            <option>Company</option>
                            <option>Marketplace</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Business Address</label>
                        <textarea class="form-control" name="address" rows="2"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tax ID / Trade License</label>
                            <input type="text" class="form-control" name="tax_id">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Website</label>
                            <input type="url" class="form-control" name="website">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Upload Logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo">
                            <img id="logoPreview" style="max-height:100px;margin-top:10px;display:none;">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Business Documents (PDF)</label>
                            <input type="file" class="form-control-file" name="documents[]" multiple>
                        </div>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" required>
                        <label class="form-check-label">I agree with Terms & Conditions</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Already have an account? <a href="#">Login</a></small>
                        <button type="submit" class="btn btn-primary">
                            Register as Seller
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
</div>


@endsection
