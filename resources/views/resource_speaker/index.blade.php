@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4">
    {{-- <h1 class="mt-4">Tables</h1> --}}
    {{-- <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Tables</li>
    </ol> --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    window.onload = function() {
        $(document).ready(function() {
            let editValue = @json(session('create'));

            if (editValue) {
                // Show alert
                let alertMessage = "Record successfully created!";
                let alertBox = `
                    <div id="custom-alert" class="alert alert-success" role="alert">
                        ${alertMessage}
                    </div>`;
                $('body').append(alertBox); // Add alert to the body

                // Automatically remove the alert after 5 seconds
                setTimeout(function() {
                    $('#custom-alert').fadeOut('slow', function() {
                        $(this).remove(); // Remove alert element after fading out
                    });
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    }

window.onload = function() {
        $(document).ready(function() {
            let editValue = @json(session('edit'));

            if (editValue) {
                // Show alert
                let alertMessage = "Record successfully updated!";
                let alertBox = `
                    <div id="custom-alert" class="alert alert-primary" role="alert">
                        ${alertMessage}
                    </div>`;
                $('body').append(alertBox); // Add alert to the body

                // Automatically remove the alert after 5 seconds
                setTimeout(function() {
                    $('#custom-alert').fadeOut('slow', function() {
                        $(this).remove(); // Remove alert element after fading out
                    });
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    }

    window.onload = function() {
        $(document).ready(function() {
            let editValue = @json(session('delete'));

            if (editValue) {
                // Show alert
                let alertMessage = "Record successfully deleted!";
                let alertBox = `
                    <div id="custom-alert" class="alert alert-danger" role="alert">
                        ${alertMessage}
                    </div>`;
                $('body').append(alertBox); // Add alert to the body

                // Automatically remove the alert after 5 seconds
                setTimeout(function() {
                    $('#custom-alert').fadeOut('slow', function() {
                        $(this).remove(); // Remove alert element after fading out
                    });
                }, 5000); // 5000 milliseconds = 5 seconds
            }
        });
    }

</script>

<style>
    #custom-alert {
        position: fixed;
        top: 20px; /* Distance from the top */
        right: 20px; /* Distance from the right */
        z-index: 1050; /* Ensure it's above other elements */
        min-width: 250px; /* Minimum width of the alert */
        padding: 15px; /* Add some padding */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional shadow */
    }
</style>




    <div class="card mb-4 mt-3">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <div class="col-md-6" style="color: white">
                <i class="fas fa-table me-1"></i>
                Resource Speaker
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fa-solid fa-circle-plus"></i> Create
            </button>
            {{-- <a href="{{ route('resource_speaker.create') }}" type="button" class="btn btn-primary" >
                <i class="fa-solid fa-user-plus"></i> Create
            </a> --}}
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Expertise</th>
                            <th>Age</th>
                            <th>Home Address</th>
                            <th>Expertise</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($speakers) && $speakers->isNotEmpty())
                            @foreach ($speakers as $speaker)
                                <tr>
                                    <td>{{ $speaker->last_name }} {{ $speaker->given_name }}</td>
                                    <td>{{ $speaker->email}}</td>
                                    <td>{{ $speaker->expertise}}</td>
                                    <td>{{ $speaker->age}}</td>
                                    <td>{{ $speaker->home_address}}</td>
                                    <td>{{ $speaker->expertise}}</td>
                                    <td>
                                        <!-- Button trigger modal for Edit -->
                                        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSpeakerModal" onclick="editSpeaker({{ $speaker->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button> --}}

                                            <!-- Button to redirect to Edit page -->
                                            <a href="{{ route('resource_speaker.edit', $speaker->id) }}" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                        <!-- Button trigger modal for Delete -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $speaker->id }}" data-name="{{ $speaker->given_name }} {{ $speaker->last_name }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">No speakers found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
        </div>
        <div class="card-footer bg-success"></div>

    </div>
</div>



{{-- <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true"> --}}
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <!-- Extra large modal -->
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="addDataModalLabel">Add Information</h5>
                    <a href="{{url('/rstbl')}}" type="button" class="btn-close" aria-label="Close"></a>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="dataTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">Personal Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab">Education</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="work-tab" data-bs-toggle="tab" data-bs-target="#work" type="button" role="tab">Work Experience</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="office-tab" data-bs-toggle="tab" data-bs-target="#office" type="button" role="tab">Office</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="training-tab" data-bs-toggle="tab" data-bs-target="#training" type="button" role="tab">Training</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="experience-trainer-tab" data-bs-toggle="tab" data-bs-target="#experience-trainer" type="button" role="tab">Experience as Trainer</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="publications-tab" data-bs-toggle="tab" data-bs-target="#publications" type="button" role="tab">Publications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="references-tab" data-bs-toggle="tab" data-bs-target="#references" type="button" role="tab">References</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <form action="{{ route('resource_speaker.store') }}" method="POST">
                        @csrf
                        <div class="tab-content mt-3">
                            <!-- Personal Info Tab (Rstbl) -->
                            <div class="tab-pane fade show active" id="personal" role="tabpanel">

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" >
                                    </div>
                                    <div class="col-md-3">
                                        <label for="given_name" class="form-label">Given Name</label>
                                        <input type="text" class="form-control" id="given_name" name="given_name" >
                                    </div>
                                    <div class="col-md-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ext_name" class="form-label">Extension Name</label>
                                        <input type="text" class="form-control" id="ext_name" name="ext_name">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="age" class="form-label">Age</label>
                                        <input type="number" class="form-control" id="age" name="age">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" >
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="expertise" class="form-label">Expertise</label>
                                        <input type="text" class="form-control" id="expertise" name="expertise">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_address" class="form-label">Home Address</label>
                                        <input type="text" class="form-control" id="home_address" name="home_address">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_building_no" class="form-label">Building No</label>
                                        <input type="text" class="form-control" id="home_building_no" name="home_building_no">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_barangay" class="form-label">Barangay</label>
                                        <input type="text" class="form-control" id="home_barangay" name="home_barangay">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="home_municipality" class="form-label">Municipality</label>
                                        <input type="text" class="form-control" id="home_municipality" name="home_municipality">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_province" class="form-label">Province</label>
                                        <input type="text" class="form-control" id="home_province" name="home_province">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_zip_code" class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" id="home_zip_code" name="home_zip_code">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_tel_no" class="form-label">Telephone No</label>
                                        <input type="text" class="form-control" id="home_tel_no" name="home_tel_no">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="home_cell_no" class="form-label">Cellphone No</label>
                                        <input type="text" class="form-control" id="home_cell_no" name="home_cell_no">
                                    </div>
                              </div>

                            </div>

                            <!-- Education Tab (RsEducational) -->
                            <div class="tab-pane fade" id="education" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="level" class="form-label">Level</label>
                                        <input type="text" class="form-control" id="level" name="level">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="from" class="form-label">From</label>
                                        <input type="text" class="form-control" id="from" name="from_year">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="to" class="form-label">To</label>
                                        <input type="text" class="form-control" id="to" name="to_year">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="school" class="form-label">School</label>
                                        <input type="text" class="form-control" id="school" name="school">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="year_graduated" class="form-label">Year Graduated</label>
                                        <input type="text" class="form-control" id="year_graduated" name="year_graduated">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="awards" class="form-label">Awards</label>
                                        <input type="text" class="form-control" id="awards" name="awards">
                                    </div>
                                </div>

                            </div>

                            <!-- Work Experience Tab (RsWorkExperience) -->
                            <div class="tab-pane fade" id="work" role="tabpanel">

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="name_company" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="name_company" name="name_company">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_started" class="form-label">Date Started</label>
                                        <input type="date" class="form-control" id="date_started" name="date_started">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_ended" class="form-label">Date Ended</label>
                                        <input type="date" class="form-control" id="date_ended" name="date_ended">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="position" name="position">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="address" class="form-label">Company Address</label>
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="division" class="form-label">Division</label>
                                        <input type="text" class="form-control" id="division" name="division">
                                    </div>
                                </div>

                            </div>

                                                    <!-- Office Tab (RsOffice) -->
                                                    <div class="tab-pane fade" id="office" role="tabpanel">

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="office_organization" class="form-label">Office Organization</label>
                                                                <input type="text" class="form-control" id="office_organization" name="office_organization">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="position" class="form-label">Position</label>
                                                                <input type="text" class="form-control" id="position" name="position">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="address" class="form-label">Office Address</label>
                                                                <input type="text" class="form-control" id="address" name="address">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="building_no" class="form-label">Building No</label>
                                                                <input type="text" class="form-control" id="building_no" name="building_no">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="barangay" class="form-label">Barangay</label>
                                                                <input type="text" class="form-control" id="barangay" name="barangay">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="municipality" class="form-label">Municipality</label>
                                                                <input type="text" class="form-control" id="municipality" name="municipality">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="province" class="form-label">Province</label>
                                                                <input type="text" class="form-control" id="province" name="province">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="zip_code" class="form-label">Zip Code</label>
                                                                <input type="text" class="form-control" id="zip_code" name="zip_code">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="tel_no" class="form-label">Telephone No</label>
                                                                <input type="text" class="form-control" id="tel_no" name="tel_no">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="cell_no" class="form-label">Cellphone No</label>
                                                                <input type="text" class="form-control" id="cell_no" name="cell_no">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="fax_no" class="form-label">Fax No</label>
                                                                <input type="text" class="form-control" id="fax_no" name="fax_no">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- Training Tab (RsTraining) -->
                                                    <div class="tab-pane fade" id="training" role="tabpanel">

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="title" class="form-label">Training Title</label>
                                                                <input type="text" class="form-control" id="title" name="title">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="date_venue" class="form-label">Date/Venue</label>
                                                                <input type="text" class="form-control" id="date_venue" name="date_venue">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="no_hours" class="form-label">No. of Hours</label>
                                                                <input type="number" class="form-control" id="no_hours" name="no_hours">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- Experience as Trainer Tab (RsTrainerExperience) -->
                                                    <div class="tab-pane fade" id="experience-trainer" role="tabpanel">

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="title" class="form-label">Trainer Title</label>
                                                                <input type="text" class="form-control" id="title" name="title">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="date_venue" class="form-label">Date/Venue</label>
                                                                <input type="text" class="form-control" id="date_venue" name="date_venue">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="no_hours" class="form-label">No. of Hours</label>
                                                                <input type="number" class="form-control" id="no_hours" name="no_hours">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- Publications Tab (RsPublications) -->
                                                    <div class="tab-pane fade" id="publications" role="tabpanel">

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="title" class="form-label">Publication Title</label>
                                                                <input type="text" class="form-control" id="title" name="title">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="nature" class="form-label">Nature</label>
                                                                <input type="text" class="form-control" id="nature" name="nature">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="date_venue" class="form-label">Date/Venue</label>
                                                                <input type="text" class="form-control" id="date_venue" name="date_venue">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- References Tab (RsReferences) -->
                                                    <div class="tab-pane fade" id="references" role="tabpanel">

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="name_agency" class="form-label">Agency Name</label>
                                                                <input type="text" class="form-control" id="name_agency" name="name_agency">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="address" class="form-label">Address</label>
                                                                <input type="text" class="form-control" id="address" name="address">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="contact_person" class="form-label">Contact Person</label>
                                                                <input type="text" class="form-control" id="contact_person" name="contact_person">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="position" class="form-label">Position</label>
                                                                <input type="text" class="form-control" id="position" name="position">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="tel_no" class="form-label">Telephone No</label>
                                                                <input type="text" class="form-control" id="tel_no" name="tel_no">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="cell_no" class="form-label">Cellphone No</label>
                                                                <input type="text" class="form-control" id="cell_no" name="cell_no">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="fax_no" class="form-label">Fax No</label>
                                                                <input type="text" class="form-control" id="fax_no" name="fax_no">
                                                            </div>
                                                        </div>
                                                    </div>
                        </div>

                </div>
                <div class="modal-footer bg-success">
                    <a href="{{url('/rstbl')}}" type="button" class="btn btn-secondary">Close</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="deleteModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to delete <strong id="speakerName"></strong>?</h5>
            </div>
            <div class="modal-footer bg-warning">
                <form action="{{ route('resource_speaker.destroy', $speaker->id) }}" method="POST">

                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const id = button.getAttribute('data-id'); // Extract info from data-* attributes
        const name = button.getAttribute('data-name');

        // Update the modal content
        const speakerName = deleteModal.querySelector('#speakerName');
        speakerName.textContent = last_name;

        const deleteForm = deleteModal.querySelector('#deleteForm');
        deleteForm.action = '/resource_speaker/' + id; // Update the form action
    });



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

