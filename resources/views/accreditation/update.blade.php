@extends('layouts.admin')

@section('content')

<style>
    .criteria-box {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        background: #fff;
    }
    .criteria-header {
        font-size: 17px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .score-input {
        width: 90px;
        float: right;
        padding: 5px;
        font-size: 16px;
        text-align: center;
    }
    .total-box {
        width: 90px;
        padding: 8px;
        font-size: 18px;
        background: #fff6cc;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
    }
    .jio { pointer-events: none; }
</style>

<div class="col-md-12 mt-4 card card-default">
    <div class="card-header">
        <strong>Update Accreditation</strong>
    </div>

    <div class="card-body">

        <form action="{{ route('accreditation.update', $accreditation->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Speaker Details --}}
            <div class="mb-4">
                <label>Resource Speaker</label>
                <input type="text" class="form-control jio"
                    value="{{ $accreditation->speaker->given_name }} {{ $accreditation->speaker->last_name }}" readonly>

                <input type="hidden" name="rstbl_id" value="{{ $accreditation->speaker->id }}">

                <label class="mt-3">Field of Expertise</label>
                <input type="text" class="form-control jio"
                       value="{{ $accreditation->field_of_expertise }}" readonly>
            </div>

            {{-- ============================ CRITERIA BOXES ============================ --}}

            {{-- 1.0 EDUCATIONAL QUALIFICATIONS --}}
            <div class="criteria-box">
                <div class="criteria-header">1.0 Relevant Educational Qualifications – 30 points
                    <input type="number" name="education" class="score-input score-box"
                           value="{{ $accreditation->education }}">
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

            {{-- 2.0 WORK EXPERIENCE --}}
            <div class="criteria-box">
                <div class="criteria-header">2.0 Relevant Work Experience – 30 points
                    <input type="number" name="work" class="score-input score-box"
                           value="{{ $accreditation->work }}">
                </div>
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

            {{-- 3.0 TRAININGS --}}
            <div class="criteria-box">
                <div class="criteria-header">3.0 Relevant Trainings/Seminars Attended – 20 points
                    <input type="number" name="seminar" class="score-input score-box"
                           value="{{ $accreditation->seminar }}">
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

            {{-- 4.0 TRAINER EXPERIENCE --}}
            <div class="criteria-box">
                <div class="criteria-header">4.0 Experience As Trainer/ Resource Person – 10 points
                    <input type="number" name="experience" class="score-input score-box"
                           value="{{ $accreditation->experience }}">
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

            {{-- 5.0 TECHNICAL MERITS --}}
            <div class="criteria-box">
                <div class="criteria-header">5.0 Relevant Technical Merits – 10 points
                    <input type="number" name="award" class="score-input score-box"
                           value="{{ $accreditation->award }}">
                </div>
                <div class="col-md-10">
                <div class="d-flex justify-content-between">
                  <div>National Recognitions/ Awards/ Publications </div><div>(10)</div>
                </div>
                <div class="d-flex justify-content-between">
                  <div>Local Recognition/ Awards/ Publications </div><div>(5)</div>
                </div>
                    </div>
            </div>

            {{-- ============================ TOTAL SECTION ============================ --}}

                                <!-- Total -->
                    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                        <div><strong>TOTAL</strong></div>
                        <div class="d-flex align-items-center">
                            <input type="number" name="total" class="form-control total-input" readonly value="">
                        </div>
                    </div>
            <div class="mt-4">
                <p class="mt-2">
                    <em>Note: Standard Passing Score is 75 points.</em>
                    <span class="pass-fail-status fw-bold"></span>
                </p>
            </div>

            <input type="hidden" name="training_title_rs" value="{{ $accreditation->training_title_rs }}">
            <input type="hidden" name="status" value="{{ $accreditation->status }}">
            <input type="hidden" name="updated_by" value="{{ auth()->id() }}">

            <button type="submit" class="btn btn-success mt-3">Update Accreditation</button>
        </form>

    </div>
</div>

@endsection


@section('scripts')
<script>
$(document).ready(function () {

    function calculateTotal() {
        let total = 0;

        $('.score-box').each(function () {
            let val = parseFloat($(this).val());
            if (!isNaN(val)) total += val;
        });

        $('input[name="total"]').val(total);

        const status = $('.pass-fail-status');

        if (total >= 75) {
            status.text('PASSED').removeClass('text-danger').addClass('text-success');
        } else {
            status.text('FAILED').removeClass('text-success').addClass('text-danger');
        }
    }

    $('.score-box').on('input', calculateTotal);

    calculateTotal();
});
</script>
@endsection
