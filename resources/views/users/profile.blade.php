@extends('layouts.admin')

@section('content')

<style>
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
}

.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 40px;
    margin-bottom: 30px;
    color: white;
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    top: -100px;
    right: -100px;
}

.profile-avatar-container {
    display: flex;
    align-items: center;
    gap: 30px;
    position: relative;
    z-index: 1;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: #667eea;
    border: 5px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.profile-info h1 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 8px;
}

.profile-info p {
    font-size: 16px;
    opacity: 0.9;
    margin-bottom: 4px;
}

.profile-badge {
    display: inline-block;
    padding: 6px 16px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    margin-top: 12px;
}

.profile-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 30px;
}

.profile-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.profile-card h3 {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.profile-card h3 i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 16px 0;
    border-bottom: 1px solid #f1f5f9;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 14px;
    color: #64748b;
    font-weight: 600;
}

.info-value {
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
    text-align: right;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.action-buttons {
    display: flex;
    gap: 12px;
    margin-top: 30px;
}

.btn-profile {
    flex: 1;
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-edit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.btn-password {
    background: #f1f5f9;
    color: #475569;
}

.btn-password:hover {
    background: #e2e8f0;
}

/* Activity Timeline */
.activity-timeline {
    position: relative;
    padding-left: 40px;
}

.activity-item {
    position: relative;
    padding-bottom: 30px;
}

.activity-item::before {
    content: '';
    position: absolute;
    left: -31px;
    top: 8px;
    width: 2px;
    height: calc(100% - 8px);
    background: #e2e8f0;
}

.activity-item:last-child::before {
    display: none;
}

.activity-icon {
    position: absolute;
    left: -40px;
    top: 0;
    width: 20px;
    height: 20px;
    background: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 10px;
}

.activity-content h5 {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 4px;
}

.activity-content p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}

.activity-time {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 4px;
}

@media (max-width: 968px) {
    .profile-content {
        grid-template-columns: 1fr;
    }

    .profile-avatar-container {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<div class="profile-container">
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

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-avatar-container">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h1>{{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</h1>
                <p><i class="fas fa-briefcase me-2"></i>{{ optional($user->position)->position ?? 'No Position' }}</p>
                <p><i class="fas fa-building me-2"></i>{{ optional($user->divisionUnit)->division_unit ?? 'No Division' }}</p>
                <span class="profile-badge">
                    <i class="fas fa-shield-alt me-1"></i>{{ $user->roles ?? 'No Role' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="profile-content">
        <!-- Personal Information -->
        <div class="profile-card">
            <h3>
                <i class="fas fa-user-circle"></i>
                Personal Information
            </h3>
            <div class="info-row">
                <span class="info-label">Employee ID</span>
                <span class="info-value">{{ $user->emp_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Full Name</span>
                <span class="info-value">{{ $user->firstname }} {{ $user->middlename }} {{ $user->lastname }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Gender</span>
                <span class="info-value">{{ $user->gender ?? 'Not specified' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Username</span>
                <span class="info-value">{{ $user->username }}</span>
            </div>
        </div>

        <!-- Work Information -->
        <div class="profile-card">
            <h3>
                <i class="fas fa-briefcase"></i>
                Work Information
            </h3>
            <div class="info-row">
                <span class="info-label">Position</span>
                <span class="info-value">{{ optional($user->position)->position ?? 'Not assigned' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Division/Unit</span>
                <span class="info-value">{{ optional($user->divisionUnit)->division_unit ?? 'Not assigned' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Employee Type</span>
                <span class="info-value">{{ $user->emp_type ?? 'Not specified' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Role</span>
                <span class="info-value">{{ $user->roles ?? 'Not assigned' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Account Status</span>
                <span class="info-value">
                    @if($user->is_active)
                        <span class="status-badge status-active">Active</span>
                    @else
                        <span class="status-badge status-inactive">Inactive</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="profile-card">
        <h3>
            <i class="fas fa-clock"></i>
            Activity Timeline
        </h3>
        <div class="activity-timeline">
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="activity-content">
                    <h5>Account Created</h5>
                    <p>Your account was successfully created</p>
                    <div class="activity-time">
                        <i class="far fa-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($user->created_at)->format('F d, Y \a\t h:i A') }}
                    </div>
                </div>
            </div>

            @if($user->last_login)
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <div class="activity-content">
                    <h5>Last Login</h5>
                    <p>You logged into the system</p>
                    <div class="activity-time">
                        <i class="far fa-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($user->last_login)->format('F d, Y \a\t h:i A') }}
                        ({{ \Carbon\Carbon::parse($user->last_login)->diffForHumans() }})
                    </div>
                </div>
            </div>
            @endif

            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="activity-content">
                    <h5>Profile Updated</h5>
                    <p>Your profile information was last updated</p>
                    <div class="activity-time">
                        <i class="far fa-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($user->updated_at)->format('F d, Y \a\t h:i A') }}
                        ({{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }})
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button type="button" class="btn-profile btn-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="fas fa-edit"></i>
            Edit Profile
        </button>
        <button type="button" class="btn-profile btn-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            <i class="fas fa-key"></i>
            Change Password
        </button>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('users.updateProfile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-id-card me-1"></i>Employee ID *</label>
                            <input type="text" class="form-control" name="emp_id" value="{{ $user->emp_id }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-user me-1"></i>Username *</label>
                            <input type="text" class="form-control" name="username" value="{{ $user->username }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">First Name *</label>
                            <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middlename" value="{{ $user->middlename }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Last Name *</label>
                            <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-envelope me-1"></i>Email *</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-venus-mars me-1"></i>Gender</label>
                            <select class="form-select" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.changePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i>Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Password *</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password *</label>
                        <input type="password" class="form-control" name="new_password" required>
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password *</label>
                        <input type="password" class="form-control" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-lock me-1"></i>Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
