@extends('layouts.admin')http://127.0.0.1:8000/home

@section('content')

<style>
    .jio {
        pointer-events: none;
        border-right: none;
        border-left: none;
        border-top: none;
    }

    .form-box {
        padding: 15px;
        margin-bottom: 20px;
    }

    .score-box {
        width: 80px;
        border-bottom: 1px solid #000;
        display: inline-block;
    }

    .section-title {
        font-weight: bold;
    }

    .rating-box {
        border-top: 1px solid #000;
        padding-top: 10px;
        margin-top: 30px;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;
        position: absolute;
        z-index: 1;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
    }
</style>

<div class="container-fluid px-4">
 @if (session('success'))
    <div class="alert alert-success position-fixed top-0 end-0 m-4 shadow" id="success-alert" style="z-index: 1055;">
        {{ session('success') }}
    </div>

    <script>
        // Auto-hide after 5 seconds
        setTimeout(function () {
            $('#success-alert').fadeOut('slow');
        }, 5000);
    </script>
@endif


    <div class="card mb-12 mt-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-user me-1"></i>
                List of To Be Accredited
            </div>
            <div>
           <button type="button" id="getAverageBtn" class="btn btn-primary">
                <i class="fa-solid fa-calculator"></i> Get Average
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accreditationModal">
                <i class="fa-solid fa-circle-plus"></i> Add
            </button>
        </div>
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped table-bordered">
               <thead>
                    <tr>
                        <th>Select</th>
                        <th>Speaker Name</th>
                        <th>Field of Expertise</th>
                        <th>Education</th>
                        <th>Work</th>
                        <th>Seminar</th>
                        <th>Experience</th>
                        <th>Award</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                            @foreach ($trainers as $trainer)
                        <tr>
                                        <td><input type="checkbox" class="trainer-checkbox" value="{{ $trainer->id }}"></td>
                                        <td>
                                            <a href="{{ route('resource_speaker.view', $trainer->rstbl_id) }}" style="text-decoration:none">
                                                {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                                            </a>
                                        </td>
                                        <td>{{ $trainer->field_of_expertise }}</td>
                                        <td>{{ $trainer->education }}</td>
                                        <td>{{ $trainer->work }}</td>
                                        <td>{{ $trainer->seminar }}</td>
                                        <td>{{ $trainer->experience }}</td>
                                        <td>{{ $trainer->award }}</td>
                                        <td>{{ $trainer->total }}</td>
                                <td>
                                    <!-- Actions -->
                                    <a href="{{ route('accreditation.edit', $trainer->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accreditationModal-{{ $trainer->id }}">
                                   <i class="fa-regular fa-eye"></i>
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('accreditation.destroy', $trainer->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-btn"
                                        data-name="{{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                <!-- Trigger Modal Button -->
                           <!-- Trigger Modal Button -->
                                            {{-- <button type="button" class="btn btn-sm btn-info" onclick="loadPDF({{ $trainer->id }})" data-bs-toggle="modal" data-bs-target="#pdfModal-{{ $trainer->id }}">
                                                <i class="fa-solid fa-print"></i>
                                            </button> --}}
<a href="{{ route('accreditation.print', $trainer->id) }}" target="_blank" class="btn btn-sm btn-info"> <i class="fa-solid fa-print"></i></a>

                                {{-- <button type="button" class="btn btn-sm btn-info" onclick="loadPDF({{ $trainer->id }})" data-bs-toggle="modal" data-bs-target="#pdfModal-{{ $trainer->id }}">
                                        <i class="fa-solid fa-print"></i>
                                        </button>

                                <form method="GET" action="{{ route('accreditation.print', ['id' => $trainer->id]) }}" target="_blank">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-print"></i> Print PDF
                                    </button>
                                </form> --}}


                                    </td>
                            </tr>

                            <!-- Modal for displaying PDF -->
                            <div class="modal fade" id="pdfModal-{{ $trainer->id }}" tabindex="-1" aria-labelledby="pdfModalLabel-{{ $trainer->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pdfModalLabel-{{ $trainer->id }}">
                                                Accreditation PDF - {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <div id="pdfLoader-{{ $trainer->id }}" class="text-center p-4">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <p class="mt-2">Loading PDF...</p>
                                            </div>
                                            <iframe id="pdfFrame-{{ $trainer->id }}" src="" style="width:100%; height:80vh; display:none;" frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>

              <!-- Dynamic Modal Per Trainer -->
                        <div class="modal fade" id="accreditationModal-{{ $trainer->id }}" tabindex="-1" aria-labelledby="accreditationModalLabel-{{ $trainer->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('accreditation.create') }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="modal-title">Accreditation Form</h5>
                                            </div>

                                            <div class="d-flex flex-column align-items-end">
                                                <!-- Close button at top -->
                                                <button type="button" class="btn-close mb-2" data-bs-dismiss="modal" aria-label="Close"></button>


                                                {{-- <a href="{{ route('accreditation.print', $trainer->id) }}" class="btn btn-success btn-sm" target="_blank">Print</a> --}}
                                            </div>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="rstbl_id" class="form-control jio" value="{{ $trainer->rstbl_id ?? $trainer->speaker->id }}">

                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Name of Applicant:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control jio" value="{{ $trainer->speaker->given_name ?? '' }} {{ $trainer->speaker->last_name ?? '' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Field of Expertise:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="field_of_expertise" class="form-control jio" value="{{ $trainer->speaker->expertises->pluck('expertis')->implode(', ') }}" readonly>
                                                </div>
                                            </div>

                                                <!-- 1.0 Education -->
                                                <div class="form-box">
                                                    <div class="d-flex justify-content-between">
                                                    <p class="section-title">1.0 Relevant Educational Qualifications – 30 points</p>
                                                    <input type="number" name="education" class="form-control jio score-box" value="{{ $trainer->education }}">
                                                    </div>
                                                    <div class="col-md-10">
                                                    <div class="d-flex justify-content-between">
                                                    <div>Technical/ Vocational Course </div><div>(15)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>Bachelor's Degree </div><div>(20)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>Master's Degree </div><div>(25)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>Doctorate Degree </div><div>(30)</div>
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- 2.0 Work Experience -->
                                                <div class="form-box">
                                                    <div class="d-flex justify-content-between">
                                                    <p class="section-title">2.0 Relevant Work Experience – 30 points</p>
                                                    <input type="text" name="work" class="form-control jio score-box" value="{{ $trainer->work }}">
                                                    </div>
                                                    <p>As Industry Practitioner/ Technical Specialist</p>
                                                    <div class="col-md-10">
                                                    <div class="d-flex justify-content-between">
                                                    <div>At least two (2) years </div><div>(20)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>Three (3) to five (5) years</div><div> (25)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>More than five (5) years </div><div>(30)</div>
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- 3.0 Seminars -->
                                                <div class="form-box">
                                                    <div class="d-flex justify-content-between">
                                                    <p class="section-title">3.0 Relevant Trainings/Seminars Attended – 20 points</p>
                                                    <input type="text" name="seminar" class="form-control jio score-box" value="{{ $trainer->seminar }}">
                                                    </div>
                                                    <div class="col-md-10">
                                                    <div class="d-flex justify-content-between">
                                                    <div>40 – 80 hours </div><div>(10)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>81 – 120 hours </div><div>(15)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>121 hours and above </div><div>(20)</div>
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- 4.0 Experience as Trainer -->
                                                <div class="form-box">
                                                    <div class="d-flex justify-content-between">
                                                    <p class="section-title">4.0 Experience As Trainer/ Resource Person – 10 points</p>
                                                <input type="text" name="experience" class="form-control jio score-box" value="{{ $trainer->experience }}">
                                                    </div>
                                                    <div class="col-md-10">
                                                    <div class="d-flex justify-content-between">
                                                    <div>Conducted training/lecture for at least 30 hrs or</div>
                                                    <div> (10)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>recognized as trainer by institutions on specific subject matter </div>
                                                    <div>(5)</div>
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- 5.0 Technical Merits -->
                                                <div class="form-box">
                                                    <div class="d-flex justify-content-between">
                                                    <p class="section-title">5.0 Relevant Technical Merits – 10 points</p>
                                                <input type="text" name="award" class="form-control jio score-box" value="{{ $trainer->award }}">
                                                    </div>
                                                    <div class="col-md-10">
                                                    <div class="d-flex justify-content-between">
                                                    <div>National Recognitions/ Awards/ Publications </div><div>(10)</div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                    <div>Local Recognition/ Awards/ Publications </div><div>(5)</div>
                                                    </div>
                                                </div>

                                                <!-- Total -->
                                                <div class="d-flex justify-content-between mb-3 mt-5">
                                                    <div><strong>TOTAL</strong></div>
                                                    <input type="text" name="total" class="form-control score-box jio" value="{{ $trainer->total }}" min="0" max="100">
                                                </div>
                                                <p><em>Note: Standard Passing Score is 75 points.</em>
                                                    <span class="fw-bold pass-fail-status">
                                                            @if (is_numeric($trainer->total))
                                                                @if ($trainer->total >= 75)
                                                                    <span class="text-success">PASSED</span>
                                                                @else
                                                                    <span class="text-danger">FAILED</span>
                                                                @endif
                                                            @endif
                                                        </span>
                                                    </p>

                                            <!-- Rated By Section -->
                                            {{-- <div class="row rating-box">
                                                @for ($i = 0; $i < 2; $i++)
                                                    <div class="col-md-6">
                                                        <p>Rated by:</p>
                                                        <div class="mb-2">Signature: _________________________</div>
                                                        <div class="mb-2">Printed Name: _____________________</div>
                                                        <div class="mb-2">Designation: _______________________</div>
                                                        <div class="mb-2">Date: _____________________________</div>
                                                    </div>
                                                @endfor
                                            </div> --}}
                                        </div>
                                    </div>
                                        <div class="modal-footer bg-light">
                                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                            <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                        <!-- End Modal -->

                            @endforeach

                </tbody>

            </table>
        </div>
<div class="card-footer bg-success"></div>

    </div>

</div>

</div>

<!-- Accreditation Modal -->
<div class="modal fade" id="accreditationModal" tabindex="-1" aria-labelledby="accreditationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form action="{{ route('accreditation.create') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-info text-white">
            <h5 class="modal-title">Accreditation Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
                <h5>CRITERIA FOR ACCREDITATION OF TRAINERS/ <br>
                RESOURCE SPEAKERS/ SUBJECT MATTER <br>
                SPECIALISTS</h5>
              </div>
                    <input type="hidden" name="rstbl_id" id="rstbl_id">

              <!-- Speaker Dropdown -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Select Speaker:</label>
                    <div class="col-sm-9">
                        <select id="speakerDropdown" class="form-select select2" name="rstbl_id" required>
                            <option disabled selected>-- Select Speaker --</option>
                            @foreach ($speakers as $speaker)
                                <option value="{{ $speaker->id }}"
                                    data-given_name="{{ $speaker->given_name }}"
                                    data-last_name="{{ $speaker->last_name }}"
                                    data-expertises='@json($speaker->expertises->pluck("expertis"))'>
                                    {{ $speaker->given_name }} {{ $speaker->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

{{--
                    <!-- Training Title Dropdown -->
                    <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Training Title:</label>
                    <div class="col-sm-9">
                    <select id="trainingTitleDropdown" class="form-select select2" name="training_title_rs">
                        <option disabled selected>-- Select Training --</option>
                        @foreach ($requests as $req)
                            <option value="{{ $req->id }}">{{ $req->training_title }}</option>
                        @endforeach
                    </select>

                    </div>
                    </div> --}}

                    <!-- Hidden RSTBL ID -->
                    <!-- Speaker Dropdown (disabled, just display) -->
                    {{-- <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Speaker:</label>
                    <div class="col-sm-9">
                        <select id="speakerDropdown" class="form-select" disabled>
                        <option disabled selected>-- Select Speaker --</option>
                        @foreach ($speakers as $speaker)
                            <option value="{{ $speaker->id }}">{{ $speaker->given_name }} {{ $speaker->last_name }}</option>
                        @endforeach
                        </select>
                    </div>
                    </div> --}}

                    <!-- Applicant Name (readonly) -->
                 <!-- Applicant Name (readonly) -->
                            <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name of Applicant:</label>
                            <div class="col-sm-9">
                                <input type="text" id="applicantName" class="form-control" readonly>
                            </div>
                            </div>

                            <!-- Expertise (readonly) -->
                            <div class="mb-4 row">
                            <label class="col-sm-3 col-form-label">Field of Expertise:</label>
                            <div class="col-sm-9">
                                <input type="text" name="field_of_expertise" id="fieldOfExpertise" class="form-control" readonly>
                            </div>
                            </div>



              <!-- 1.0 Education -->
              <div class="form-box">
                <div class="d-flex justify-content-between">
                <p class="section-title">1.0 Relevant Educational Qualifications – 30 points</p>
                <input type="number" name="education" class="form-control score-box">
                </div>
                <div class="col-md-10">
                <div class="d-flex justify-content-between">
                  <div>Technical/ Vocational Course </div><div>(15)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>Bachelor's Degree </div><div>(20)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>Master's Degree </div><div>(25)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>Doctorate Degree </div><div>(30)</div>
                </div>
                </div>
              </div>

              <!-- 2.0 Work Experience -->
              <div class="form-box">
                <div class="d-flex justify-content-between">
                <p class="section-title">2.0 Relevant Work Experience – 30 points</p>
                <input type="number" name="work" class="form-control score-box">
                </div>
                <p>As Industry Practitioner/ Technical Specialist</p>
                <div class="col-md-10">
                <div class="d-flex justify-content-between">
                  <div>At least two (2) years </div><div>(20)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>Three (3) to five (5) years</div><div> (25)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>More than five (5) years </div><div>(30)</div>
                </div>
                </div>
              </div>

              <!-- 3.0 Seminars -->
              <div class="form-box">
                <div class="d-flex justify-content-between">
                <p class="section-title">3.0 Relevant Trainings/Seminars Attended – 20 points</p>
                <input type="number" name="seminar" class="form-control score-box">
                </div>
                <div class="col-md-10">
                <div class="d-flex justify-content-between">
                  <div>40 – 80 hours </div><div>(10)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>81 – 120 hours </div><div>(15)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>121 hours and above </div><div>(20)</div>
                </div>
                </div>
              </div>

              <!-- 4.0 Experience as Trainer -->
              <div class="form-box">
                <div class="d-flex justify-content-between">
                <p class="section-title">4.0 Experience As Trainer/ Resource Person – 10 points</p>
              <input type="number" name="experience" class="form-control score-box">
                </div>
                <div class="col-md-10">
                <div class="d-flex justify-content-between">
                  <div>Conducted training/lecture for at least 30 hrs or</div>
                  <div> (10)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>recognized as trainer by institutions on specific subject matter </div>
                  <div>(5)</div>
                </div>
                </div>
              </div>

              <!-- 5.0 Technical Merits -->
              <div class="form-box">
                <div class="d-flex justify-content-between">
                <p class="section-title">5.0 Relevant Technical Merits – 10 points</p>
              <input type="number" name="award" class="form-control score-box">
                </div>
                <div class="col-md-10">
                <div class="d-flex justify-content-between">
                  <div>National Recognitions/ Awards/ Publications </div><div>(10)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>Local Recognition/ Awards/ Publications </div><div>(5)</div>
                </div>
              </div>

            <!-- Total -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
                <div><strong>TOTAL</strong></div>
                <div class="d-flex align-items-center gap-2">
                    <input type="number" name="total" class="form-control score-box total-input" readonly>
                </div>
            </div>
            <p><em>Note: Standard Passing Score is 75 points.</em>
                    <span class="pass-fail-status fw-bold"></span>
            </p>

            <br><hr>


            <div class="input-group mb-3">
                <input type="hidden" class="form-control" name="status" id="status" value="0" >
                </div>
                                            {{-- <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Status:</label>
                                <div class="col-sm-9">
                                    <select id="status" class="form-select select2" name="status" required>
                                    <option disabled selected>-- Select Status --</option>
                                        <option value="0">To be acrredated</option>
                                    </select>
                                </div>
                                </div> --}}
              <!-- Rated by -->
              {{-- <div class="row rating-box">
                <div class="col-md-6">
                  <p>Rated by:</p>
                  <div class="mb-2">Signature: _________________________</div>
                  <div class="mb-2">Printed Name: _____________________</div>
                  <div class="mb-2">Designation: _______________________</div>
                  <div class="mb-2">Date: _____________________________</div>
                </div>
                <div class="col-md-6">
                  <p>Rated by:</p>
                  <div class="mb-2">Signature: _________________________</div>
                  <div class="mb-2">Printed Name: _____________________</div>
                  <div class="mb-2">Designation: _______________________</div>
                  <div class="mb-2">Date: _____________________________</div>
                </div>
              </div> --}}
                                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">


          </div>
          <div class="modal-footer bg-light">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>






@endsection


@section('scripts')
<script>
$(document).ready(function () {
    $('#accreditationModal').on('shown.bs.modal', function () {
        // Initialize Select2 inside the modal
        $('#speakerDropdown').select2({
            dropdownParent: $('#accreditationModal'),
            placeholder: '-- Select Speaker --',
            allowClear: true,
            width: '100%'
        });

        // Reset form fields
        $('.score-box').not('[name="total"]').val('');
        $('input[name="total"]').val('');
        $('.pass-fail-status').text('').removeClass('text-success text-danger');

        // Calculate total score dynamically
        $('.score-box').off('input').on('input', function () {
            let total = 0;
            $('input.score-box[name]:not([name="total"])').each(function () {
                const val = parseFloat($(this).val());
                if (!isNaN(val)) total += val;
            });

            $('input[name="total"]').val(total);

            const status = $('.pass-fail-status');
            if (total >= 75) {
                status.text('PASSED').removeClass('text-danger').addClass('text-success');
            } else {
                status.text('FAILED').removeClass('text-success').addClass('text-danger');
            }
        });

        $('.score-box').first().trigger('input');
    });

    // Handle speaker selection change
    $('#speakerDropdown').on('change', function () {
        const selected = $(this).find('option:selected');
        const fullName = selected.data('given_name') + ' ' + selected.data('last_name');
        const expertisesRaw = selected.data('expertises');

        // Parse and display expertise fields
        let expertiseText = '';
        try {
            const expertises = Array.isArray(expertisesRaw) ? expertisesRaw : JSON.parse(expertisesRaw);
            expertiseText = expertises.join(', ');
        } catch (e) {
            expertiseText = '';
        }

        $('#applicantName').val(fullName);
        $('#fieldOfExpertise').val(expertiseText);
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                const name = form.querySelector('.delete-btn').getAttribute('data-name');
                const confirmed = confirm(`Are you sure you want to delete ${name}?`);

                if (!confirmed) {
                    e.preventDefault(); // Cancel form submission
                }
            });
        });
    });
</script>
<script>
    function loadPDF(trainerId) {
        const loader = document.getElementById('pdfLoader-' + trainerId);
        const iframe = document.getElementById('pdfFrame-' + trainerId);
        loader.style.display = 'block';
        iframe.style.display = 'none';
        iframe.src = "{{ route('accreditation.print', '') }}/" + trainerId;

        // Show iframe when loaded
        iframe.onload = function () {
            loader.style.display = 'none';
            iframe.style.display = 'block';
        };
    }
</script>


<script>
document.addEventListener("DOMContentLoaded", () => {
  const avgBtn = document.getElementById("getAverageBtn");
  if (!avgBtn) {
    console.error("Button #getAverageBtn not found");
    return;
  }

  avgBtn.addEventListener("click", async () => {
    console.log("Get Average button clicked");

    // Get checked checkboxes
    const checked = document.querySelectorAll("#datatablesSimple tbody input[type='checkbox']:checked");
    console.log(`Found ${checked.length} checked boxes`);

    if (!checked.length) {
      alert("Please select at least one row to process.");
      return;
    }

    // Get IDs from checked rows
    const ids = Array.from(checked).map(cb => cb.value);
    console.log('Selected IDs:', ids);

    // Show confirmation
    if (!confirm(`You are about to approve ${checked.length} accreditation record(s). Continue?`)) {
      return;
    }

    // Disable button
    avgBtn.disabled = true;
    avgBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

    try {
      console.log("Sending request to server...");

      const response = await fetch("{{ route('accreditation.approve') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ ids })
      });

      console.log("Response status:", response.status);

      const responseText = await response.text();
      console.log("Raw response:", responseText);

      let data;
      try {
        data = JSON.parse(responseText);
      } catch (parseError) {
        console.error("JSON parse error:", parseError);
        throw new Error(`Invalid JSON response: ${responseText.substring(0, 200)}...`);
      }

      if (!response.ok) {
        console.error("Server error:", data);
        throw new Error(data.message || data.error || `HTTP ${response.status}`);
      }

      if (data.success) {
        console.log("Success:", data);

        let msg = `✅ ${data.message}\n\n`;
        if (data.data && data.data.overall_averages) {
          msg += "Overall Averages:\n";
          const avg = data.data.overall_averages;
          msg += `Education: ${avg.education}\n`;
          msg += `Work: ${avg.work}\n`;
          msg += `Seminar: ${avg.seminar}\n`;
          msg += `Experience: ${avg.experience}\n`;
          msg += `Award: ${avg.award}\n`;
          msg += `Total: ${avg.total}`;
        }

        alert(msg);

        // Ask to reload
        if (confirm("Reload page to see changes?")) {
          location.reload();
        }
      } else {
        throw new Error(data.message || "Unknown error");
      }

    } catch (error) {
      console.error("Request failed:", error);
      alert(`❌ Error: ${error.message}\n\nCheck browser console for details.`);
    } finally {
      // Re-enable button
      avgBtn.disabled = false;
      avgBtn.innerHTML = '<i class="fa-solid fa-circle-plus"></i> Get Average';
    }
  });
});
</script>
@endsection
