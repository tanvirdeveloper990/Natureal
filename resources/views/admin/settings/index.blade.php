@extends('admin.layouts.app')

@section('title', 'Settings Update')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-lg rounded-3 overflow-hidden">

                    <!-- Header -->
                    <div class="card-header text-white d-flex justify-content-between align-items-center bg-gradient-purple">
                        <h5 class="mb-0">Settings Update</h5>
                    </div>

                    <!-- Form Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Info -->
                            <div class="row px-3 g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="company_name" class="form-label">Website Name <span class="text-danger">*</span></label>
                                    <input type="text" id="company_name" name="company_name" value="{{ $data->company_name }}"
                                        class="form-control @error('company_name') is-invalid @enderror" required>
                                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="address" class="form-label">Address <span class="text-muted">(optional)</span></label>
                                    <input type="text" id="address" name="address" value="{{ $data->address }}"
                                        class="form-control @error('address') is-invalid @enderror">
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone_one" class="form-label">Phone Number (One)</label>
                                    <input type="text" id="phone_one" name="phone_one" value="{{ $data->phone_one }}"
                                        class="form-control @error('phone_one') is-invalid @enderror" required>
                                    @error('phone_one') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone_two" class="form-label">Phone Number (Two)</label>
                                    <input type="text" id="phone_two" name="phone_two" value="{{ $data->phone_two }}"
                                        class="form-control @error('phone_two') is-invalid @enderror">
                                    @error('phone_two') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email_one" class="form-label">Email (One)</label>
                                    <input type="email" id="email_one" name="email_one" value="{{ $data->email_one }}"
                                        class="form-control @error('email_one') is-invalid @enderror" required>
                                    @error('email_one') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email_two" class="form-label">Email (Two)</label>
                                    <input type="email" id="email_two" name="email_two" value="{{ $data->email_two }}"
                                        class="form-control @error('email_two') is-invalid @enderror">
                                    @error('email_two') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Social Links -->
                            <h6 class=" px-3 mb-3">Social Media Links</h6>
                            <div class="row px-3 g-3 mb-4">
                                @foreach(['facebook', 'twitter', 'linkedin', 'youtube', 'instagram'] as $social)
                                    <div class="col-md-6">
                                        <label for="{{ $social }}" class="form-label text-capitalize">{{ ucfirst($social) }}</label>
                                        <input type="text" id="{{ $social }}" name="{{ $social }}" value="{{ $data->$social }}"
                                            class="form-control @error($social) is-invalid @enderror" placeholder="Enter your {{ $social }} link">
                                        @error($social) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                @endforeach
                                <div class="col-md-6">
                                    <label for="vendor_commission" class="form-label">Vendor Commission (%)</label>
                                    <input type="text" id="vendor_commission" name="vendor_commission" value="{{ $data->vendor_commission }}"
                                        class="form-control @error('vendor_commission') is-invalid @enderror">
                                    @error('vendor_commission') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Logos & Favicon -->
                            <h6 class=" px-3 mb-3">Logos & Favicon</h6>
                            <div class="row px-3 g-3 mb-4">
                                @foreach (['header_logo' => 'Header Logo', 'footer_logo' => 'Footer Logo', 'favicon' => 'Favicon', 'mobile_logo' => 'Mobile Logo'] as $field => $label)
                                    <div class="col-md-3 col-sm-6">
                                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                        <input type="file" name="{{ $field }}" id="{{ $field }}" class="form-control @error($field) is-invalid @enderror">
                                        @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <div class="mt-2">
                                            @if($data->$field)
                                                <img id="preview-{{ $field }}" src="{{ Storage::url($data->$field) }}" class="img-thumbnail w-100" style="height:96px; object-fit:cover;">
                                            @else
                                                <img id="preview-{{ $field }}" class="d-none img-thumbnail w-100" style="height:96px; object-fit:cover;">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Google Maps -->
                            <div class="px-3 mb-4">
                                <label for="google_maps" class="form-label">Google Maps</label>
                                <textarea id="google_maps" name="google_maps" rows="3" class="form-control @error('google_maps') is-invalid @enderror">{!! $data->google_maps !!}</textarea>
                                @error('google_maps') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- SEO Metadata -->
                            <h6 class="px-3 mb-3">SEO Meta Data</h6>
                            <div class="row px-3 g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" value="{{ $data->meta_title }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="meta_image" class="form-label">Meta Image</label>
                                    <input type="file" name="meta_image" id="meta_image" class="form-control">
                                    <div class="mt-2">
                                        @if($data->meta_image)
                                            <img id="preview-meta_image" src="{{ Storage::url($data->meta_image) }}" class="img-thumbnail w-100" style="height:96px; object-fit:cover;">
                                        @else
                                            <img id="preview-meta_image" class="d-none img-thumbnail w-100" style="height:96px; object-fit:cover;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea id="meta_description" name="meta_description" rows="3" class="form-control">{!! $data->meta_description !!}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="meta_keyword" class="form-label">Meta Keywords</label>
                                    <textarea id="meta_keyword" name="meta_keyword" rows="3" class="form-control">{!! $data->meta_keyword !!}</textarea>
                                </div>
                            </div>

                            <!-- Copyright -->
                            <div class=" px-3 mb-4">
                                <label for="copyright" class="form-label">Copyright</label>
                                <input type="text" id="copyright" name="copyright" value="{{ $data->copyright }}" class="form-control" placeholder="© 2025 Your Company">
                            </div>

                            <!-- Additional Settings -->
                            <div class="row px-3 g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="vendor_commission" class="form-label">Sellers Commission%</label>
                                    <input type="text" id="vendor_commission" name="vendor_commission" value="{{ $data->vendor_commission }}" class="form-control" placeholder="Commisions%">
                                    @error('vendor_commission') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="affilate_status" class="form-label">Affiliate Status</label>
                                    <select name="affilate_status" id="affilate_status" class="form-select @error('affilate_status') is-invalid @enderror">
                                        <option value="yes" {{$data->affilate_status=='yes' ? 'selected' : ''}}>Yes</option>
                                        <option value="no" {{$data->affilate_status=='no' ? 'selected' : ''}}>No</option>
                                    </select>
                                    @error('affilate_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="seller_status" class="form-label">Sellers Status</label>
                                    <select name="seller_status" id="seller_status" class="form-select @error('seller_status') is-invalid @enderror">
                                        <option value="yes" {{$data->seller_status=='yes' ? 'selected' : ''}}>Yes</option>
                                        <option value="no" {{$data->seller_status=='no' ? 'selected' : ''}}>No</option>
                                    </select>
                                    @error('seller_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="landing_status" class="form-label">Landing Page Status</label>
                                    <select name="landing_status" id="landing_status" class="form-select @error('landing_status') is-invalid @enderror">
                                        <option value="yes" {{$data->landing_status=='yes' ? 'selected' : ''}}>Yes</option>
                                        <option value="no" {{$data->landing_status=='no' ? 'selected' : ''}}>No</option>
                                    </select>
                                    @error('landing_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="d-flex justify-content-end border-top pt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-edit me-1"></i> Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-5 bg-light min-vh-100">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-lg rounded-3 overflow-hidden">

                    <!-- Header -->
                    <div class="card-header text-white d-flex justify-content-between align-items-center bg-gradient-purple">
                        <h5 class="mb-0">BSTI Certification</h5>
                    </div>

                    <!-- Form Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Info -->
                            <div class="row px-3 g-3 mb-4">

                             <div class="col-md-6">
                                <label for="certificate" class="form-label">Certificate Image</label>
                                <input type="file" id="certificate" name="certificate" class="form-control @error('certificate') is-invalid @enderror">
                                @error('certificate') 
                                    <div class="invalid-feedback">{{ $message }}</div> 
                                @enderror

                                <div class="mt-2">
                                    @if($data->certificate)
                                        <img id="preview-certificate" src="{{ Storage::url($data->certificate) }}" class="img-thumbnail" style="width:96px; height:96px; object-fit:cover;">
                                    @else
                                        <img id="preview-certificate" class="d-none img-thumbnail" style="width:96px; height:96px; object-fit:cover;">
                                    @endif
                                </div>
                            </div>


                            <!-- Certificate Title -->
                            <div class="col-md-6">
                                <label for="title" class="form-label">Certificate Title</label>
                                <input type="text" id="title" name="title" value="{{ $data->title }}"
                                    class="form-control @error('title') is-invalid @enderror" placeholder="Enter certificate title">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter certificate description">{{ $data->description }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>



                             <div class="col-md-6">
                                <label for="list_1" class="form-label">List One</label>
                                <input type="text" id="list_1" name="list_1" value="{{ $data->list_1 }}" class="form-control @error('list_1') is-invalid @enderror">
                                @error('list_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="list_2" class="form-label">List Two</label>
                                <input type="text" id="list_2" name="list_2" value="{{ $data->list_2 }}" class="form-control @error('list_2') is-invalid @enderror">
                                @error('list_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="list_3" class="form-label">List Three</label>
                                <input type="text" id="list_3" name="list_3" value="{{ $data->list_3 }}" class="form-control @error('list_3') is-invalid @enderror">
                                @error('list_3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="list_4" class="form-label">List Four</label>
                                <input type="text" id="list_4" name="list_4" value="{{ $data->list_4 }}" class="form-control @error('list_4') is-invalid @enderror">
                                @error('list_4') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="list_5" class="form-label">List Five</label>
                                <input type="text" id="list_5" name="list_5" value="{{ $data->list_5 }}" class="form-control @error('list_5') is-invalid @enderror">
                                @error('list_5') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="list_6" class="form-label">List Six</label>
                                <input type="text" id="list_6" name="list_6" value="{{ $data->list_6 }}" class="form-control @error('list_6') is-invalid @enderror">
                                @error('list_6') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>


                             <!-- Button -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" id="button_text" name="button_text" value="{{ $data->button_text }}" class="form-control @error('button_text') is-invalid @enderror">
                                @error('button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="button_link" class="form-label">Button Link</label>
                                <input type="text" id="button_link" name="button_link" value="{{ $data->button_link }}" class="form-control @error('button_link') is-invalid @enderror">
                                @error('button_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                            </div>
  

                            <!-- Submit -->
                            <div class="d-flex justify-content-end border-top pt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-edit me-1"></i> Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    ['certificate'].forEach(id => {
        const input = document.getElementById(id);
        if(input){
            input.addEventListener('change', function (event) {
                const preview = document.getElementById(`preview-${id}`);
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.classList.add('d-none');
                }
            });
        }
    });
</script>

@endsection
