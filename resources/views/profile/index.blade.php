@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">My Profile</h4>
                <div class="page-title-right">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 col-xl-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-photo-wrapper mb-3">
                        @if($user->profile_photo_path)
                            <img src="{{ Storage::url($user->profile_photo_path) }}"
                                 alt="Profile Photo"
                                 class="rounded-circle img-thumbnail"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                 style="width: 150px; height: 150px; font-size: 48px;">
                                {{ strtoupper(substr($user->firstname, 0, 1)) }}{{ strtoupper(substr($user->lastname, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <h4 class="mb-1">{{ $user->firstname }} {{ $user->lastname }}</h4>
                    <p class="text-muted mb-2">{{ $user->position ?? 'N/A' }}</p>
                    <p class="text-muted mb-3">
                        <i class="fas fa-id-badge"></i> {{ $user->emp_id }}
                    </p>

                    <div class="d-flex justify-content-center gap-2 mb-3">
                        @if($user->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif

                        @if($user->email_verified_at)
                            <span class="badge badge-info">Verified</span>
                        @endif
                    </div>

                    <div class="text-left">
                        <p class="mb-2"><strong>Email:</strong></p>
                        <p class="text-muted mb-3">{{ $user->email }}</p>

                        @if($user->mobile_no)
                        <p class="mb-2"><strong>Mobile:</strong></p>
                        <p class="text-muted mb-3">{{ $user->mobile_no }}</p>
                        @endif

                        @if($user->last_login)
                        <p class="mb-2"><strong>Last Login:</strong></p>
                        <p class="text-muted mb-0">{{ $user->last_login->format('M d, Y h:i A') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Personal Information</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Employee ID:</label>
                            <p class="text-muted">{{ $user->emp_id }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">First Name:</label>
                            <p class="text-muted">{{ $user->firstname }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Middle Name:</label>
                            <p class="text-muted">{{ $user->middlename ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Last Name:</label>
                            <p class="text-muted">{{ $user->lastname }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Gender:</label>
                            <p class="text-muted">{{ $user->gender ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Position:</label>
                            <p class="text-muted">{{ $user->position ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h5 class="card-title mb-4 mt-4">Work Information</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Division:</label>
                            <p class="text-muted">{{ $user->division ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Unit:</label>
                            <p class="text-muted">{{ $user->unit ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Province:</label>
                            <p class="text-muted">{{ $user->province ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Region:</label>
                            <p class="text-muted">{{ $user->region ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Groups:</label>
                            <p class="text-muted">{{ $user->groups ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Roles:</label>
                            <p class="text-muted">{{ $user->roles ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h5 class="card-title mb-4 mt-4">Contact Information</h5>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="font-weight-bold">Address:</label>
                            <p class="text-muted">{{ $user->address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Email:</label>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Mobile Number:</label>
                            <p class="text-muted">{{ $user->mobile_no ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h5 class="card-title mb-4 mt-4">Account Information</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Account Created:</label>
                            <p class="text-muted">{{ $user->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Last Updated:</label>
                            <p class="text-muted">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-photo-wrapper {
    position: relative;
    display: inline-block;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
@endsection

<!-- resources/views/profile/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit Profile</h4>
                <div class="page-title-right">
                    <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <!-- Profile Photo Update -->
        <div class="col-lg-4 col-xl-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title mb-4">Profile Photo</h5>

                    <div class="profile-photo-wrapper mb-3">
                        @if($user->profile_photo_path)
                            <img src="{{ Storage::url($user->profile_photo_path) }}"
                                 alt="Profile Photo"
                                 id="profilePhotoPreview"
                                 class="rounded-circle img-thumbnail"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div id="profilePhotoPreview" class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                 style="width: 150px; height: 150px; font-size: 48px;">
                                {{ strtoupper(substr($user->firstname, 0, 1)) }}{{ strtoupper(substr($user->lastname, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Max size: 2MB. Allowed: JPG, PNG, GIF</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-upload"></i> Upload Photo
                        </button>
                    </form>

                    @if($user->profile_photo_path)
                    <form action="{{ route('profile.photo.delete') }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete your profile photo?')">
                            <i class="fas fa-trash"></i> Remove Photo
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Information Edit -->
        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Personal Information</h5>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="emp_id" class="form-label">Employee ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('emp_id') is-invalid @enderror"
                                       id="emp_id" name="emp_id" value="{{ old('emp_id', $user->emp_id) }}" required>
                                @error('emp_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                       id="firstname" name="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" class="form-control @error('middlename') is-invalid @enderror"
                                       id="middlename" name="middlename" value="{{ old('middlename', $user->middlename) }}">
                                @error('middlename')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                       id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Work Information</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror"
                                       id="position" name="position" value="{{ old('position', $user->position) }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="division" class="form-label">Division</label>
                                <input type="text" class="form-control @error('division') is-invalid @enderror"
                                       id="division" name="division" value="{{ old('division', $user->division) }}">
                                @error('division')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                       id="unit" name="unit" value="{{ old('unit', $user->unit) }}">
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="region" class="form-label">Region</label>
                                <input type="text" class="form-control @error('region') is-invalid @enderror"
                                       id="region" name="region" value="{{ old('region', $user->region) }}">
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="province" class="form-label">Province</label>
                                <input type="text" class="form-control @error('province') is-invalid @enderror"
                                       id="province" name="province" value="{{ old('province', $user->province) }}">
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Contact Information</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mobile_no" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control @error('mobile_no') is-invalid @enderror"
                                       id="mobile_no" name="mobile_no" value="{{ old('mobile_no', $user->mobile_no) }}">
                                @error('mobile_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            <a href="{{ route('profile.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Change Password</h5>

                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                       id="new_password" name="new_password" required>
                                <small class="form-text text-muted">Minimum 8 characters</small>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control"
                                       id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview profile photo before upload
document.getElementById('profile_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profilePhotoPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded-circle img-thumbnail';
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.objectFit = 'cover';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
