@extends('layouts.admin')

@section('content')

{{-- <style>
    #sidebarToggle, #sidenavAccordion {
        display: none !important;
    }

    #sidenavAccordion, .sibedar {
        margin: 0 !important;
    }

    .lumawa{
        margin-left: 0 !important;
    }

</style> --}}


<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="modal-title" id="addDataModalLabel">Update Information</h5>
        </div>

                    <form action="{{ route('resource_speaker.update', $speaker->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="tab-content mt-3">
                            <!-- Personal Info Tab (Rstbl) -->
                            <div class="accordion" id="accordionExample">
                                <!-- Personal Information Section -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPersonal">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="true" aria-controls="collapsePersonal">
                                            Personal Information
                                        </button>
                                    </h2>
                                    <div id="collapsePersonal" class="accordion-collapse collapse show" aria-labelledby="headingPersonal" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="last_name" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $speaker->last_name ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="given_name" class="form-label">Given Name</label>
                                                        <input type="text" class="form-control" id="given_name" name="given_name" value="{{ $speaker->given_name ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="middle_name" class="form-label">Middle Name</label>
                                                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $speaker->middle_name ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="ext_name" class="form-label">Extension Name</label>
                                                        <input type="text" class="form-control" id="ext_name" name="ext_name" value="{{ $speaker->ext_name ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $speaker->date_of_birth ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                                                        <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ $speaker->place_of_birth ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="age" class="form-label">Age</label>
                                                        <input type="number" class="form-control" id="age" name="age" value="{{ $speaker->age ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="{{ $speaker->email ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    {{-- <div class="col-md-3">
                                                        <label for="expertise" class="form-label">Expertise</label>
                                                        <input type="text" class="form-control" id="expertise" name="expertise" value="{{ $speaker->expertise ?? '' }}">
                                                    </div> --}}
                                                    <div class="col-md-3">
                                                        <label for="home_address" class="form-label">Home Address</label>
                                                        <input type="text" class="form-control" id="home_address" name="home_address" value="{{ $speaker->home_address ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="home_building_no" class="form-label">Building No</label>
                                                        <input type="text" class="form-control" id="home_building_no" name="home_building_no" value="{{ $speaker->home_building_no ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="home_barangay" class="form-label">Barangay</label>
                                                        <input type="text" class="form-control" id="home_barangay" name="home_barangay" value="{{ $speaker->home_barangay ?? '' }}">
                                                    </div>
                                                   <div class="col-md-3">
                                                        <label for="home_municipality" class="form-label">Municipality</label>
                                                        <input type="text" class="form-control" id="home_municipality" name="home_municipality" value="{{ $speaker->home_municipality ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="home_province" class="form-label">Province</label>
                                                        <input type="text" class="form-control" id="home_province" name="home_province" value="{{ $speaker->home_province ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="home_zip_code" class="form-label">Zip Code</label>
                                                        <input type="text" class="form-control" id="home_zip_code" name="home_zip_code" value="{{ $speaker->home_zip_code ?? '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="home_tel_no" class="form-label">Telephone No</label>
                                                        <input type="text" class="form-control" id="home_tel_no" name="home_tel_no" value="{{ $speaker->home_tel_no ?? '' }}">
                                                    </div>
                                                    <input type="hidden" name="updated_by" value="{{ auth()->id() }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingExpertise">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExpertise" aria-expanded="false" aria-controls="collapseExpertise">
                                                    Expertise
                                                </button>
                                            </h2>
                                            <div id="collapseExpertise" class="accordion-collapse collapse" aria-labelledby="headingExpertise" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    <div id="expertise-container">
                                                        @if(isset($speaker->expertises) && $speaker->expertises->isNotEmpty())
                                                            @foreach($speaker->expertises as $expertise)
                                                                <div class="expertise-entry row mb-3">
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="expertis[]" class="form-control" value="{{ $expertise->expertis }}">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button type="button" class="btn btn-danger remove-entry mt-2">Remove</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="expertise-entry row mb-3">
                                                                <div class="col-md-6">
                                                                    <input type="text" name="expertis[]" class="form-control" placeholder="Enter expertise">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <button type="button" class="btn btn-danger remove-entry mt-2">Remove</button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <button type="button" class="btn btn-primary mt-2" id="addMoreExpertise">Add More</button>
                                                </div>
                                            </div>
                                        </div>


                                <!-- Education Section -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingEducation">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEducation" aria-expanded="false" aria-controls="collapseEducation">
                                            Educational Background
                                        </button>
                                    </h2>
                                    <div id="collapseEducation" class="accordion-collapse collapse" aria-labelledby="headingEducation" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div id="educationRepeater">
                                                @if($speaker->educationalBackground->count())
                                                    @foreach($speaker->educationalBackground as $index => $education)
                                                        <div class="education-entry row mb-3">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Level</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][level]" value="{{ $education->level }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">From</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][from_year]" value="{{ $education->from_year }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">To</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][to_year]" value="{{ $education->to_year }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">School</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][school]" value="{{ $education->school }}">
                                                            </div>
                                                            <div class="col-md-3 mt-2">
                                                                <label class="form-label">Year Graduated</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][year_graduated]" value="{{ $education->year_graduated }}">
                                                            </div>
                                                            <div class="col-md-3 mt-2">
                                                                <label class="form-label">Awards</label>
                                                                <input type="text" class="form-control" name="education[{{ $index }}][awards]" value="{{ $education->awards }}">
                                                            </div>
                                                            <div class="col-md-2 mt-4">
                                                                <button type="button" class="btn btn-danger btn-remove-education mt-2">Remove</button>
                                                            </div>
                                                            <hr class="mt-3">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary mt-2" id="addEducation">Add More</button>
                                        </div>
                                    </div>
                                </div>


                <!-- Work Experience Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingWorkExperience">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWorkExperience" aria-expanded="false" aria-controls="collapseWorkExperience">
                            Work Experience
                        </button>
                    </h2>
                    <div id="collapseWorkExperience" class="accordion-collapse collapse" aria-labelledby="headingWorkExperience" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div id="workExperienceRepeater">
                                @if($speaker->workExperiences->count())
                                    @foreach($speaker->workExperiences as $index => $experience)
                                        <div class="work-entry row mb-3 border p-3 rounded">
                                            <div class="col-md-3">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control" name="work[{{ $index }}][name_company]" value="{{ $experience->name_company }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Date Started</label>
                                                <input type="date" class="form-control" name="work[{{ $index }}][date_started]" value="{{ $experience->date_started }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Date Ended</label>
                                                <input type="date" class="form-control" name="work[{{ $index }}][date_ended]" value="{{ $experience->date_ended }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Position</label>
                                                <input type="text" class="form-control" name="work[{{ $index }}][position]" value="{{ $experience->position }}">
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="form-label">Company Address</label>
                                                <input type="text" class="form-control" name="work[{{ $index }}][address]" value="{{ $experience->address }}">
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="form-label">Division</label>
                                                <input type="text" class="form-control" name="work[{{ $index }}][division]" value="{{ $experience->division }}">
                                            </div>
                                            <div class="col-md-2 mt-4">
                                                <button type="button" class="btn btn-danger btn-remove-work mt-4">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Add Button -->
                            <button type="button" class="btn btn-primary mt-3" id="addWorkExperience">Add More</button>
                        </div>
                    </div>
                </div>



   <!-- Office Information Section -->
   <div class="accordion-item">
    <h2 class="accordion-header" id="headingOffice">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOffice" aria-expanded="false" aria-controls="collapseOffice">
            Office Information
        </button>
    </h2>
    <div id="collapseOffice" class="accordion-collapse collapse" aria-labelledby="headingOffice" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="office_organization" class="form-label">Office Organization</label>
                    <input type="text" class="form-control" id="office_organization" name="office_organization"
                           value="{{ optional($speaker->office)->office_organization ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" name="position"
                           value="{{ optional($speaker->office)->position ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="address" class="form-label">Office Address</label>
                    <input type="text" class="form-control" id="address" name="address"
                           value="{{ optional($speaker->office)->address ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="building_no" class="form-label">Building No</label>
                    <input type="text" class="form-control" id="building_no" name="building_no"
                           value="{{ optional($speaker->office)->building_no ?? '' }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="barangay" class="form-label">Barangay</label>
                    <input type="text" class="form-control" id="barangay" name="barangay"
                           value="{{ optional($speaker->office)->barangay ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="municipality" class="form-label">Municipality</label>
                    <input type="text" class="form-control" id="municipality" name="municipality"
                           value="{{ optional($speaker->office)->municipality ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province"
                           value="{{ optional($speaker->office)->province ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="zip_code" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code"
                           value="{{ optional($speaker->office)->zip_code ?? '' }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="tel_no" class="form-label">Telephone No</label>
                    <input type="text" class="form-control" id="tel_no" name="tel_no"
                           value="{{ optional($speaker->office)->tel_no ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="cell_no" class="form-label">Cellphone No</label>
                    <input type="text" class="form-control" id="cell_no" name="cell_no"
                           value="{{ optional($speaker->office)->cell_no ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="fax_no" class="form-label">Fax No</label>
                    <input type="text" class="form-control" id="fax_no" name="fax_no"
                           value="{{ optional($speaker->office)->fax_no ?? '' }}">
                </div>
            </div>
        </div>
    </div>
</div>

                    <!-- Training Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTraining">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTraining" aria-expanded="false" aria-controls="collapseTraining">
                                Training's/ Siminars
                            </button>
                        </h2>
                        <div id="collapseTraining" class="accordion-collapse collapse" aria-labelledby="headingTraining" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="trainingRepeater">
                                    @if(!empty($speaker->experienceTrainer) && $speaker->experienceTrainer->count())
                                        @foreach($speaker->experienceTrainer as $trainer)
                                            <div class="training-entry row mb-3 border p-3 rounded">
                                                <div class="col-md-3">
                                                    <label class="form-label">Training Title</label>
                                                    <input type="text" class="form-control" name="rst_title[{{ $trainer->id }}]" value="{{ $trainer->rst_title }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Date</label>
                                                    <input type="date" class="form-control" name="rst_date[{{ $trainer->id }}]" value="{{ $trainer->rst_date }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Venue</label>
                                                    <input type="text" class="form-control" name="rst_venue[{{ $trainer->id }}]" value="{{ $trainer->rst_venue }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">No. of Hours</label>
                                                    <input type="number" class="form-control" name="rst_no_hours[{{ $trainer->id }}]" value="{{ $trainer->rst_no_hours }}">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-remove-training">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary mt-3" id="addTraining">Add More</button>
                            </div>
                        </div>
                    </div>



                <!-- Experience as Trainer Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTrainerExperience">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrainerExperience" aria-expanded="false" aria-controls="collapseTrainerExperience">
                            Experience as Trainer
                        </button>
                    </h2>
                    <div id="collapseTrainerExperience" class="accordion-collapse collapse" aria-labelledby="headingTrainerExperience" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div id="trainerExperienceRepeater">
                                @if(!empty($speaker->trainings) && $speaker->trainings->count())
                                @foreach($speaker->trainings as $exper)
                                        <div class="trainer-entry row mb-3 border p-3 rounded">
                                            <div class="col-md-3">
                                                <label class="form-label">Training Title</label>
                                                <input type="text" class="form-control" name="rt_title[]" value="{{ $exper->rt_title }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Date</label>
                                                <input type="date" class="form-control" name="rt_date[]" value="{{ $exper->rt_date }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Venue</label>
                                                <input type="text" class="form-control" name="rt_venue[]" value="{{ $exper->rt_venue }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">No. of Hours</label>
                                                <input type="number" class="form-control" name="rt_no_hours[]" value="{{ $exper->rt_no_hours }}">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-remove-trainer">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary mt-3" id="addTrainerExperience">Add More</button>
                        </div>
                    </div>
                </div>


<!-- Publications Section -->
<div class="accordion-item">
    <h2 class="accordion-header" id="headingPublications">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePublications" aria-expanded="false" aria-controls="collapsePublications">
            Publications
        </button>
    </h2>
    <div id="collapsePublications" class="accordion-collapse collapse" aria-labelledby="headingPublications" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div id="publicationsRepeater">
                @if(!empty($speaker->publications) && $speaker->publications->count())
                    @foreach($speaker->publications as $publication)
                        <div class="publication-entry row mb-3 border p-3 rounded">
                            <div class="col-md-3">
                                <label for="title" class="form-label">Publication Title</label>
                                <input type="text" class="form-control" name="p_title[{{ $publication->id }}]" value="{{ $publication->p_title }}">
                            </div>
                            <div class="col-md-3">
                                <label for="nature" class="form-label">Nature</label>
                                <input type="text" class="form-control" name="p_nature[{{ $publication->id }}]" value="{{ $publication->p_nature }}">
                            </div>
                            <div class="col-md-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="p_date[{{ $publication->id }}]" value="{{ $publication->p_date }}">
                            </div>
                            <div class="col-md-3">
                                <label for="venue" class="form-label">Venue</label>
                                <input type="text" class="form-control" name="p_venue[{{ $publication->id }}]" value="{{ $publication->p_venue }}">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-remove-publication">Remove</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" class="btn btn-primary mt-3" id="addPublication">Add More</button>
        </div>
    </div>
</div>


  <!-- References Section -->
<div class="accordion-item">
    <h2 class="accordion-header" id="headingReferences">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReferences" aria-expanded="false" aria-controls="collapseReferences">
            References
        </button>
    </h2>
    <div id="collapseReferences" class="accordion-collapse collapse" aria-labelledby="headingReferences" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div id="referencesRepeater">
                @if(isset($speaker) && $speaker->referencesTrainings->count())
                    @foreach($speaker->referencesTrainings as $ref)
                        <div class="reference-entry row mb-3 border p-3 rounded">
                            <div class="col-md-3">
                                <label class="form-label">Agency Name</label>
                                <input type="text" class="form-control" name="references[name_agency][]" value="{{ $ref->name_agency }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="references[address][]" value="{{ $ref->address }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" class="form-control" name="references[contact_person][]" value="{{ $ref->contact_person }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Position</label>
                                <input type="text" class="form-control" name="references[position][]" value="{{ $ref->position }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tel No.</label>
                                <input type="text" class="form-control" name="references[tel_no][]" value="{{ $ref->tel_no }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cell No.</label>
                                <input type="text" class="form-control" name="references[cell_no][]" value="{{ $ref->cell_no }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fax No.</label>
                                <input type="text" class="form-control" name="references[fax_no][]" value="{{ $ref->fax_no }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-remove-reference">Remove</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" class="btn btn-primary mt-3" id="addReference">Add More</button>
        </div>
    </div>
</div>



</div>
                </div>
                <div class="modal-footer bg-success mt-4">
                    {{-- <a href="{{url('/rstbl')}}" type="button" class="btn btn-secondary">Close</a> &nbsp;&nbsp; --}}
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addBtn = document.getElementById('addEducation');
        const container = document.getElementById('educationRepeater');

        addBtn.addEventListener('click', function () {
            // Calculate current number of education-entry blocks
            const eduIndex = container.querySelectorAll('.education-entry').length;

            const div = document.createElement('div');
            div.className = 'education-entry row mb-3 border p-3 rounded';

            div.innerHTML = `
                <div class="col-md-3">
                    <label class="form-label">Level</label>
                    <input type="text" class="form-control" name="education[${eduIndex}][level]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">From</label>
                    <input type="text" class="form-control" name="education[${eduIndex}][from_year]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To</label>
                    <input type="text" class="form-control" name="education[${eduIndex}][to_year]">
                </div>
                <div class="col-md-3">
                    <label class="form-label">School</label>
                    <input type="text" class="form-control" name="education[${eduIndex}][school]">
                </div>
                <div class="col-md-3 mt-2">
                    <label class="form-label">Year Graduated</label>
                    <input type="text" class="form-control" name="education[${eduIndex}][year_graduated]">
                </div>
                <div class="col-md-3 mt-2">
                    <label class="form-label">Awards</label>
                    <input type="text" class="form-control" name="education[${eduIndex}][awards]">
                </div>
                <div class="col-md-2 mt-4">
                    <button type="button" class="btn btn-danger btn-remove-education mt-4">Remove</button>
                </div>
                <hr class="mt-3">
            `;

            container.appendChild(div);
        });

        // Use event delegation for dynamic remove buttons
        container.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-remove-education')) {
                const entry = event.target.closest('.education-entry');
                if (entry) {
                    entry.remove();
                }
            }
        });
    });



    //workExperiences
    $(document).ready(function () {
        let workIndex = $('#workExperienceRepeater .work-entry').length;

        $('#addWorkExperience').on('click', function () {
            let html = `
                <div class="work-entry row mb-3 border p-3 rounded">
                    <div class="col-md-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="work[${workIndex}][name_company]">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date Started</label>
                        <input type="date" class="form-control" name="work[${workIndex}][date_started]">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date Ended</label>
                        <input type="date" class="form-control" name="work[${workIndex}][date_ended]">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control" name="work[${workIndex}][position]">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label class="form-label">Company Address</label>
                        <input type="text" class="form-control" name="work[${workIndex}][address]">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label class="form-label">Division</label>
                        <input type="text" class="form-control" name="work[${workIndex}][division]">
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="button" class="btn btn-danger btn-remove-work mt-4">Remove</button>
                    </div>
                </div>
            `;
            $('#workExperienceRepeater').append(html);
            workIndex++;
        });

        // Remove button functionality
        $('body').on('click', '.btn-remove-work', function () {
            $(this).closest('.work-entry').remove();
        });
    });


    //Training Section
    $(document).ready(function () {
    // Set the initial training index
    let trainingIndex = $('#trainingRepeater .training-entry').length;

    // Add More button functionality
    $('#addTraining').on('click', function () {
        let html = `
            <div class="training-entry row mb-3 border p-3 rounded">
                <div class="col-md-3">
                    <label class="form-label">Training Title</label>
                    <input type="text" class="form-control" name="rst_title[${trainingIndex}]" value="">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" name="rst_date[${trainingIndex}]" value="">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Venue</label>
                    <input type="text" class="form-control" name="rst_venue[${trainingIndex}]" value="">
                </div>
                <div class="col-md-2">
                    <label class="form-label">No. of Hours</label>
                    <input type="number" class="form-control" name="rst_no_hours[${trainingIndex}]" value="">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-training">Remove</button>
                </div>
            </div>
        `;
        $('#trainingRepeater').append(html); // Append the new training entry
        trainingIndex++; // Increment the index for the next dynamic field
    });

    // Remove button functionality
    $('body').on('click', '.btn-remove-training', function () {
        $(this).closest('.training-entry').remove(); // Remove the closest training-entry element
    });
});



//Publications
$(document).ready(function () {
    let publicationIndex = $('#publicationsRepeater .publication-entry').length;

    // Add More button functionality
    $('#addPublication').on('click', function () {
        let html = `
            <div class="publication-entry row mb-3 border p-3 rounded">
                <div class="col-md-3">
                    <label for="title" class="form-label">Publication Title</label>
                    <input type="text" class="form-control" name="p_title[${publicationIndex}]" value="">
                </div>
                <div class="col-md-3">
                    <label for="nature" class="form-label">Nature</label>
                    <input type="text" class="form-control" name="p_nature[${publicationIndex}]" value="">
                </div>
                <div class="col-md-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" name="p_date[${publicationIndex}]" value="">
                </div>
                <div class="col-md-3">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" class="form-control" name="p_venue[${publicationIndex}]" value="">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-publication">Remove</button>
                </div>
            </div>
        `;
        $('#publicationsRepeater').append(html); // Append the new publication entry
        publicationIndex++; // Increment the index for the next dynamic field
    });

    // Remove button functionality
    $('body').on('click', '.btn-remove-publication', function () {
        $(this).closest('.publication-entry').remove(); // Remove the closest publication-entry element
    });
});

// Experience as Trainer Section

    document.getElementById('addTrainerExperience').addEventListener('click', function () {
        const container = document.getElementById('trainerExperienceRepeater');
        const entry = document.createElement('div');
        entry.classList.add('trainer-entry', 'row', 'mb-3', 'border', 'p-3', 'rounded');
        entry.innerHTML = `
            <div class="col-md-3">
                <label class="form-label">Training Title</label>
                <input type="text" class="form-control" name="rt_title[]" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" class="form-control" name="rt_date[]" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label">Venue</label>
                <input type="text" class="form-control" name="rt_venue[]" value="">
            </div>
            <div class="col-md-2">
                <label class="form-label">No. of Hours</label>
                <input type="number" class="form-control" name="rt_no_hours[]" value="">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove-trainer">Remove</button>
            </div>
        `;
        container.appendChild(entry);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove-trainer')) {
            e.target.closest('.trainer-entry').remove();
        }
    });

// Expertis
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('expertise-container');
    const addMoreBtn = document.getElementById('addMoreExpertise');

    addMoreBtn.addEventListener('click', function () {
        const entry = document.createElement('div');
        entry.classList.add('expertise-entry', 'row', 'mb-3');

        entry.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="expertis[]" class="form-control" placeholder="Enter expertise" value="">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-entry mt-2">Remove</button>
            </div>
        `;

        container.appendChild(entry);
    });

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-entry')) {
            e.target.closest('.expertise-entry').remove();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('referencesRepeater');
    const addBtn = document.getElementById('addReference');

    const template = () => `
        <div class="reference-entry row mb-3 border p-3 rounded">
            <div class="col-md-3">
                <label class="form-label">Agency Name</label>
                <input type="text" class="form-control" name="references[name_agency][]" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="references[address][]" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Person</label>
                <input type="text" class="form-control" name="references[contact_person][]" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" name="references[position][]" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tel No.</label>
                <input type="text" class="form-control" name="references[tel_no][]" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label">Cell No.</label>
                <input type="text" class="form-control" name="references[cell_no][]" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label">Fax No.</label>
                <input type="text" class="form-control" name="references[fax_no][]" value="">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove-reference">Remove</button>
            </div>
        </div>`;

    addBtn.addEventListener('click', () => {
        container.insertAdjacentHTML('beforeend', template());
    });

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove-reference')) {
            e.target.closest('.reference-entry').remove();
        }
    });
});
</script>


@endsection
