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
               List of Resource Speaker
            </div>
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fa-solid fa-circle-plus"></i> Create
            </button> --}}
            <a href="{{ route('resource_speaker.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus"></i> Create
            </a>
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
                            <th>Gender</th>
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
                                    <td>{{ $speaker->gender}}</td>
                                    <td>{{ $speaker->home_address}}</td>
                                    <td>
                                        {{ optional($speaker->expertises)->pluck('expertis')->implode(', ') ?? 'N/A' }}
                                    </td>

                                    <td class="row">
                                        <!-- Button trigger modal for Edit -->
                                        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSpeakerModal" onclick="editSpeaker({{ $speaker->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button> --}}

                                        <a href="{{ route('resource_speaker.view', $speaker->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>

                                            <!-- Button to redirect to Edit page -->
                                            <a href="{{ route('resource_speaker.edit', $speaker->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('resource_speaker.destroy', $speaker->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn"
                                                data-name="{{ $speaker->last_name }} {{ $speaker->given_name }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                       <button type="button" class="btn btn-sm btn-info" onclick="loadPDF({{ $speaker->id }})" data-bs-toggle="modal" data-bs-target="#pdfModal-{{ $speaker->id }}">
                                                <i class="fa-solid fa-print"></i>
                                            </button>

                                                      <!-- Modal for displaying PDF -->
                            <div class="modal fade" id="pdfModal-{{ $speaker->id }}" tabindex="-1" aria-labelledby="pdfModalLabel-{{ $speaker->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pdfModalLabel-{{ $speaker->id }}">
                                                 PDF - {{ $speaker->last_name }} {{ $speaker->given_name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <div id="pdfLoader-{{ $speaker->id }}" class="text-center p-4">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <p class="mt-2">Loading PDF...</p>
                                            </div>
                                            <iframe id="pdfFrame-{{ $speaker->id }}" src="" style="width:100%; height:80vh; display:none;" frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        <!-- Button trigger modal for Delete -->
                                        {{-- <button type="button" class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-id="{{ $speaker->id }}"
                                        data-name="{{ $speaker->given_name }} {{ $speaker->last_name }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button> --}}
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
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="experience-trainer-tab" data-bs-toggle="tab" data-bs-target="#experience-trainer" type="button" role="tab">Expertise</button>
                        </li> --}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="publications-tab" data-bs-toggle="tab" data-bs-target="#publications" type="button" role="tab">Publications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="references-tab" data-bs-toggle="tab" data-bs-target="#references" type="button" role="tab">References</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    {{-- <form action="{{ route('resource_speaker.store') }}" method="POST"> --}}
                        @csrf
                        <div class="tab-content mt-3">
                            <!-- Personal Info Tab (Rstbl) -->
                            <div class="tab-pane fade show active" id="personal" role="tabpanel">

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="given_name" class="form-label">Given Name</label>
                                        <input type="text" class="form-control" id="given_name" name="given_name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name" required>
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
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    {{-- <div class="col-md-3">
                                        <label for="expertise" class="form-label">Expertise</label>
                                        <input type="text" class="form-control" id="expertise" name="expertise">
                                    </div> --}}
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
                                <div id="education-container">
                                    <!-- Education entry template -->
                                    <div class="education-entry">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Level</label>
                                                <input type="text" class="form-control" name="level[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">From</label>
                                                <input type="text" class="form-control" name="from_year[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">To</label>
                                                <input type="text" class="form-control" name="to_year[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">School</label>
                                                <input type="text" class="form-control" name="school[]">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Year Graduated</label>
                                                <input type="text" class="form-control" name="year_graduated[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Awards</label>
                                                <input type="text" class="form-control" name="awards[]">
                                            </div>
                                            <div class="col-md-3">
                                        <br>
                                                <button type="button" class="btn btn-danger remove-entry">
                                                    <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="addMoreEducation" class="btn btn-primary">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </button>
                                </div>

                            </div>



                            <!-- Work Experience Tab (RsWorkExperience) -->
                            <div class="tab-pane fade" id="work" role="tabpanel">
                                <div id="work-experience-container">
                                    <div class="work-experience-entry">
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
                                    <div class="col-md-3">
                                        <br>
                                        <button type="button" class="btn btn-danger remove-entry">
                                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="addMoreWorkExperience" class="btn btn-primary">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </button>
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
                                                        <div id="training-container">
                                                            <div class="training-entry">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Training Title</label>
                                                                        <input type="text" class="form-control" name="rst_title[]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Venue</label>
                                                                        <input type="text" class="form-control" name="rst_venue[]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Date</label>
                                                                        <input type="date" class="form-control" name="rst_date[]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">No. of Hours</label>
                                                                        <input type="number" class="form-control" name="rst_no_hours[]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <br>
                                                                        <button type="button" class="btn btn-danger remove-training">
                                                                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                  </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" id="addMoreTraining" class="btn btn-primary">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Publications Tab (RsPublications) -->
                                                    <div class="tab-pane fade" id="publications" role="tabpanel">
                                                        <div id="publications-container">
                                                            <div class="publication-entry">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Publication Title</label>
                                                                        <input type="text" class="form-control" name="publication_title[]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Nature</label>
                                                                        <input type="text" class="form-control" name="p_nature[]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Date</label>
                                                                        <input type="date" class="form-control" name="p_date[]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Venue</label>
                                                                        <input type="text" class="form-control" name="p_venue[]">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <br>
                                                                        <button type="button" class="btn btn-danger remove-publication">
                                                                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" id="addMorePublication" class="btn btn-primary">
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </button>
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
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="speakerName"></strong>?
            </div>
            <div class="modal-footer bg-warning">
                <form id="deleteSpeakerForm" method="POST" "{{ route('resource_speaker.destroy', $speaker->id) }}">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ===== Delete Modal (Vanilla JS)
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const speakerId = button.getAttribute('data-id');
            const speakerName = button.getAttribute('data-name');

            document.getElementById('speakerName').textContent = speakerName;
            document.getElementById('deleteSpeakerForm').action = `/resource_speaker/${speakerId}`;
        });
    }

    // ===== Success alert hide
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.display = 'none';
        }, 5000);
    }

    // ===== Repeater Functions (Generic Clone + Clear)
    function setupRepeater(addBtnId, containerId, entryClass) {
        const addBtn = document.getElementById(addBtnId);
        if (!addBtn) return;
        addBtn.addEventListener('click', function () {
            const container = document.getElementById(containerId);
            const template = container.querySelector(`.${entryClass}`);
            if (!template) return;
            const newEntry = template.cloneNode(true);
            newEntry.querySelectorAll('input').forEach(input => input.value = '');
            container.appendChild(newEntry);
        });
    }

    function setupRemove(containerId, entryClass, removeClass) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.addEventListener('click', function (e) {
            if (e.target.classList.contains(removeClass)) {
                e.target.closest(`.${entryClass}`).remove();
            }
        });
    }

    setupRepeater("addMoreEducation", "education-container", "education-entry");
    setupRepeater("addMoreWorkExperience", "work-experience-container", "work-experience-entry");
    setupRepeater("addMoreTraining", "training-container", "training-entry");
    setupRepeater("addMoreTrainer", "trainer-container", "trainer-entry");
    setupRepeater("addMorePublication", "publications-container", "publication-entry");

    setupRemove("education-container", "education-entry", "remove-entry");
    setupRemove("work-experience-container", "work-experience-entry", "remove-entry");
    setupRemove("training-container", "training-entry", "remove-training");
    setupRemove("trainer-container", "trainer-entry", "remove-trainer");
    setupRemove("publications-container", "publication-entry", "remove-publication");
});

// ===== AJAX Submit for Edit Form
$('#editUserForm').on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(response) {
            $('#editUserModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            if (xhr.status === 422) {
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

// ===== PDF Load with Spinner
function loadPDF(trainerId) {
    const loader = document.getElementById('pdfLoader-' + trainerId);
    const iframe = document.getElementById('pdfFrame-' + trainerId);
    loader.style.display = 'block';
    iframe.style.display = 'none';
    iframe.src = "{{ route('resource_speaker.print', '') }}/" + trainerId;

    iframe.onload = function () {
        loader.style.display = 'none';
        iframe.style.display = 'block';
    };
}
</script>
@endsection
