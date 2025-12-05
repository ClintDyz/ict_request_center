
   <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-4">
            <div class="container-fluid p-0">
                    <button id="toggleSidebar" class="btn btn-outline-secondary me-3">
                        <i class="fa fa-bars"></i>
                    </button>


                {{-- <form class="d-none d-md-inline-block me-auto">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
                    </div>
                </form> --}}

                <ul class="navbar-nav ms-auto align-items-center">
                    {{-- <li class="nav-item me-3">
                        <a class="nav-link" href="#"><i class="fa fa-home"></i> Website</a>
                    </li> --}}

                    {{-- <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fa fa-comment me-2"></i> New Comment <span class="text-muted small float-end">4m</span></a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-twitter me-2"></i> 3 New Followers <span class="text-muted small float-end">12m</span></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="#"><strong>See All Alerts</strong></a></li>
                        </ul>
                    </li> --}}

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i> {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('users.profile') }}">
                                    <i class="fa fa-user me-2"></i> Profile
                                </a>
                            </li>

                            {{--<li><a class="dropdown-item" href="#"><i class="fa fa-gear me-2"></i> Settings</a></li> --}}
                            <li><hr class="dropdown-divider"></li>

                            <li>
                                    <form action="{{ url('/logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="fa fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>


                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- PROFILE UPDATE MODAL -->
<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('users.update', auth()->user()->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Update Profile - {{ auth()->user()->username }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee ID *</label>
                            <input type="text" class="form-control" name="emp_id"
                                   value="{{ auth()->user()->emp_id }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">First Name *</label>
                            <input type="text" class="form-control" name="firstname"
                                   value="{{ auth()->user()->firstname }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middlename"
                                   value="{{ auth()->user()->middlename }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Last Name *</label>
                            <input type="text" class="form-control" name="lastname"
                                   value="{{ auth()->user()->lastname }}" required>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email"
                                   value="{{ auth()->user()->email }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ auth()->user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ auth()->user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position</label>
                            <select class="form-select" name="id_position">
                                <option value="">Select Position</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}"
                                        {{ auth()->user()->id_position == $position->id ? 'selected' : '' }}>
                                        {{ $position->position }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Division/Unit</label>
                            <select class="form-select" name="id_division_unit">
                                <option value="">Select Division/Unit</option>
                                @foreach($division_units as $division_unit)
                                    <option value="{{ $division_unit->id }}"
                                        {{ auth()->user()->id_division_unit == $division_unit->id ? 'selected' : '' }}>
                                        {{ $division_unit->division_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee Type</label>
                            <select class="form-select" name="emp_type">
                                <option value="">Select Type</option>
                                <option value="Contractual"
                                    {{ auth()->user()->emp_type == 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                <option value="Permanent"
                                    {{ auth()->user()->emp_type == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="roles">
                                <option value="">Select Role</option>
                                <option value="Admin" {{ auth()->user()->roles == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="User" {{ auth()->user()->roles == 'User' ? 'selected' : '' }}>User</option>
                                <option value="Manager" {{ auth()->user()->roles == 'Manager' ? 'selected' : '' }}>Manager</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username *</label>
                            <input type="text" class="form-control" name="username"
                                   value="{{ auth()->user()->username }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">New Password (optional)</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter new password">
                            <small class="text-muted">Leave blank to keep current password</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="is_active">
                                <option value="1" {{ auth()->user()->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !auth()->user()->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update Profile</button>
                </div>

            </form>

        </div>
    </div>
</div>
