@extends('admin.layouts.app')

@section('title', 'Edit Customer Review')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="card shadow-lg border-0 rounded-4">

                    {{-- Header --}}
                    <div class="card-header bg-gradient-purple">
                        <div class="d-flex justify-content-between align-items-center text-white">
                            <h5 class="mb-0 fw-semibold">Edit Customer Review</h5>
                            <a href="{{ route('admin.customer-review.index') }}" class="btn btn-light btn-sm">
                                <i class="fa fa-angle-left"></i> Back
                            </a>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4">
                        <form action="{{ route('admin.customer-review.update', $data->id) }}" 
                              method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">
                                    Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $data->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter name" required>

                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Review Text --}}
                            <div class="mb-3">
                                <label for="review_text" class="form-label fw-medium">Review Text</label>
                                <textarea name="review_text" id="review_text" rows="4"
                                    class="form-control @error('review_text') is-invalid @enderror"
                                    placeholder="Write review...">{!! $data->review_text !!}</textarea>

                                @error('review_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Image --}}
                            <div class="mb-3">
                                <label for="image" class="form-label fw-medium">Image</label>
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror">

                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Show Existing Image --}}
                                @if($data->image)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($data->image) }}" 
                                             alt="Image" width="120" class="rounded shadow-sm">
                                    </div>
                                @endif
                            </div>

                            {{-- Status --}}
                            <div class="mb-4">
                                <label for="status" class="form-label fw-medium">Status</label>
                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                    <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Deactive</option>
                                </select>

                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="border-top pt-3 text-end">
                                <button type="submit" class="btn text-white bg-gradient-purple">
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
