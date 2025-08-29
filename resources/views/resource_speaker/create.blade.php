@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-1">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4>Add Information</h4>
        </div>
        <div class="card-body">

            <form action="{{ route('resource_speaker.store') }}" method="POST">
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
                                        <input type="file" class="form-control" id="img" name="img" required>
                                    </div>
                                </div>
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
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <label for="expertise" class="form-label">Expertise</label>
                                        <input type="text" class="form-control" id="expertise" name="expertise">
                                    </div> --}}
                                                                        <div class="col-md-3">
                                        <label for="home_zip_code" class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" id="home_zip_code" name="home_zip_code">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_address" class="form-label">Home Address</label>
                                        <input type="text" class="form-control" id="home_address" name="home_address">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_building_no" class="form-label">Building No</label>
                                        <input type="text" class="form-control" id="home_building_no" name="home_building_no">
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="home_barangay" class="form-label">Barangay</label>
                                        <input type="text" class="form-control" id="home_barangay" name="home_barangay">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_municipality" class="form-label">Municipality</label>
                                        <input type="text" class="form-control" id="home_municipality" name="home_municipality">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_province" class="form-label">Province</label>
                                        <input type="text" class="form-control" id="home_province" name="home_province">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="home_cell_no" class="form-label">Cellphone No</label>
                                        <input type="text" class="form-control" id="home_cell_no" name="home_cell_no">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="home_tel_no" class="form-label">Telephone No</label>
                                        <input type="text" class="form-control" id="home_tel_no" name="home_tel_no">
                                    </div>
                                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">

                              </div>
                            </div>
                        </div>
                    </div>


                    <!-- Expertis -->
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
                                                <label for="expertis[]" class="form-label">Expertise</label>
                                                <input type="text" class="form-control" name="expertis[]">
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

                    <!-- RsOffice Section -->
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
                                        <input type="text" class="form-control" id="office_organization" name="office_organization">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="position" name="off_position">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="address" class="form-label">Office Address</label>
                                        <input type="text" class="form-control" id="address" name="off_address">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="building_no" class="form-label">Building No</label>
                                        <input type="text" class="form-control" id="building_no" name="off_building_no">
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
                                        <input type="text" class="form-control" id="tel_no" name="off_tel_no">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="cell_no" class="form-label">Cellphone No</label>
                                        <input type="text" class="form-control" id="cell_no" name="off_cell_no">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fax_no" class="form-label">Fax No</label>
                                        <input type="text" class="form-control" id="fax_no" name="off_fax_no">
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
                                                <label for="name_company" class="form-label">Company Name</label>
                                                <input type="text" class="form-control" id="name_company" name="work_name_company[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="date_started" class="form-label">Date Started</label>
                                                <input type="date" class="form-control" id="date_started" name="work_date_started[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="date_ended" class="form-label">Date Ended</label>
                                                <input type="date" class="form-control" id="date_ended" name="work_date_ended[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="position" class="form-label">Position</label>
                                                <input type="text" class="form-control" id="position" name="work_position[]">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="address" class="form-label">Company Address</label>
                                                <input type="text" class="form-control" id="address" name="work_address[]">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="division" class="form-label">Division</label>
                                                <input type="text" class="form-control" id="division" name="work_division[]">
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
                                Training's/ Siminars
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
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

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTrainerExperience">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrainerExperience" aria-expanded="false" aria-controls="collapseTrainerExperience">
                                Experience as Trainer
                            </button>
                        </h2>
                        <div id="collapseTrainerExperience" class="accordion-collapse collapse" aria-labelledby="headingTrainerExperience" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="trainerExperienceRepeater">
                                    <div class="trainer-entry row mb-3 border p-3 rounded">
                                        <div class="col-md-3">
                                            <label class="form-label">Training Title</label>
                                            <input type="text" class="form-control" name="rt_title[]" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Date</label>
                                            <input type="date" class="form-control" name="rt_date[]" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Venue</label>
                                            <input type="text" class="form-control" name="rt_venue[]" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">No. of Hours</label>
                                            <input type="number" class="form-control" name="rt_no_hours[]" required>
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


                    <!-- Publications -->
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


                                                    <!-- References Tab (RsReferences) -->
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
                                                                <input type="text" class="form-control" name="name_agency[]">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Address</label>
                                                                <input type="text" class="form-control" name="ref_address[]">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Contact Person</label>
                                                                <input type="text" class="form-control" name="contact_person[]">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Position</label>
                                                                <input type="text" class="form-control" name="ref_position[]">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Telephone No</label>
                                                                <input type="text" class="form-control" name="ref_tel_no[]">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Cellphone No</label>
                                                                <input type="text" class="form-control" name="ref_cell_no[]">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Fax No</label>
                                                                <input type="text" class="form-control" name="ref_fax_no[]">
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


                <!-- Submit Button -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- JavaScript for Add More/Remove Entries -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Generic Add More Handler
    function addMoreHandler(buttonId, containerId, entryClass) {
        document.getElementById(buttonId).addEventListener("click", function () {
            const container = document.getElementById(containerId);
            const template = container.querySelector(`.${entryClass}`);
            if (!template) return;

            const newEntry = template.cloneNode(true);
            newEntry.querySelectorAll("input").forEach(input => input.value = "");
            container.appendChild(newEntry);
        });
    }

    // Generic Remove Handler
    function removeHandler(containerId, entryClasses) {
        document.getElementById(containerId).addEventListener("click", function (e) {
            if (e.target.classList.contains("remove-entry")) {
                for (const cls of entryClasses) {
                    const parent = e.target.closest(`.${cls}`);
                    if (parent) {
                        parent.remove();
                        break;
                    }
                }
            }
        });
    }

    // Add More Section Handlers
    addMoreHandler("addMoreWorkExperience", "work-experience-container", "work-experience-entry");
    addMoreHandler("addMoreEducation", "education-container", "education-entry");
    addMoreHandler("addMoreTraining", "training-container", "training-entry");
    addMoreHandler("addMorePublication", "publication-container", "publication-entry");
    addMoreHandler("addMoreExpertise", "expertise-container", "expertise-entry"); // ✅ Expertise
    addMoreHandler("addMoreReferences", "references-container", "references-entry");


    // Remove Section Handlers
    removeHandler("work-experience-container", ["work-experience-entry"]);
    removeHandler("education-container", ["education-entry"]);
    removeHandler("training-container", ["training-entry"]);
    removeHandler("publication-container", ["publication-entry"]);
    removeHandler("expertise-container", ["expertise-entry"]); // ✅ Expertise
    removeHandler("references-container", ["references-entry"]);

    // Trainer Experience Dynamic Section
    document.getElementById('addTrainerExperience').addEventListener('click', function () {
        const container = document.getElementById('trainerExperienceRepeater');
        const template = `
            <div class="trainer-entry row mb-3 border p-3 rounded">
                <div class="col-md-3">
                    <label class="form-label">Training Title</label>
                    <input type="text" class="form-control" name="rt_title[]" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" name="rt_date[]" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Venue</label>
                    <input type="text" class="form-control" name="rt_venue[]" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">No. of Hours</label>
                    <input type="number" class="form-control" name="rt_no_hours[]" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-trainer">Remove</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove-trainer')) {
            e.target.closest('.trainer-entry').remove();
        }
    });
});

</script>
@endsection
