@extends('layouts.admin')

@section('content')
<style>
    /* Pagination Style */
    .pagination-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 15px;
        gap: 15px;
    }

    .pagination {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .pagination button {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        background: white;
        color: #0d6efd;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
        min-width: 38px;
    }

    .pagination button:hover:not(.disabled):not(.active) {
        background: #e7f1ff;
        border-color: #0d6efd;
    }

    .pagination button.active {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .pagination button.disabled {
        background: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
        border-color: #dee2e6;
    }

    .page-size-selector {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .page-size-selector select {
        padding: 6px 10px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .search-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .search-input-wrapper {
        margin-left: auto;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }

    .modal-body .row {
        margin-bottom: 10px;
    }
    /* Hover effects for buttons */
.btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s;
}

.btn:active {
    transform: translateY(0);
}

/* Smooth focus transitions */
.form-control:focus,
.form-select:focus {
    transform: translateY(-1px);
}

/* Modal backdrop animation */
.modal.fade .modal-dialog {
    transform: scale(0.8);
    opacity: 0;
    transition: all 0.3s;
}

.modal.show .modal-dialog {
    transform: scale(1);
    opacity: 1;
}
</style>

<!-- Content header -->
<div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0 me-auto">User Management</h1>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Card with table -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
        <div><i class="fa fa-users me-2"></i>Users List</div>
        <div class="small">
            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fa-solid fa-user-plus me-1"></i> Create User
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="search-container">
            <div class="page-size-selector">
                <label for="pageSizeSelect">Show:</label>
                <select id="pageSizeSelect">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" class="form-control" placeholder="Search users..." style="width: 250px;">
            </div>
        </div>

        <div class="table-responsive">
            <table id="UsersTable" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Employee ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Division/Unit</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->emp_id }}</td>
                        <td>{{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->position->position ?? 'N/A' }}</td>
                        <td>{{ $user->divisionUnit->division_unit ?? 'N/A' }}</td>
                        <td><span class="badge bg-info">{{ $user->roles ?? 'N/A' }}</span></td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                                <!-- View Button -->
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewUserModal-{{ $user->id }}" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                           <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#resetPasswordModal-{{ $user->id }}" title="Reset Password">
                                <i class="fas fa-key"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateUserModal-{{ $user->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal-{{ $user->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- VIEW USER MODAL -->
<div class="modal fade" id="viewUserModal-{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; padding: 24px 30px; border: none;">
                <div>
                    <h5 class="modal-title mb-1" style="font-weight: 700; font-size: 20px;">
                        <i class="fas fa-user-circle me-2"></i>User Details
                    </h5>
                    <small style="opacity: 0.9; font-size: 13px;">View user information</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" style="padding: 0; background: #f8fafc;">
                <!-- Profile Header -->
                <div style="background: white; padding: 30px; text-align: center; border-bottom: 1px solid #e2e8f0;">
                    <div style="width: 100px; height: 100px; margin: 0 auto 16px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(99,102,241,0.3);">
                        <i class="fas fa-user" style="font-size: 48px; color: white;"></i>
                    </div>
                    <h4 style="margin: 0 0 8px 0; font-weight: 700; color: #1e293b;">
                        {{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}
                    </h4>
                    <p style="margin: 0 0 12px 0; color: #64748b; font-size: 14px;">
                        <i class="fas fa-briefcase me-1"></i>{{ optional($user->position)->position ?? 'No Position' }}
                    </p>
                    <div>
                        @if($user->is_active)
                            <span style="background: #d1fae5; color: #065f46; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                                <i class="fas fa-check-circle me-1"></i>Active
                            </span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                                <i class="fas fa-times-circle me-1"></i>Inactive
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Information Sections -->
                <div style="padding: 30px;">
                    <!-- Account Information -->
                    <div style="background: white; border-radius: 8px; padding: 20px; margin-bottom: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <h6 style="color: #6366f1; font-weight: 700; margin-bottom: 16px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fas fa-id-card me-2"></i>Account Information
                        </h6>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Employee ID</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ $user->emp_id }}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Username</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ $user->username }}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Email</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ $user->email }}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Gender</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ $user->gender ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Work Information -->
                    <div style="background: white; border-radius: 8px; padding: 20px; margin-bottom: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <h6 style="color: #6366f1; font-weight: 700; margin-bottom: 16px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fas fa-briefcase me-2"></i>Work Information
                        </h6>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Position</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ optional($user->position)->position ?? 'Not assigned' }}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Division/Unit</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ optional($user->divisionUnit)->division_unit ?? 'Not assigned' }}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Employee Type</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ $user->emp_type ?? 'Not specified' }}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Role</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">
                                    <span style="background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                        <i class="fas fa-shield-alt me-1"></i>{{ $user->roles ?? 'Not assigned' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <h6 style="color: #6366f1; font-weight: 700; margin-bottom: 16px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fas fa-clock me-2"></i>System Information
                        </h6>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Account Created</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="col-6 mb-3">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Last Updated</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">{{ \Carbon\Carbon::parse($user->updated_at)->format('M d, Y h:i A') }}</p>
                            </div>
                            @if($user->last_login)
                            <div class="col-12">
                                <p style="margin: 0 0 4px 0; font-size: 12px; color: #64748b; font-weight: 600;">Last Login</p>
                                <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: 500;">
                                    {{ \Carbon\Carbon::parse($user->last_login)->format('M d, Y h:i A') }}
                                    <small style="color: #64748b;">({{ \Carbon\Carbon::parse($user->last_login)->diffForHumans() }})</small>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer" style="padding: 16px 30px; background: white; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="border-radius: 6px; padding: 10px 24px; font-weight: 600; font-size: 14px; border: 1px solid #cbd5e1; background: white; color: #475569;">
                    <i class="fas fa-times me-1"></i>Close
                </button>
                {{-- @if(auth()->user()->roles == 'Admin')
                <button type="button" class="btn" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#updateUserModal-{{ $user->id }}"
                        style="border-radius: 6px; padding: 10px 24px; font-weight: 600; font-size: 14px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); border: none; color: white;">
                    <i class="fas fa-edit me-1"></i>Edit User
                </button>
                @endif --}}
            </div>
        </div>
    </div>
</div>



                    <!-- Update Modal -->
<div class="modal fade" id="updateUserModal-{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; padding: 24px 30px;">
                    <div>
                        <h5 class="modal-title mb-1" style="font-weight: 700; font-size: 20px;">
                            <i class="fas fa-user-edit me-2"></i>Update User
                        </h5>
                        <small style="opacity: 0.9;">{{ $user->username }}</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <!-- Account Information -->
                    <div class="mb-4">
                        <h6 style="color: #667eea; font-weight: 700; margin-bottom: 16px;">
                            <i class="fas fa-id-card me-2"></i>Account Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-hashtag me-1"></i>Employee ID *
                                </label>
                                <input type="text" class="form-control" name="emp_id" value="{{ $user->emp_id }}" required style="border-radius: 8px; border: 2px solid #e2e8f0;">
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="mb-4">
                        <h6 style="color: #667eea; font-weight: 700; margin-bottom: 16px;">
                            <i class="fas fa-user-circle me-2"></i>Personal Information
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">First Name *</label>
                                <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}" required style="border-radius: 8px; border: 2px solid #e2e8f0;">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">Middle Name</label>
                                <input type="text" class="form-control" name="middlename" value="{{ $user->middlename }}" style="border-radius: 8px; border: 2px solid #e2e8f0;">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">Last Name *</label>
                                <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}" required style="border-radius: 8px; border: 2px solid #e2e8f0;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-envelope me-1"></i>Email *
                                </label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required style="border-radius: 8px; border: 2px solid #e2e8f0;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-venus-mars me-1"></i>Gender
                                </label>
                                <select class="form-select" name="gender" style="border-radius: 8px; border: 2px solid #e2e8f0;">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Work Information -->
                    <div class="mb-4">
                        <h6 style="color: #667eea; font-weight: 700; margin-bottom: 16px;">
                            <i class="fas fa-briefcase me-2"></i>Work Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-user-tie me-1"></i>Position
                                </label>
                                <select class="form-select" name="id_position" style="border-radius: 8px; border: 2px solid #e2e8f0;">
                                    <option value="">Select Position</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}" {{ $user->id_position == $position->id ? 'selected' : '' }}>
                                            {{ $position->position }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-building me-1"></i>Division/Unit
                                </label>
                                <select class="form-select" name="id_division_unit" style="border-radius: 8px; border: 2px solid #e2e8f0;">
                                    <option value="">Select Division/Unit</option>
                                    @foreach($division_units as $division_unit)
                                        <option value="{{ $division_unit->id }}" {{ $user->id_division_unit == $division_unit->id ? 'selected' : '' }}>
                                            {{ $division_unit->division_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-id-badge me-1"></i>Employee Type
                                </label>
                                <select class="form-select" name="emp_type" style="border-radius: 8px; border: 2px solid #e2e8f0;">
                                    <option value="">Select Type</option>
                                    <option value="Permanent" {{ $user->emp_type  == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                    <option value="Contractual" {{ $user->emp_type  == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-shield-alt me-1"></i>Role
                                </label>
                                <select class="form-select" name="roles" style="border-radius: 8px; border: 2px solid #e2e8f0;">
                                    <option value="">Select Role</option>
                                    <option value="Admin" {{ $user->roles == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Employee" {{ $user->roles == 'Employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="mb-3">
                        <h6 style="color: #667eea; font-weight: 700; margin-bottom: 16px;">
                            <i class="fas fa-lock me-2"></i>Security
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-user me-1"></i>Username *
                                </label>
                                <input type="text" class="form-control" name="username" value="{{ $user->username }}" required style="border-radius: 8px; border: 2px solid #e2e8f0;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-key me-1"></i>New Password
                                </label>
                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current" style="border-radius: 8px; border: 2px solid #e2e8f0;">
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #475569;">
                                    <i class="fas fa-toggle-on me-1"></i>Account Status *
                                </label>
                                <select class="form-select" name="is_active" required style="border-radius: 8px; border: 2px solid #e2e8f0;">
                                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 20px 30px; background: #f8fafc;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 24px;">
                        <i class="fas fa-times me-1"></i>Close
                    </button>
                    <button type="submit" class="btn btn-warning" style="border-radius: 8px; padding: 10px 24px; font-weight: 600;">
                        <i class="fas fa-save me-1"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

       <!-- RESET PASSWORD MODAL -->
                    <div class="modal fade" id="resetPasswordModal-{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
                                <form action="{{ route('users.reset-password', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; padding: 24px 30px; border: none;">
                                        <div>
                                            <h5 class="modal-title mb-1" style="font-weight: 700; font-size: 20px;">
                                                <i class="fas fa-key me-2"></i>Reset Password
                                            </h5>
                                            <small style="opacity: 0.9;">Reset user password to default</small>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body" style="padding: 30px;">
                                        <!-- Info Icon -->
                                        <div class="text-center mb-4">
                                            <div style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-redo-alt" style="font-size: 32px; color: #2563eb;"></i>
                                            </div>
                                        </div>

                                        <p style="text-align: center; font-size: 16px; color: #475569; margin-bottom: 24px;">
                                            Are you sure you want to reset the password for this user?
                                        </p>

                                        <!-- User Info Card -->
                                        <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 20px; border-radius: 12px; border-left: 4px solid #3b82f6; margin-bottom: 20px;">
                                            <div style="display: flex; align-items: center; gap: 16px;">
                                                <div style="width: 50px; height: 50px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user" style="font-size: 24px; color: #3b82f6;"></i>
                                                </div>
                                                <div style="flex: 1;">
                                                    <h6 style="margin: 0 0 4px 0; font-weight: 700; color: #1e3a8a; font-size: 16px;">
                                                        {{ $user->firstname }} {{ $user->lastname }}
                                                    </h6>
                                                    <p style="margin: 0; font-size: 13px; color: #1e40af;">
                                                        <i class="fas fa-user-circle me-1"></i>Username: <strong>{{ $user->username }}</strong>
                                                    </p>
                                                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #1e40af;">
                                                        <i class="fas fa-envelope me-1"></i>Email: <strong>{{ $user->email }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Info Message -->
                                        <div style="background: #fef3c7; padding: 16px; border-radius: 10px; border-left: 4px solid #f59e0b;">
                                            <p style="margin: 0; font-size: 14px; color: #78350f;">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Note:</strong> The password will be reset to the default password: <strong>"12345678"</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="padding: 20px 30px; background: #f8fafc; border-top: 2px solid #f1f5f9;">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                style="border-radius: 10px; padding: 12px 28px; font-weight: 600; border: 2px solid #e2e8f0;">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </button>
                                        <button type="submit" class="btn"
                                                style="border-radius: 10px; padding: 12px 28px; font-weight: 600; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none; color: white; box-shadow: 0 4px 12px rgba(99,102,241,0.3);">
                                            <i class="fas fa-redo-alt me-1"></i>Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

<!-- DELETE USER MODAL -->
<div class="modal fade" id="deleteUserModal-{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 24px 30px; border: none;">
                    <div>
                        <h5 class="modal-title mb-1" style="font-weight: 700; font-size: 20px;">
                            <i class="fas fa-exclamation-triangle me-2"></i>Delete User
                        </h5>
                        <small style="opacity: 0.9;">This action cannot be undone</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <!-- Warning Icon -->
                    <div class="text-center mb-4">
                        <div style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-trash-alt" style="font-size: 32px; color: #dc2626;"></i>
                        </div>
                    </div>

                    <p style="text-align: center; font-size: 16px; color: #475569; margin-bottom: 24px;">
                        Are you sure you want to delete this user account?
                    </p>

                    <!-- User Info Card -->
                    <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 20px; border-radius: 12px; border-left: 4px solid #f59e0b; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 50px; height: 50px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="font-size: 24px; color: #f59e0b;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h6 style="margin: 0 0 4px 0; font-weight: 700; color: #78350f; font-size: 16px;">
                                    {{ $user->firstname }} {{ $user->lastname }}
                                </h6>
                                <p style="margin: 0; font-size: 13px; color: #92400e;">
                                    <i class="fas fa-user-circle me-1"></i>Username: <strong>{{ $user->username }}</strong>
                                </p>
                                <p style="margin: 4px 0 0 0; font-size: 13px; color: #92400e;">
                                    <i class="fas fa-id-badge me-1"></i>Employee ID: <strong>{{ $user->emp_id }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Warning Message -->
                    <div style="background: #fef2f2; padding: 16px; border-radius: 10px; border-left: 4px solid #dc2626;">
                        <p style="margin: 0; font-size: 14px; color: #991b1b;">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Warning:</strong> This will permanently delete the user account and all associated data. This action cannot be reversed.
                        </p>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 20px 30px; background: #f8fafc; border-top: 2px solid #f1f5f9;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 10px; padding: 12px 28px; font-weight: 600; border: 2px solid #e2e8f0;">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger"
                            style="border-radius: 10px; padding: 12px 28px; font-weight: 600; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border: none; box-shadow: 0 4px 12px rgba(239,68,68,0.3);">
                        <i class="fas fa-trash-alt me-1"></i>Delete User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Container -->
        <div class="pagination-container">
            <div class="pagination" id="pagination"></div>
        </div>
    </div>
</div>

<!-- CREATE USER MODAL -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <!-- Header -->
                <div class="modal-header bg-success text-white">
                    <div>
                        <h5 class="modal-title mb-0" style="font-weight: 700; font-size: 20px;">
                            <i class="fas fa-user-plus me-2"></i>Create User
                        </h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body" style="padding: 30px; background: white;">

                    <!-- Account Information -->
                    <div class="mb-4">
                        <h6 style="color: #6366f1; font-weight: 700; margin-bottom: 16px; font-size: 15px;">
                            <i class="fas fa-id-card me-2"></i>Account Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-hashtag me-1" style="color: #94a3b8; font-size: 12px;"></i>Employee ID *
                                </label>
                                <input type="text" class="form-control" name="emp_id" required
                                       style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;"
                                       placeholder="EMP001">
                            </div>

                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="mb-4">
                        <h6 style="color: #6366f1; font-weight: 700; margin-bottom: 16px; font-size: 15px;">
                            <i class="fas fa-user-circle me-2"></i>Personal Information
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    First Name *
                                </label>
                                <input type="text" class="form-control" name="firstname" required
                                       style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;"
                                       placeholder="John">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    Middle Name
                                </label>
                                <input type="text" class="form-control" name="middlename"
                                       style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;"
                                       placeholder="M.">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    Last Name *
                                </label>
                                <input type="text" class="form-control" name="lastname" required
                                       style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;"
                                       placeholder="Doe">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-envelope me-1" style="color: #94a3b8; font-size: 12px;"></i>Email *
                                </label>
                                <input type="email" class="form-control" name="email" required
                                       style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;"
                                       placeholder="john@example.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-venus-mars me-1" style="color: #94a3b8; font-size: 12px;"></i>Gender
                                </label>
                                <select class="form-select" name="gender"
                                        style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Work Information -->
                    <div class="mb-4">
                        <h6 style="color: #6366f1; font-weight: 700; margin-bottom: 16px; font-size: 15px;">
                            <i class="fas fa-briefcase me-2"></i>Work Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-user-tie me-1" style="color: #94a3b8; font-size: 12px;"></i>Position
                                </label>
                                <select class="form-select" name="id_position"
                                        style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;">
                                    <option value="">Select Position</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->position }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-building me-1" style="color: #94a3b8; font-size: 12px;"></i>Division/Unit
                                </label>
                                <select class="form-select" name="id_division_unit"
                                        style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;">
                                    <option value="">Select Division/Unit</option>
                                    @foreach($division_units as $division_unit)
                                        <option value="{{ $division_unit->id }}">{{ $division_unit->division_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-id-badge me-1" style="color: #94a3b8; font-size: 12px;"></i>Employee Type
                                </label>
                                <select class="form-select" name="emp_type"
                                        style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;">
                                    <option value="">Select Type</option>
                                    <option value="Permanent">Permanent</option>
                                    <option value="Contractual">Contractual</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-shield-alt me-1" style="color: #94a3b8; font-size: 12px;"></i>Role
                                </label>
                                <select class="form-select" name="roles"
                                        style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;">
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Employee">Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="mb-3">
                        <h6 style="color: #6366f1; font-weight: 700; margin-bottom: 16px; font-size: 15px;">
                            <i class="fas fa-lock me-2"></i>Security
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-user me-1" style="color: #94a3b8; font-size: 12px;"></i>Username *
                                </label>
                                <input type="text" class="form-control" name="username" required
                                       style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;"
                                       placeholder="username">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-key me-1" style="color: #94a3b8; font-size: 12px;"></i>New Password *
                                </label>
                                <input type="password" class="form-control" name="password" required
                                       style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;"
                                       placeholder="Enter password">
                                <small class="text-muted" style="font-size: 11px;">
                                    Minimum 8 characters
                                </small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #1e293b; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-toggle-on me-1" style="color: #94a3b8; font-size: 12px;"></i>Account Status *
                                </label>
                                <select class="form-select" name="is_active" required
                                        style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; font-size: 14px;">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer" style="padding: 16px 30px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 6px; padding: 10px 24px; font-weight: 600; font-size: 14px; border: 1px solid #cbd5e1; background: white; color: #475569;">
                        <i class="fas fa-times me-1"></i>Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus me-1 text-white"></i>Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("#UsersTable tbody");
    const rows = Array.from(table.querySelectorAll("tr"));
    const searchInput = document.getElementById("searchInput");
    const pageSizeSelect = document.getElementById("pageSizeSelect");
    const paginationContainer = document.getElementById("pagination");

    let currentPage = 1;
    let rowsPerPage = 10;

    function renderTable() {
        table.innerHTML = "";

        // Filter rows based on search
        let filteredRows = rows.filter(row =>
            row.textContent.toLowerCase().includes(searchInput.value.toLowerCase())
        );

        // Calculate pagination
        let totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        currentPage = Math.min(currentPage, totalPages) || 1;

        // Display rows for current page
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        filteredRows.slice(start, end).forEach(row => table.appendChild(row));

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationContainer.innerHTML = "";

        // Previous button
        let prevBtn = document.createElement("button");
        prevBtn.textContent = "‹";
        prevBtn.disabled = currentPage === 1;
        prevBtn.classList.toggle("disabled", currentPage === 1);
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        };
        paginationContainer.appendChild(prevBtn);

        // Page number buttons
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        // Show first page if not in range
        if (startPage > 1) {
            let firstBtn = createPageButton(1);
            paginationContainer.appendChild(firstBtn);

            if (startPage > 2) {
                let dots = document.createElement("button");
                dots.textContent = "...";
                dots.classList.add("disabled");
                dots.disabled = true;
                paginationContainer.appendChild(dots);
            }
        }

        // Page number buttons in range
        for (let i = startPage; i <= endPage; i++) {
            let pageBtn = createPageButton(i);
            paginationContainer.appendChild(pageBtn);
        }

        // Show last page if not in range
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                let dots = document.createElement("button");
                dots.textContent = "...";
                dots.classList.add("disabled");
                dots.disabled = true;
                paginationContainer.appendChild(dots);
            }

            let lastBtn = createPageButton(totalPages);
            paginationContainer.appendChild(lastBtn);
        }

        // Next button
        let nextBtn = document.createElement("button");
        nextBtn.textContent = "›";
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.classList.toggle("disabled", currentPage === totalPages);
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        };
        paginationContainer.appendChild(nextBtn);
    }

    function createPageButton(pageNum) {
        let btn = document.createElement("button");
        btn.textContent = pageNum;
        btn.classList.toggle("active", pageNum === currentPage);
        btn.onclick = () => {
            currentPage = pageNum;
            renderTable();
        };
        return btn;
    }

    // Event listeners
    searchInput.addEventListener("input", () => {
        currentPage = 1;
        renderTable();
    });

    pageSizeSelect.addEventListener("change", () => {
        rowsPerPage = parseInt(pageSizeSelect.value);
        currentPage = 1;
        renderTable();
    });

    // Initial render
    renderTable();
});
</script>

@endsection
