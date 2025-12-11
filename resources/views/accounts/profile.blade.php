<!-- resources/views/users/profile.blade.php -->
@extends('layouts.admin')

@section('content')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.profile-header {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.timeline-item {
    position: relative;
    padding-left: 0;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 19px;
    top: 50px;
    width: 2px;
    height: calc(100% - 10px);
    background: #e9ecef;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    border-radius: 8px;
}

.card-header {
    border-bottom: 2px solid #f0f0f0;
    padding: 1rem 1.25rem;
}

.modal-content {
    border-radius: 8px;
}

.modal-header {
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
</style>

<div class="container-fluid mt-5">
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> Please correct the errors below.
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <!-- Profile Header -->
    <div class="card profile-header mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="profile-avatar mr-4">
                    @if($user->profile_photo_path)
                        <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profile" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid white;">
                    @else
                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 36px; font-weight: bold; border: 4px solid white;">
                            {{ strtoupper(substr($user->firstname, 0, 1)) }}{{ strtoupper(substr($user->lastname, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="text-white">
                    <h3 class="mb-1">{{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</h3>
                    <p class="mb-1"><i class="fas fa-briefcase"></i> {{ $user->position ?? 'N/A' }}</p>
                    <p class="mb-1"><i class="fas fa-building"></i> {{ $user->unit ?? 'N/A' }}</p>
                    <span class="badge badge-light mt-2">
                        <i class="fas fa-shield-alt"></i>
                        @if($user->emp_type == 0)
                            Administrator
                        @elseif($user->emp_type == 1)
                            Accreditor
                        @elseif($user->emp_type == 2)
                            Employee
                        @else
                            N/A
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Personal Information -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-user text-primary"></i> Personal Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 40%;">Employee ID</td>
                            <td class="font-weight-bold">{{ $user->emp_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Full Name</td>
                            <td class="font-weight-bold">{{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Gender</td>
                            <td class="font-weight-bold">{{ $user->gender ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td class="font-weight-bold">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Username</td>
                            <td class="font-weight-bold">{{ $user->username ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Work Information -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-briefcase text-primary"></i> Work Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 40%;">Position</td>
                            <td class="font-weight-bold">{{ $user->position ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Division</td>
                            <td class="font-weight-bold">{{ $user->division ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Unit</td>
                            <td class="font-weight-bold">{{ $user->unit ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Province</td>
                            <td class="font-weight-bold">{{ $user->province ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Account Status</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-history text-primary"></i> Activity Timeline</h5>
        </div>
        <div class="card-body">
            <div class="timeline">
                <div class="timeline-item mb-3">
                    <div class="d-flex">
                        <div class="timeline-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; min-width: 40px;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Account Created</h6>
                            <p class="text-muted mb-0">Your account was successfully created</p>
                            <small class="text-muted"><i class="far fa-clock"></i> {{ $user->created_at->format('F d, Y \a\t h:i A') }}</small>
                        </div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="d-flex">
                        <div class="timeline-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; min-width: 40px;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Profile Updated</h6>
                            <p class="text-muted mb-0">Your profile information was last updated</p>
                            <small class="text-muted"><i class="far fa-clock"></i> {{ $user->updated_at->format('F d, Y \a\t h:i A') }} ({{ $user->updated_at->diffForHumans() }})</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <button type="button" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#editProfileModal">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
        </div>
        <div class="col-md-6 mb-3">
            <button type="button" class="btn btn-outline-secondary btn-block btn-lg" data-toggle="modal" data-target="#changePasswordModal">
                <i class="fas fa-key"></i> Change Password
            </button>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-edit"></i> Edit Profile</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('accounts.updateProfile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
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

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Division Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="division" class="form-label">Division</label>
                            <select name="division" class="form-control @error('division') is-invalid @enderror" id="division">
                                <option value="">--Select Division--</option>
                                @php
                                    $divisions = App\Models\Division::select('id', 'division')->distinct()->get();
                                @endphp
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->division }}"
                                        {{ old('division', $user->division) == $division->division ? 'selected' : '' }}>
                                        {{ $division->division }}
                                    </option>
                                @endforeach
                            </select>
                            @error('division')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Unit Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <select name="unit" class="form-control @error('unit') is-invalid @enderror" id="unit">
                                <option value="">--Select Unit--</option>
                                @php
                                    $units = App\Models\Unit::select('id', 'unit')->distinct()->get();
                                @endphp
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->unit }}"
                                        {{ old('unit', $user->unit) == $unit->unit ? 'selected' : '' }}>
                                        {{ $unit->unit }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Position Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select name="position" class="form-control @error('position') is-invalid @enderror" id="position">
                                <option value="">--Select Position--</option>
                                @php
                                    $positions = App\Models\Position::select('id', 'position')->distinct()->get();
                                @endphp
                                @foreach ($positions as $position)
                                    <option value="{{ $position->position }}"
                                        {{ old('position', $user->position) == $position->position ? 'selected' : '' }}>
                                        {{ $position->position }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Province Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="province" class="form-label">Province</label>
                            <select name="province" class="form-control @error('province') is-invalid @enderror" id="province">
                                <option value="">--Select Province--</option>
                                @php
                                    $provinces = App\Models\Province::select('id', 'province')->distinct()->get();
                                @endphp
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->province }}"
                                        {{ old('province', $user->province) == $province->province ? 'selected' : '' }}>
                                        {{ $province->province }}
                                    </option>
                                @endforeach
                            </select>
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-key"></i> Change Password</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('accounts.changePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                               id="new_password" name="new_password" required>
                        <small class="form-text text-muted">Minimum 8 characters</small>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control"
                               id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-lock"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto open modals if there are validation errors
    @if($errors->has('firstname') || $errors->has('middlename') || $errors->has('lastname') || $errors->has('email') || $errors->has('gender') || $errors->has('division') || $errors->has('unit') || $errors->has('position') || $errors->has('province'))
        $('#editProfileModal').modal('show');
    @endif

    @if($errors->has('current_password') || $errors->has('new_password'))
        $('#changePasswordModal').modal('show');
    @endif
});
</script>
@endsection
