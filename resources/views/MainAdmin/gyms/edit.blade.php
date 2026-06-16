@extends('layouts.app')

@section('title', 'Edit Gym')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gyms /</span> Edit Gym</h4>
            </div>
            <div class="card p-3">
                <form action="{{ route('main_admin.gyms.update', $gym->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ $gym->image && Storage::exists('public/' . $gym->image) ? Storage::url($gym->image) : asset('/assets/img/default.png') }}"
                                alt="{{ $gym->name }}" class="img-fluid rounded my-4" height="110" width="110"
                                id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" name="image" hidden />
                                </label>
                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $gym->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" value="{{ old('address', $gym->address) }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="domain" class="col-sm-2 col-form-label">Domain</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('domain') is-invalid @enderror" id="domain"
                                name="domain" value="{{ old('domain', $gym->domain) }}">
                            @error('domain')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone', $gym->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="operating_hours" class="col-sm-2 col-form-label">Operating Hours</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('operating_hours') is-invalid @enderror"
                                id="operating_hours" name="operating_hours"
                                value="{{ old('operating_hours', $gym->operating_hours) }}" required>
                            @error('operating_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="city" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                name="city" value="{{ old('city', $gym->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="region" class="col-sm-2 col-form-label">Region</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('region') is-invalid @enderror" id="region"
                                name="region" value="{{ old('region', $gym->region) }}">
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status"
                                    {{ old('status', $gym->status) == 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Gym</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Show Pic Instantly --}}
    <script>
        document.getElementById('upload').addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var output = document.getElementById('uploadedAvatar');
                output.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        });
    </script>
@endsection
