@extends('layouts.admin')

@section('content')

<style>
    #sidebarToggle, #sidenavAccordion {
        display: none !important;
    }

    #sidenavAccordion, .sibedar {
        margin: 0 !important;
    }
    
    .lumawa{
        margin-left: 0 !important;
    }

</style>


<div class="container-fluid lumawa mt-5">
                <div class="modal-header bg-info">
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
                                                    <div class="col-md-3">
                                                        <label for="expertise" class="form-label">Expertise</label>
                                                        <input type="text" class="form-control" id="expertise" name="expertise" value="{{ $speaker->expertise ?? '' }}">
                                                    </div>
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
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="home_municipality" class="form-label">Municipality</label>
                                                        <input type="text" class="form-control" id="home_municipality" name="home_municipality" value="{{ $speaker->home_municipality ?? '' }}">
                                                    </div>
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
                                                </div>
                                            </div>
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
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="level" class="form-label">Level</label>
                                                    <input type="text" class="form-control" id="level" name="level" value="{{ optional($speaker->educationalBackground->first())->level ?? '' }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="from" class="form-label">From</label>
                                                    <input type="text" class="form-control" id="from" name="from_year" value="{{ optional($speaker->educationalBackground->first())->from_year ?? '' }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="to" class="form-label">To</label>
                                                    <input type="text" class="form-control" id="to" name="to_year" value="{{ optional($speaker->educationalBackground->first())->to_year ?? '' }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="school" class="form-label">School</label>
                                                    <input type="text" class="form-control" id="school" name="school" value="{{ optional($speaker->educationalBackground->first())->school ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="year_graduated" class="form-label">Year Graduated</label>
                                                    <input type="text" class="form-control" id="year_graduated" name="year_graduated" value="{{ optional($speaker->educationalBackground->first())->year_graduated ?? '' }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="awards" class="form-label">Awards</label>
                                                    <input type="text" class="form-control" id="awards" name="awards" value="{{ optional($speaker->educationalBackground->first())->awards ?? '' }}">
                                                </div>
                                            </div>
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
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="name_company" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="name_company" name="name_company" value="{{ optional($speaker->workExperiences->first())->name_company ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="date_started" class="form-label">Date Started</label>
                    <input type="date" class="form-control" id="date_started" name="date_started" value="{{ optional($speaker->workExperiences->first())->date_started ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="date_ended" class="form-label">Date Ended</label>
                    <input type="date" class="form-control" id="date_ended" name="date_ended" value="{{ optional($speaker->workExperiences->first())->date_ended ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" name="position" value="{{ optional($speaker->workExperiences->first())->position ?? '' }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="address" class="form-label">Company Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ optional($speaker->workExperiences->first())->address ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="division" class="form-label">Division</label>
                    <input type="text" class="form-control" id="division" name="division" value="{{ optional($speaker->workExperiences->first())->division ?? '' }}">
                </div>
            </div>
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
            Training Information
        </button>
    </h2>
    <div id="collapseTraining" class="accordion-collapse collapse" aria-labelledby="headingTraining" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="title" class="form-label">Training Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                           value="{{ optional($speaker->training)->title ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="date_venue" class="form-label">Date/Venue</label>
                    <input type="text" class="form-control" id="date_venue" name="date_venue"
                           value="{{ optional($speaker->training)->date_venue ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="no_hours" class="form-label">No. of Hours</label>
                    <input type="number" class="form-control" id="no_hours" name="no_hours"
                           value="{{ optional($speaker->training)->no_hours ?? '' }}">
                </div>
            </div>
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
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="title" class="form-label">Trainer Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                           value="{{ optional($speaker->trainer)->title ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="date_venue" class="form-label">Date/Venue</label>
                    <input type="text" class="form-control" id="date_venue" name="date_venue"
                           value="{{ optional($speaker->trainer)->date_venue ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="no_hours" class="form-label">No. of Hours</label>
                    <input type="number" class="form-control" id="no_hours" name="no_hours"
                           value="{{ optional($speaker->trainer)->no_hours ?? '' }}">
                </div>
            </div>
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
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="title" class="form-label">Publication Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                           value="{{ optional($speaker->publication)->title ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="nature" class="form-label">Nature</label>
                    <input type="text" class="form-control" id="nature" name="nature"
                           value="{{ optional($speaker->publication)->nature ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="date_venue" class="form-label">Date/Venue</label>
                    <input type="text" class="form-control" id="date_venue" name="date_venue"
                           value="{{ optional($speaker->publication)->date_venue ?? '' }}">
                </div>
            </div>
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
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="name_agency" class="form-label">Agency Name</label>
                    <input type="text" class="form-control" id="name_agency" name="name_agency"
                           value="{{ optional($speaker->agency)->name_agency ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address"
                           value="{{ optional($speaker->agency)->address ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="contact_person" class="form-label">Contact Person</label>
                    <input type="text" class="form-control" id="contact_person" name="contact_person"
                           value="{{ optional($speaker->agency)->contact_person ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" name="position"
                           value="{{ optional($speaker->agency)->position ?? '' }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="tel_no" class="form-label">Telephone No</label>
                    <input type="text" class="form-control" id="tel_no" name="tel_no"
                           value="{{ optional($speaker->agency)->tel_no ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="cell_no" class="form-label">Cellphone No</label>
                    <input type="text" class="form-control" id="cell_no" name="cell_no"
                           value="{{ optional($speaker->agency)->cell_no ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="fax_no" class="form-label">Fax No</label>
                    <input type="text" class="form-control" id="fax_no" name="fax_no"
                           value="{{ optional($speaker->agency)->fax_no ?? '' }}">
                </div>
            </div>
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

@endsection
