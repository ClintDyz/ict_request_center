@extends('layouts.admin')

@section('content')

<style>
    .stat-card { transition: transform 0.2s; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
    .status-badge { padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; }
    .status-approved { background-color: #17a2b8; color: #fff; }
    .form-box { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px; }
    .section-title { font-weight: bold; margin-bottom: 10px; }
    .score-box { width: 80px; text-align: center; }
    .total-input { font-weight: bold; background-color: #fff3cd; width:100px; text-align:center; }
    .info-row { margin-bottom: 8px; }
    .info-label { font-weight: 600; color: #495057; width: 40%; }
    .speaker-details { background: #fff; padding: 20px; border-radius: 5px; border: 1px solid #dee2e6; height: calc(100vh - 200px); overflow-y: auto; }
    .detail-table { font-size: 0.85rem; }
    .detail-table td { padding: 4px 8px; border-bottom: 1px solid #e9ecef; }
    .modal-xl-custom { max-width: 98%; margin: 1rem auto; }
    .section-header { background-color: #f8f9fa; padding: 8px 12px; font-weight: bold; margin-top: 15px; margin-bottom: 10px; border-left: 4px solid #17a2b8; }
    .left-column { height: calc(100vh - 200px); overflow-y: auto; padding-right: 15px; }

    /* Custom scrollbar */
    .speaker-details::-webkit-scrollbar, .left-column::-webkit-scrollbar {
        width: 8px;
    }
    .speaker-details::-webkit-scrollbar-track, .left-column::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .speaker-details::-webkit-scrollbar-thumb, .left-column::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    .speaker-details::-webkit-scrollbar-thumb:hover, .left-column::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
 /* Prevent status badge cell from shrinking */
    td:nth-child(10), th:nth-child(10) {
        white-space: nowrap;
        width: 120px;
        text-align: center;
    }

    /* Make actions column fixed width (optional) */
    td:nth-child(11), th:nth-child(11) {
        width: 140px;
        white-space: nowrap;
        text-align: center;
    }

    /* Prevent expertise and office columns from becoming too wide */
    td:nth-child(6), th:nth-child(6),
    td:nth-child(7), th:nth-child(7) {
        max-width: 220px;
        white-space: normal;
        word-wrap: break-word;
    }

    /* Status badge style */
    .status-approved {
        background: #17a2b8;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }
</style>

<div class="container-fluid px-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4 mt-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <div><i class="fas fa-check-circle me-2"></i> List of To Be Evaluated</div>
        </div>

        <div class="card-body">
            <hr>

            <div class="table-responsive">
                <table id="datatablesSimple" class="table table-striped table-bordered table-hover">
                    <thead class="table-info">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Expertise</th>
                            <th>Office/Agency</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th>Status</th>
                                {{-- @if(auth()->user()->emp_type == '1') --}}

                            <th>Actions</th>
                                        {{-- @endif --}}

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($speakers as $index => $speaker)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $speaker->given_name }} {{ $speaker->middle_name }} {{ $speaker->last_name }}</strong>
                                </td>
                                <td>{{ $speaker->email }}</td>
                                <td>
                                    @if($speaker->gender == 'Male')
                                        <i class="fas fa-male text-primary"></i> Male
                                    @else
                                        <i class="fas fa-female text-danger"></i> Female
                                    @endif
                                </td>
                                <td>{{ $speaker->age }}</td>
                                <td>
                                    @if($speaker->expertises->isNotEmpty())
                                        <small>{{ $speaker->expertises->pluck('expertis')->implode(', ') }}</small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td><small>{{ optional($speaker->office)->office_organization ?? 'N/A' }}</small></td>
                                <td><small>{{ $speaker->home_municipality }}, {{ $speaker->home_province }}</small></td>
                                <td>{{ $speaker->home_cell_no }}</td>
                                <td><span class="badge status-approved"><i class="fas fa-check-circle me-1"></i>Approved</span></td>
                                {{-- @if(auth()->user()->emp_type == '1') --}}
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#accreditationModal-{{ $speaker->id }}">
                                        <i class="fa-solid fa-circle-plus"></i> Evaluate
                                    </button>
                                </td>
                                {{-- @endif --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">
                                    <div class="py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No Specialist to be Evaluated.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Accreditation Modals (one per speaker) -->
@foreach($speakers as $speaker)
<div class="modal fade accreditation-modal" id="accreditationModal-{{ $speaker->id }}" tabindex="-1" aria-labelledby="accreditationModalLabel-{{ $speaker->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-xl-custom">
        <form action="{{ route('accreditation.create') }}" method="POST" class="accreditation-form">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Accreditation Form - {{ $speaker->given_name }} {{ $speaker->last_name }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- LEFT COLUMN: Evaluation Criteria -->
                        <div class="col-md-5 left-column">
                            <div class="text-center mb-4">
                                <h6><strong>CRITERIA FOR ACCREDITATION OF TRAINERS/<br>RESOURCE SPEAKERS/ SUBJECT MATTER SPECIALISTS</strong></h6>
                            </div>

                            <input type="hidden" name="rstbl_id" value="{{ $speaker->id }}">

                            <!-- Speaker Info -->
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label"><small>Name of Applicant:</small></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm" value="{{ $speaker->given_name }} {{ $speaker->middle_name }} {{ $speaker->last_name }}" readonly>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label class="col-sm-5 col-form-label"><small>Field of Expertise:</small></label>
                                <div class="col-sm-7">
                                    <input type="text" name="field_of_expertise" class="form-control form-control-sm" value="{{ $speaker->expertises->pluck('expertis')->implode(', ') }}" readonly>
                                </div>
                            </div>

                            <!-- Sections -->
                            <div class="form-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0"><small><strong>1.0 Educational Qualifications – 30 pts</strong></small></p>
                                    <input type="number" name="education" class="form-control score-box" min="0" max="30" step="1" value="">
                                </div>
                                <div style="font-size: 0.8rem;">
                                    <div class="d-flex justify-content-between"><div>Technical/Vocational </div><div>(15)</div></div>
                                    <div class="d-flex justify-content-between"><div>Bachelor's Degree </div><div>(20)</div></div>
                                    <div class="d-flex justify-content-between"><div>Master's Degree </div><div>(25)</div></div>
                                    <div class="d-flex justify-content-between"><div>Doctorate Degree </div><div>(30)</div></div>
                                </div>
                            </div>

                            <div class="form-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0"><small><strong>2.0 Work Experience – 30 pts</strong></small></p>
                                    <input type="number" name="work" class="form-control score-box" min="0" max="30" step="1" value="">
                                </div>
                                <div style="font-size: 0.8rem;">
                                    <div class="d-flex justify-content-between"><div>At least 2 years </div><div>(20)</div></div>
                                    <div class="d-flex justify-content-between"><div>3 to 5 years</div><div> (25)</div></div>
                                    <div class="d-flex justify-content-between"><div>More than 5 years </div><div>(30)</div></div>
                                </div>
                            </div>

                            <div class="form-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0"><small><strong>3.0 Trainings/Seminars – 20 pts</strong></small></p>
                                    <input type="number" name="seminar" class="form-control score-box" min="0" max="20" step="1" value="">
                                </div>
                                <div style="font-size: 0.8rem;">
                                    <div class="d-flex justify-content-between"><div>40 – 80 hours </div><div>(10)</div></div>
                                    <div class="d-flex justify-content-between"><div>81 – 120 hours </div><div>(15)</div></div>
                                    <div class="d-flex justify-content-between"><div>121 hours+ </div><div>(20)</div></div>
                                </div>
                            </div>

                            <div class="form-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0"><small><strong>4.0 Experience As Trainer – 10 pts</strong></small></p>
                                    <input type="number" name="experience" class="form-control score-box" min="0" max="10" step="1" value="">
                                </div>
                                <div style="font-size: 0.8rem;">
                                    <div class="d-flex justify-content-between"><div>30+ hrs training</div><div> (10)</div></div>
                                    <div class="d-flex justify-content-between"><div>Recognized trainer </div><div>(5)</div></div>
                                </div>
                            </div>

                            <div class="form-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0"><small><strong>5.0 Technical Merits – 10 pts</strong></small></p>
                                    <input type="number" name="award" class="form-control score-box" min="0" max="10" step="1" value="">
                                </div>
                                <div style="font-size: 0.8rem;">
                                    <div class="d-flex justify-content-between"><div>National Awards/Publications </div><div>(10)</div></div>
                                    <div class="d-flex justify-content-between"><div>Local Awards/Publications </div><div>(5)</div></div>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                                <div><strong>TOTAL</strong></div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="total" class="form-control total-input" readonly value="">
                                </div>
                            </div>

                            <p><em><small>Note: Passing Score is 75 points.</small></em>
                                <span class="pass-fail-status fw-bold ms-3"></span>
                            </p>

                            <input type="hidden" name="status" value="0">
                            <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                        </div>

                        <!-- RIGHT COLUMN: Speaker Details -->
                        <div class="col-md-7">
                            <div class="speaker-details">
                                <div class="text-center mb-3">
                                    <h6><strong>APPLICATION FORM FOR THE ACCREDITATION OF<br>TECHNICAL PERSONNEL/TRAINER/SUBJECT MATTER SPECIALIST</strong></h6>
                                </div>

                                <div class="section-header">PERSONAL INFORMATION</div>
                                <table class="table table-sm detail-table table-borderless">
                                    <tr>
                                        <td class="info-label">Last Name:</td>
                                        <td>{{ $speaker->last_name }}</td>
                                        <td class="info-label">Given Name:</td>
                                        <td>{{ $speaker->given_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Middle Name:</td>
                                        <td>{{ $speaker->middle_name ?? 'N/A' }}</td>
                                        <td class="info-label">Name Ext'n:</td>
                                        <td>{{ $speaker->ext_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Date of Birth:</td>
                                        <td>{{ $speaker->date_of_birth ?? 'N/A' }}</td>
                                        <td class="info-label">Place of Birth:</td>
                                        <td>{{ $speaker->place_of_birth ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Age:</td>
                                        <td>{{ $speaker->age ?? 'N/A' }}</td>
                                        <td class="info-label">Gender:</td>
                                        <td>{{ $speaker->gender ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                                <div class="section-header">EMPLOYMENT INFORMATION</div>
                                <table class="table table-sm detail-table table-borderless">
                                    <tr>
                                        <td class="info-label">Office/Organization:</td>
                                        <td colspan="3">{{ optional($speaker->office)->office_organization ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Position:</td>
                                        <td colspan="3">{{ optional($speaker->office)->position ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                                <div class="section-header">OFFICE ADDRESS</div>
                                <table class="table table-sm detail-table table-borderless">
                                    <tr>
                                        <td class="info-label">Building No.:</td>
                                        <td>{{ optional($speaker->office)->building_no ?? 'N/A' }}</td>
                                        <td class="info-label">Street/Barangay:</td>
                                        <td>{{ optional($speaker->office)->barangay ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Municipality/City:</td>
                                        <td>{{ optional($speaker->office)->municipality ?? 'N/A' }}</td>
                                        <td class="info-label">Province:</td>
                                        <td>{{ optional($speaker->office)->province ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Zip Code:</td>
                                        <td>{{ optional($speaker->office)->zip_code ?? 'N/A' }}</td>
                                        <td class="info-label">Tel. No.:</td>
                                        <td>{{ optional($speaker->office)->tel_no ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Cellphone No.:</td>
                                        <td>{{ optional($speaker->office)->cell_no ?? 'N/A' }}</td>
                                        <td class="info-label">Fax No.:</td>
                                        <td>{{ optional($speaker->office)->fax_no ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                                <div class="section-header">HOME/RESIDENCE ADDRESS</div>
                                <table class="table table-sm detail-table table-borderless">
                                    <tr>
                                        <td class="info-label">Building No.:</td>
                                        <td>{{ $speaker->home_building_no ?? 'N/A' }}</td>
                                        <td class="info-label">Street/Barangay:</td>
                                        <td>{{ $speaker->home_barangay ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Municipality/City:</td>
                                        <td>{{ $speaker->home_municipality ?? 'N/A' }}</td>
                                        <td class="info-label">Province:</td>
                                        <td>{{ $speaker->home_province ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Zip Code:</td>
                                        <td>{{ $speaker->home_zip_code ?? 'N/A' }}</td>
                                        <td class="info-label">Tel. No.:</td>
                                        <td>{{ $speaker->home_tel_no ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Cellphone No.:</td>
                                        <td>{{ $speaker->home_cell_no ?? 'N/A' }}</td>
                                        <td class="info-label">Fax No.:</td>
                                        <td>{{ $speaker->home_fax_no ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                                <div class="section-header">CONTACT INFORMATION</div>
                                <table class="table table-sm detail-table table-borderless">
                                    <tr>
                                        <td class="info-label">E-mail Address:</td>
                                        <td colspan="3">{{ $speaker->email ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                                <div class="section-header">FIELD/S OF SPECIALIZATION/EXPERTISE</div>
                                <p class="ms-3">{{ $speaker->expertises->pluck('expertis')->implode(', ') ?: 'N/A' }}</p>

                                @php
                                    $educations = DB::table('rs_educational')->where('rs_id', $speaker->id)->get();
                                @endphp

                                @if($educations && $educations->count() > 0)
                                    <div class="section-header">EDUCATIONAL BACKGROUND</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><small>Level/Degree</small></th>
                                                    <th><small>From</small></th>
                                                    <th><small>To</small></th>
                                                    <th><small>School/Institution</small></th>
                                                    <th><small>Year Grad</small></th>
                                                    <th><small>Awards</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($educations as $education)
                                                    <tr>
                                                        <td><small>{{ $education->level ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $education->from_year ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $education->to_year ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $education->school ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $education->year_graduated ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $education->awards ?? 'N/A' }}</small></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if($speaker->workExperiences && $speaker->workExperiences->count() > 0)
                                    <div class="section-header">WORK EXPERIENCE</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><small>Date Started</small></th>
                                                    <th><small>Date Ended</small></th>
                                                    <th><small>Company/Organization</small></th>
                                                    <th><small>Position</small></th>
                                                    <th><small>Division</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($speaker->workExperiences as $work)
                                                    <tr>
                                                        <td><small>{{ $work->date_started ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $work->date_ended ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $work->name_company ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $work->position ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $work->division ?? 'N/A' }}</small></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if($speaker->trainings && $speaker->trainings->count() > 0)
                                <div class="section-header">TRAINING EXPERIENCE AS TRAINER</div>
                                <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><small>Training Title</small></th>
                                                    <th><small>Venue</small></th>
                                                    <th><small>Date</small></th>
                                                    <th><small>No. of Hours</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($speaker->trainings as $training)
                                                    <tr>
                                                        <td><small>{{ $training->rt_title ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $training->rt_venue ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $training->rt_date ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $training->rt_no_hours ?? 'N/A' }}</small></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if($speaker->experienceTrainer && $speaker->experienceTrainer->count() > 0)
                                    <div class="section-header">TRAINING/SEMINAR EXPERIENCE</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><small>Training Title</small></th>
                                                    <th><small>Venue</small></th>
                                                    <th><small>Date</small></th>
                                                    <th><small>No. of Hours</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($speaker->experienceTrainer as $experience)
                                                    <tr>
                                                        <td><small>{{ $experience->rst_title ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $experience->rst_venue ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $experience->rst_date ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $experience->rst_no_hours ?? 'N/A' }}</small></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if($speaker->publications && $speaker->publications->count() > 0)
                                    <div class="section-header">PUBLICATIONS</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><small>Publication Title</small></th>
                                                    <th><small>Date Published</small></th>
                                                    <th><small>Venue</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($speaker->publications as $publication)
                                                    <tr>
                                                        <td><small>{{ $publication->p_title ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $publication->p_date ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $publication->p_venue ?? 'N/A' }}</small></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if($speaker->referencesTrainings && $speaker->referencesTrainings->count() > 0)
                                    <div class="section-header">REFERENCES FOR TRAINING</div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><small>Name/Agency</small></th>
                                                    <th><small>Address</small></th>
                                                    <th><small>Contact Person</small></th>
                                                    <th><small>Position</small></th>
                                                    <th><small>Tel No.</small></th>
                                                    <th><small>Cell No.</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($speaker->referencesTrainings as $reference)
                                                    <tr>
                                                        <td><small>{{ $reference->name_agency ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $reference->address ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $reference->contact_person ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $reference->position ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $reference->tel_no ?? 'N/A' }}</small></td>
                                                        <td><small>{{ $reference->cell_no ?? 'N/A' }}</small></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Submit Evaluation
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
$(function () {

    // Initialize DataTable if available
    if ( $.fn.DataTable ) {
        $('#datatablesSimple').DataTable({
            "pageLength": 10,
            "ordering": true,
            "order": [[0, 'asc']],
            "columnDefs": [ { "orderable": false, "targets": [10] } ],
            "language": {
                "search": "Filter records:",
                "lengthMenu": "Show _MENU_ entries per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries available",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "paginate": { "first": "First", "last": "Last", "next": "Next", "previous": "Previous" }
            }
        });
    }

    // Bind to shown event for accreditation modals only
    $('.accreditation-modal').on('shown.bs.modal', function () {

        var modal = $(this);

        // Clear previous values
        modal.find('.score-box').each(function () {
            if ($(this).data('keep') !== true) {
                $(this).val('');
            }
        });
        modal.find('.total-input').val('');
        modal.find('.pass-fail-status').text('').removeClass('text-success text-danger');

        // detach previous handlers to avoid duplicates
        modal.find('.score-box').off('input.accreditationCalc');

        // attach handler (namespaced)
        modal.find('.score-box').on('input.accreditationCalc', function () {
            var total = 0;
            modal.find('.score-box').each(function () {
                var v = parseFloat($(this).val());
                if (!isNaN(v) && isFinite(v)) total += v;
            });

            // write total (rounded to integer)
            total = Math.round(total);
            modal.find('.total-input').val(total);

            // update pass/fail
            var statusEl = modal.find('.pass-fail-status');
            var statusInput = modal.find('input[name="status"]');

            if (total >= 75) {
                statusEl.text('PASSED').removeClass('text-danger').addClass('text-success');
                statusInput.val('Passed');
            } else {
                statusEl.text('FAILED').removeClass('text-success').addClass('text-danger');
                statusInput.val('Failed');
            }
        });

        // Trigger once to initialize total
        modal.find('.score-box').first().trigger('input.accreditationCalc');
    });

});
</script>
@endsection
