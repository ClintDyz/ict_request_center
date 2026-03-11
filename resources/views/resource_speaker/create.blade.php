@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-1">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

    <!-- Alert for saved data -->
    <div id="autoSaveAlert" class="alert alert-info alert-dismissible fade" role="alert" style="display: none; position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 320px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        <i class="fas fa-save me-2"></i><span id="autoSaveMessage">Form data auto-saved!</span>
        <button type="button" class="btn-close" onclick="closeAutoSaveAlert()"></button>
    </div>

    <div class="card shadow">
<div class="card-header bg-info text-white d-flex justify-content-between align-items-center">

    <div>
        <h4 class="mb-0">Specialist Information</h4>
        <small class="text-light">
            <i class="bi bi-info-circle" style="color: red"> Note: Please fill out all the fields before proceeding.</i>
        </small>
    </div>

    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-warning btn-sm me-2" onclick="clearSavedData()">
            Clear Saved Data
        </button>

        <span class="badge bg-light text-dark" id="lastSavedTime"></span>
    </div>

</div>

        <div class="card-body">
            <form id="resourceSpeakerForm" action="{{ route('resource_speaker.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="accordion" id="accordionExample">

                    <!-- Personal Info Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                Personal Information
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="img" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="img" name="img" accept="image/*">
                                        <small class="text-muted">Note: Image cannot be auto-saved</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="last_name" class="form-label ">Last Name</label>
                                        <input type="text" class="form-control auto-save" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="given_name" class="form-label ">Given Name</label>
                                        <input type="text" class="form-control auto-save" id="given_name" name="given_name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="middle_name" class="form-label ">Middle Name</label>
                                        <input type="text" class="form-control auto-save" id="middle_name" name="middle_name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ext_name" class="form-label">Extension Name</label>
                                        <input type="text" class="form-control auto-save" id="ext_name" name="ext_name">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="date_of_birth" class="form-label ">Date of Birth</label>
                                        <input type="date" class="form-control auto-save" id="date_of_birth" name="date_of_birth" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="place_of_birth" class="form-label ">Place of Birth</label>
                                        <input type="text" class="form-control auto-save" id="place_of_birth" name="place_of_birth" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="age" class="form-label ">Age</label>
                                        <input type="number" class="form-control auto-save" id="age" name="age" min="1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="gender" class="form-label ">Sex</label>
                                        <select class="form-select auto-save" id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="email" class="form-label ">Email</label>
                                        <input type="email" class="form-control auto-save" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_zip_code" class="form-label ">Zip Code </label>
                                        <input type="text" class="form-control auto-save" id="home_zip_code" name="home_zip_code" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_address" class="form-label ">Home Address </label>
                                        <input type="text" class="form-control auto-save" id="home_address" name="home_address">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_building_no" class="form-label ">Building No </label>
                                        <input type="text" class="form-control auto-save" id="home_building_no" name="home_building_no">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="home_barangay" class="form-label ">Barangay </label>
                                        <input type="text" class="form-control auto-save" id="home_barangay" name="home_barangay">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_municipality" class="form-label ">Municipality </label>
                                        <input type="text" class="form-control auto-save" id="home_municipality" name="home_municipality" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_province" class="form-label ">Province </label>
                                        <input type="text" class="form-control auto-save" id="home_province" name="home_province" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_cell_no" class="form-label">Cellphone No</label>
                                        <input type="text" class="form-control auto-save" id="home_cell_no" name="home_cell_no">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="home_tel_no" class="form-label">Telephone No</label>
                                        <input type="text" class="form-control auto-save" id="home_tel_no" name="home_tel_no">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_fax_no" class="form-label">Fax No</label>
                                        <input type="text" class="form-control auto-save" id="home_fax_no" name="home_fax_no">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expertise Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTen">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen">
                                Expertise
                            </button>
                        </h2>
                        <div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="expertise-container">
                                    <div class="expertise-entry row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Expertise</label>
                                            <input type="text" class="form-control auto-save-array" name="expertis[]">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-danger mt-4 remove-entry">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-2" id="addMoreExpertise">Add More</button>
                            </div>
                        </div>
                    </div>

                    <!-- Office Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                                Office
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="office_organization" class="form-label">Office Organization</label>
                                        <input type="text" class="form-control auto-save" id="office_organization" name="office_organization">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" class="form-control auto-save" id="position" name="off_position">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="address" class="form-label">Office Address</label>
                                        <input type="text" class="form-control auto-save" id="address" name="off_address">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="building_no" class="form-label">Building No</label>
                                        <input type="text" class="form-control auto-save" id="building_no" name="off_building_no">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="barangay" class="form-label">Barangay</label>
                                        <input type="text" class="form-control auto-save" id="barangay" name="barangay">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="municipality" class="form-label">Municipality</label>
                                        <input type="text" class="form-control auto-save" id="municipality" name="municipality">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="province" class="form-label">Province</label>
                                        <input type="text" class="form-control auto-save" id="province" name="province">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="zip_code" class="form-label">Zip Code</label>
                                        <input type="text" class="form-control auto-save" id="zip_code" name="zip_code">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="tel_no" class="form-label">Telephone No</label>
                                        <input type="text" class="form-control auto-save" id="tel_no" name="off_tel_no">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="cell_no" class="form-label">Cellphone No</label>
                                        <input type="text" class="form-control auto-save" id="cell_no" name="off_cell_no">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fax_no" class="form-label">Fax No</label>
                                        <input type="text" class="form-control auto-save" id="fax_no" name="off_fax_no">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Work Experience Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Work Experience
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="work-experience-container">
                                    <div class="work-experience-entry">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control auto-save-array" name="work_name_company[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Date Started</label>
                                                <input type="date" class="form-control auto-save-array" name="work_date_started[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Date Ended</label>
                                                <input type="date" class="form-control auto-save-array" name="work_date_ended[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Position</label>
                                                <input type="text" class="form-control auto-save-array" name="work_position[]">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Company Address</label>
                                                <input type="text" class="form-control auto-save-array" name="work_address[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Division</label>
                                                <input type="text" class="form-control auto-save-array" name="work_division[]">
                                            </div>
                                            <div class="col-md-3">
                                                <br>
                                                <button type="button" class="btn btn-danger mt-2 remove-entry">Remove</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-2" id="addMoreWorkExperience">Add More</button>
                            </div>
                        </div>
                    </div>

                    <!-- Education Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                Education
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="education-container">
                                    <div class="education-entry">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Level</label>
                                                <input type="text" class="form-control auto-save-array" name="level[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">From</label>
                                                <input type="text" class="form-control auto-save-array" name="from_year[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">To</label>
                                                <input type="text" class="form-control auto-save-array" name="to_year[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">School</label>
                                                <input type="text" class="form-control auto-save-array" name="school[]">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Year Graduated</label>
                                                <input type="text" class="form-control auto-save-array" name="year_graduated[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Awards</label>
                                                <input type="text" class="form-control auto-save-array" name="awards[]">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-danger mt-2 remove-entry">Remove</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-2" id="addMoreEducation">Add More</button>
                            </div>
                        </div>
                    </div>

                    <!-- Training Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                Training's/ Seminars
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="training-container">
                                    <div class="training-entry">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Training Title</label>
                                                <input type="text" class="form-control auto-save-array" name="rst_title[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Venue</label>
                                                <input type="text" class="form-control auto-save-array" name="rst_venue[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Date</label>
                                                <input type="date" class="form-control auto-save-array" name="rst_date[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">No. of Hours</label>
                                                <input type="number" class="form-control auto-save-array" name="rst_no_hours[]">
                                            </div>
                                            <div class="col-md-3">
                                                <br>
                                                <button type="button" class="btn btn-danger mt-2 remove-entry">Remove</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-2" id="addMoreTraining">Add More</button>
                            </div>
                        </div>
                    </div>

                    <!-- Trainer Experience Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTrainerExperience">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrainerExperience">
                                Experience as Trainer
                            </button>
                        </h2>
                        <div id="collapseTrainerExperience" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="trainerExperienceRepeater">
                                    <div class="trainer-entry row mb-3 border p-3 rounded">
                                        <div class="col-md-3">
                                            <label class="form-label">Training Title</label>
                                            <input type="text" class="form-control auto-save-array" name="rt_title[]">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Date</label>
                                            <input type="date" class="form-control auto-save-array" name="rt_date[]">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Venue</label>
                                            <input type="text" class="form-control auto-save-array" name="rt_venue[]">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">No. of Hours</label>
                                            <input type="number" class="form-control auto-save-array" name="rt_no_hours[]">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-remove-trainer">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-3" id="addTrainerExperience">Add More</button>
                            </div>
                        </div>
                    </div>

                    <!-- Publications Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPublication">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#publicationsSection">
                                Publications
                            </button>
                        </h2>
                        <div id="publicationsSection" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="publication-container">
                                    <div class="publication-entry">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Publication Title</label>
                                                <input type="text" class="form-control auto-save-array" name="publication_title[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Nature</label>
                                                <input type="text" class="form-control auto-save-array" name="p_nature[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Date</label>
                                                <input type="date" class="form-control auto-save-array" name="p_date[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Venue</label>
                                                <input type="text" class="form-control auto-save-array" name="p_venue[]">
                                            </div>
                                            <div class="col-md-3">
                                                <br>
                                                <button type="button" class="btn btn-danger mt-2 remove-entry">Remove</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-2" id="addMorePublication">Add More</button>
                            </div>
                        </div>
                    </div>

                    <!-- References Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingReferences">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#referencesSection">
                                References
                            </button>
                        </h2>
                        <div id="referencesSection" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="references-container">
                                    <div class="references-entry border p-3 mb-3 rounded">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Agency Name</label>
                                                <input type="text" class="form-control auto-save-array" name="name_agency[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control auto-save-array" name="ref_address[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Contact Person</label>
                                                <input type="text" class="form-control auto-save-array" name="contact_person[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Position</label>
                                                <input type="text" class="form-control auto-save-array" name="ref_position[]">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Telephone No</label>
                                                <input type="text" class="form-control auto-save-array" name="ref_tel_no[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Cellphone No</label>
                                                <input type="text" class="form-control auto-save-array" name="ref_cell_no[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Fax No</label>
                                                <input type="text" class="form-control auto-save-array" name="ref_fax_no[]">
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-entry">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="addMoreReferences">Add More</button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('resourceSpeakerForm');
    const STORAGE_KEY = 'resource_speaker_full_draft_v3';
    let autoSaveTimeout;

    // FULL SWEETALERT2 VALIDATION ON SUBMIT
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let errors = [];

        // Image
        if (!document.getElementById('img').files[0]) {
            errors.push("Image is required.");
        }

        // Personal Info Required Fields
        const required = ['last_name','given_name','middle_name','date_of_birth','place_of_birth','age','gender','email','home_zip_code','home_municipality','home_province'];
        const labels = {
            last_name: "Last Name",
            given_name: "Given Name",
            middle_name: "Middle Name",
            date_of_birth: "Date of Birth",
            place_of_birth: "Place of Birth",
            age: "Age",
            gender: "Gender",
            email: "Email",
            home_zip_code: "Zip Code",
            home_municipality: "Municipality",
            home_province: "Province"
        };

        required.forEach(id => {
            const el = document.getElementById(id);
            if (!el || !el.value.trim()) {
                errors.push(`${labels[id]} is required.`);
            }
        });

        // Age must be > 0
        const age = document.getElementById('age')?.value;
        if (age && (age <= 0 || age > 150)) {
            errors.push("Please enter a valid age.");
        }

        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Required Fields Missing',
                html: errors.map(err => `• ${err}<br>`).join(''),
                confirmButtonColor: '#d33',
                width: '600px'
            });
            return;
        }

        // Final confirmation
        Swal.fire({
            title: 'Do you wish to proceed with the submission?',
            text: "Please ensure that all information is accurate and complete.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem(STORAGE_KEY);
                form.submit();
            }
        });
    });

    // AUTO-SAVE SYSTEM
    function saveFormData() {
        const data = { arrays: {}, timestamp: Date.now() };

        document.querySelectorAll('.auto-save').forEach(input => {
            if (input.name) data[input.name] = input.value;
        });

        document.querySelectorAll('.auto-save-array').forEach(input => {
            const name = input.name;
            if (!data.arrays[name]) data.arrays[name] = [];
            data.arrays[name].push(input.value || '');
        });

        localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        showAutoSaveAlert('Auto-saved!', 'info');
        updateLastSavedTime();
    }

    function loadSavedData() {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (!saved) return;

        try {
            const data = JSON.parse(saved);

            // Simple fields
            Object.keys(data).forEach(key => {
                if (key !== 'arrays' && key !== 'timestamp') {
                    const el = document.querySelector(`[name="${key}"]`);
                    if (el) el.value = data[key];
                }
            });

            // Array fields
            if (data.arrays) {
                Object.keys(data.arrays).forEach(name => {
                    const values = data.arrays[name];
                    const inputs = document.querySelectorAll(`[name="${name}"]`);

                    const map = {
                        'expertis[]': 'addMoreExpertise',
                        'work_name_company[]': 'addMoreWorkExperience',
                        'level[]': 'addMoreEducation',
                        'rst_title[]': 'addMoreTraining',
                        'rt_title[]': 'addTrainerExperience',
                        'publication_title[]': 'addMorePublication',
                        'name_agency[]': 'addMoreReferences'
                    };

                    const btnId = map[name];
                    if (btnId) {
                        const diff = values.length - inputs.length;
                        for (let i = 0; i < diff; i++) {
                            document.getElementById(btnId)?.click();
                        }
                    }

                    setTimeout(() => {
                        document.querySelectorAll(`[name="${name}"]`).forEach((el, i) => {
                            if (values[i] !== undefined) el.value = values[i];
                        });
                    }, 150);
                });
            }

            updateLastSavedTime(data.timestamp);
            showAutoSaveAlert('Draft restored!', 'success');
        } catch (e) {
            console.error(e);
        }
    }

    loadSavedData();

    document.querySelectorAll('.auto-save, .auto-save-array').forEach(el => {
        el.addEventListener('input', () => {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(saveFormData, 1000);
        });
    });

    function showAutoSaveAlert(msg, type = 'info') {
        const alert = document.getElementById('autoSaveAlert');
        document.getElementById('autoSaveMessage').textContent = msg;
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.style.display = 'block';
        setTimeout(() => alert.style.display = 'none', 4000);
    }

    function updateLastSavedTime(ts = Date.now()) {
        const date = new Date(ts);
        document.getElementById('lastSavedTime').textContent = 'Last saved: ' + date.toLocaleTimeString();
    }

    window.clearSavedData = function() {
        if (confirm('Clear all saved data? This cannot be undone.')) {
            localStorage.removeItem(STORAGE_KEY);
            location.reload();
        }
    };

    window.closeAutoSaveAlert = function() {
        document.getElementById('autoSaveAlert').style.display = 'none';
    };

    // DYNAMIC ADD/REMOVE HANDLERS
    const sections = [
        { btn: 'addMoreExpertise', container: 'expertise-container', cls: 'expertise-entry' },
        { btn: 'addMoreWorkExperience', container: 'work-experience-container', cls: 'work-experience-entry' },
        { btn: 'addMoreEducation', container: 'education-container', cls: 'education-entry' },
        { btn: 'addMoreTraining', container: 'training-container', cls: 'training-entry' },
        { btn: 'addMorePublication', container: 'publication-container', cls: 'publication-entry' },
        { btn: 'addMoreReferences', container: 'references-container', cls: 'references-entry' },
    ];

    sections.forEach(s => {
        document.getElementById(s.btn)?.addEventListener('click', () => {
            const container = document.getElementById(s.container);
            const template = container.querySelector(`.${s.cls}`);
            const clone = template.cloneNode(true);
            clone.querySelectorAll('input').forEach(i => i.value = '');
            container.appendChild(clone);
            saveFormData();
        });
    });

    document.getElementById('addTrainerExperience')?.addEventListener('click', () => {
        const container = document.getElementById('trainerExperienceRepeater');
        container.insertAdjacentHTML('beforeend', `...`); // same HTML as template
        saveFormData();
    });

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-entry') || e.target.classList.contains('btn-remove-trainer')) {
            const entry = e.target.closest('.expertise-entry, .work-experience-entry, .education-entry, .training-entry, .publication-entry, .references-entry, .trainer-entry');
            if (entry) entry.remove();
            saveFormData();
        }
    });
});
</script>

<style>
    #autoSaveAlert {
        animation: fadeIn 0.5s;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
