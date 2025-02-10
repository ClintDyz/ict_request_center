@extends('layouts.admin')

@section('content')


<!-- Modal with tabs -->
{{-- <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true"> --}}
    <div class="modal fade show" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true" style="display:block;">
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
                                    <input type="date" class="form-control" id="from" name="from">
                                </div>
                                <div class="col-md-3">
                                    <label for="to" class="form-label">To</label>
                                    <input type="date" class="form-control" id="to" name="to">
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


@endsection
