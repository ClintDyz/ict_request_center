@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    @if ($message = Session::get('success'))
    <div class="alert alert-success" id="success-alert">
        {{ $message }}
    </div>
    @endif

    <div class="card mb-4 mt-4">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <div class="col-md-6" style="color: white">
                <i class="fas fa-table me-1"></i>
                Users
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fa-solid fa-circle-plus"></i> Create
            </button>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Division</th>
                        <th>Unit</th>
                        <th>Province</th>
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->emp_id }}</td>
                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td>{{ $user->division }}</td>
                            <td>{{ $user->unit }}</td>
                            <td>{{ $user->province }}</td>
                            <td>{{ $user->position }}</td>
                            <td >
                                <!-- Edit button for User -->
                                <button class="btn btn-primary" onclick="editUser({{ $user->id }})">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- Delete button for User -->
                                <button class="btn btn-danger" onclick="deleteUser({{ $user->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-success"></div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emp_id" class="form-label">Employee ID</label>
                                <input type="text" class="form-control" id="emp_id" name="emp_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>
                            <div class="mb-3">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middlename" name="middlename">
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                            <option> <--Select Gender--> </option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            </select>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                                <div class="mb-3">
                                <label for="mobile_no" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no">
                           </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <?php
                            $divisions = App\Models\Division::select('id', 'division')->distinct()->get(); // Assuming the Unit model has 'id' and 'unit_name' fields
                            ?>
                            <div class="mb-3">
                                <label for="division" class="form-label">Division</label>
                                <select name="division" class="form-control" id="division">
                                    <option value=""></option> <!-- Default empty option -->
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->division }}">{{ $division->division }}</option> <!-- Assuming 'division_name' is the column -->
                                    @endforeach
                                </select>
                            </div>

                            <?php
                            $units = App\Models\Unit::select('id', 'unit')->distinct()->get(); // Assuming the Unit model has 'id' and 'unit_name' fields
                            ?>
                            <div class="mb-3">
                                <label for="unit" class="form-label">Unit</label>
                                <select name="unit" class="form-control" id="unit">
                                    <option value=""></option> <!-- Default empty option -->
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->unit }}">{{ $unit->unit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <?php
                            $positions = App\Models\Position::select('id', 'position')->distinct()->get(); // Assuming the Unit model has 'id' and 'unit_name' fields
                            ?>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <select name="position" class="form-control" id="position">
                                    <option value=""></option> <!-- Default empty option -->
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->position }}">{{ $position->position }}</option> <!-- Assuming 'position_name' is the column -->
                                    @endforeach
                                </select>
                            </div>

                            <?php
                            $province = App\Models\Province::select('id', 'province')->distinct()->get(); // Assuming the Unit model has 'id' and 'unit_name' fields
                            ?>
                            <div class="mb-3">
                                <label for="province" class="form-label">Province</label>
                                <select name="province" class="form-control" id="province">
                                    <option value=""></option> <!-- Default empty option -->
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->province }}">{{ $province->province }}</option> <!-- Assuming 'province_name' is the column -->
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="region" class="form-label">Region</label>
                                <input type="text" class="form-control" id="region" name="region">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="emp_type" class="form-label">Access Level</label>
                                <select name="emp_type" class="form-control" id="emp_type">
                                    <option>--Select--</option> <!-- Default empty option -->
                                        <option value="0">Administrator</option> <!-- Assuming 'province_name' is the column -->
                                        <option value="1">Accreditor</option> <!-- Assuming 'province_name' is the column -->
                                        <option value="2">Employee</option> <!-- Assuming 'province_name' is the column -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{ route('users.update', 'placeholder') }}" id="editUserForm">
                @csrf
                @method('PUT')
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="mb-3">
                        <label for="emp_id" class="form-label">Employee ID</label>
                        <input type="text" class="form-control" id="editEmpId" name="emp_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstname" name="firstname" required>
                    </div>
                            <div class="mb-3">
                                <label for="middlename" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middlename" name="middlename" required>
                            </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastname" name="lastname" required>
                    </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                            <option> <--Select Gender--> </option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            </select>
                            </div>
                             <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                             <div class="mb-3">
                                <label for="mobile_no" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no">
                           </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editusername" name="username" required>
                    </div>
                    <div class="mb-3">
                        {{-- <label for="roles" class="form-label">Roles</label> --}}
                        {{-- <input type="text" class="form-control" id="editRoles" name="roles" required> --}}
                <label for="emp_type" class="form-label">Access Level</label>
                <select name="emp_type" class="form-control" id="emp_type" required>
                    <option disabled {{ old('emp_type', $user->emp_type ?? '') === null ? 'selected' : '' }}>--Select--</option>
                    <option value="0" {{ old('emp_type', $user->emp_type ?? '') == 0 ? 'selected' : '' }}>Administrator</option>
                    <option value="1" {{ old('emp_type', $user->emp_type ?? '') == 1 ? 'selected' : '' }}>Accreditor</option>
                    <option value="2" {{ old('emp_type', $user->emp_type ?? '') == 2 ? 'selected' : '' }}>Employee</option>
                </select>

                    </div>
                  </div>

                  <div class="col-md-6">

                        <?php
                        $divisions = App\Models\Division::select('id', 'division')->distinct()->get();
                        ?>
                        <div class="mb-3">
                            <label for="division" class="form-label">Division</label>
                            <select name="division" class="form-control" id="editDivision">
                                <option value="">-- Select Division --</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->division }}" {{ $division->division == $user->division ? 'selected' : '' }}>{{ $division->division }}</option>
                                @endforeach
                            </select>
                        </div>

                        <?php
                        $units = App\Models\Unit::select('id', 'unit')->distinct()->get();
                        ?>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <select name="unit" class="form-control" id="editUnit">
                                <option value=""></option> <!-- Default empty option -->
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->unit }}" {{ $unit->unit == $user->unit ? 'selected' : '' }}>
                                        {{ $unit->unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <?php
                        $positions = App\Models\Position::select('id', 'position')->distinct()->get();
                        ?>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select name="position" class="form-control" id="editPosition">
                                <option value=""></option> <!-- Default empty option -->
                                @foreach ($positions as $position)
                                    <option value="{{ $position->position }}" {{ $position->position == $user->position ? 'selected' : '' }}>
                                        {{ $position->position }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <?php
                        $provinces = App\Models\Province::select('id', 'province')->distinct()->get();
                        ?>
                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <select name="province" class="form-control" id="editProvince">
                                <option value=""></option> <!-- Default empty option -->
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->province }}" {{ $province->province == $user->province ? 'selected' : '' }}>
                                        {{ $province->province }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    <div class="mb-3">
                        <label for="region" class="form-label">Region</label>
                        <input type="text" class="form-control" id="editRegion" name="region" required>
                    </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                                        <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editpassword" name="password" required>
                    </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                  </div>
                </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="deleteUserForm">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer bg-warning">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Show Modal -->
<div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showUserModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong>First Name: </strong> <span id="showFirstname"></span><br>
                <strong>Last Name: </strong> <span id="showLastname"></span><br>
                <strong>Email: </strong> <span id="showEmail"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function editUser(id) {
    $.ajax({
        url: '/users/' + id,
        type: 'GET',
        success: function(data) {
        $('#editUserId').val(data.id);
        $('#editEmpId').val(data.emp_id);
        $('#editFirstname').val(data.firstname);
        $('#middlename').val(data.middlename);
        $('#editLastname').val(data.lastname);
        $('#gender').val(data.gender).trigger('change');
        $('#editEmail').val(data.email);
        $('#mobile_no').val(data.mobile_no);
        $('#editusername').val(data.username);
        $('#emp_type').val(data.emp_type).trigger('change');
        $('#editRegion').val(data.region);
        $('#address').val(data.address);
        $('#editpassword').val('');
        $('#password_confirmation').val('');

        // ✅ Set selected options
        $('#editDivision').val(data.division).trigger('change');
        $('#editUnit').val(data.unit).trigger('change');
        $('#editPosition').val(data.position).trigger('change');
        $('#editProvince').val(data.province).trigger('change');

            // Set form action dynamically
            $('#editUserForm').attr('action', '/users/' + id);
            $('#editUserModal').modal('show');
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Failed to load user data.');
        }
    });
}


// Handle the form submission
$('#editUserForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formData = $(this).serialize(); // Serialize the form data

    $.ajax({
        url: $(this).attr('action'), // Use the action set in the form
        type: 'POST', // Change to POST for Laravel
        data: formData,
        success: function(response) {
            // Handle success (e.g., close the modal and refresh the user list)
            $('#editUserModal').modal('hide');
            location.reload(); // Reload the page or update the UI accordingly
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                // Handle validation errors
                var errors = xhr.responseJSON.errors;
                var errorMessage = 'Validation errors: ';
                for (var field in errors) {
                    errorMessage += errors[field].join(', ') + ' ';
                }
                alert(errorMessage);
            } else {
                console.error('Error updating user:', xhr.responseText);
                alert('An error occurred while updating the user. Please try again.');
            }
        }
    });
});



// Function to set the delete form action and open the modal
function deleteUser(id) {
    $('#deleteUserForm').attr('action', '/users/' + id); // Dynamically set the form action
    $('#deleteUserModal').modal('show');
}

// Handle delete form submission
$('#deleteUserForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    $.ajax({
        url: $(this).attr('action'), // Use the action set in the form
        type: 'DELETE', // Use DELETE method
        data: $(this).serialize(), // Serialize the form data
        success: function(response) {
            // Handle success (e.g., close the modal and reload the page)
            $('#deleteUserModal').modal('hide');
            location.reload(); // Reload the page or update the UI accordingly
        },
        error: function(xhr) {
            console.error('Error deleting user:', xhr.responseText);
            alert('An error occurred while deleting the user. Please try again.');
        }
    });
});


    // Set show modal details
    function showUser(firstname, lastname, email) {
        $('#showFirstname').text(firstname);
        $('#showLastname').text(lastname);
        $('#showEmail').text(email);
        $('#showUserModal').modal('show');
    }

    // Automatically hide the success message after 5 seconds (5000 milliseconds)
    setTimeout(function() {
        document.getElementById('success-alert').style.display = 'none';
    }, 5000); // 5000ms = 5 seconds
</script>
@endsection

