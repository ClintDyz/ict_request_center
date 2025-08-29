<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: helvetica; font-size: 10pt; }
        .section-title { font-weight: bold; margin-top: 10px; }
        .score-box { float: right; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 4px; vertical-align: top; }
    </style>
</head>
<body>
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
                                                    <input type="text" name="field_of_expertise" class="form-control jio" value="{{ $trainer->speaker->expertise ?? '' }}" readonly>
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
                                            <div class="row rating-box">
                                                @for ($i = 0; $i < 2; $i++)
                                                    <div class="col-md-6">
                                                        <p>Rated by:</p>
                                                        <div class="mb-2">Signature: _________________________</div>
                                                        <div class="mb-2">Printed Name: _____________________</div>
                                                        <div class="mb-2">Designation: _______________________</div>
                                                        <div class="mb-2">Date: _____________________________</div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
</body>
</html>
