@extends('layouts.admin')

@section('content')

<style>
    .jio {
        pointer-events: none;
    }
</style>

<div class="col-md-12 mt-4 card card-default color-palette-box">
    <div class="card-header">
        <div class="card-title card-info">
            <strong>Update Accreditation</strong>
        </div>
        <hr>
        <div class="card-body">
            <form action="{{ route('accreditation.update', $accreditation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                <input type="hidden" name="training_title_rs" value="{{ $accreditation->training_title_rs }}">

                        <!-- Speaker Dropdown -->
                        <label class="form-label">Speaker</label>
                        <select name="rstbl_id" id="rstbl_id" class="form-select select2" required>
                            <option value="">Select Speaker</option>
                            @foreach($speakers as $speaker)
                                <option value="{{ $speaker->id }}"
                                        data-expertise="{{ $speaker->expertises->pluck('expertis')->implode(', ') }}"
                                    {{ $accreditation->rstbl_id == $speaker->id ? 'selected' : '' }}>
                                    {{ $speaker->given_name }} {{ $speaker->last_name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Field of Expertise -->
                        <label class="form-label mt-3">Field of Expertise</label>
                        <input type="text" name="field_of_expertise" id="field_of_expertise" class="form-control jio"
                               value="{{ $accreditation->field_of_expertise }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Education</label>
                        <input type="number" name="education" class="form-control score-box" value="{{ $accreditation->education }}">

                        <label class="form-label mt-3">Work</label>
                        <input type="number" name="work" class="form-control score-box" value="{{ $accreditation->work }}">

                        <label class="form-label mt-3">Seminar</label>
                        <input type="number" name="seminar" class="form-control score-box" value="{{ $accreditation->seminar }}">

                        <label class="form-label mt-3">Experience</label>
                        <input type="number" name="experience" class="form-control score-box" value="{{ $accreditation->experience }}">

                        <label class="form-label mt-3">Award</label>
                        <input type="number" name="award" class="form-control score-box" value="{{ $accreditation->award }}">

                        <label class="form-label mt-3">Total</label>
                        <input type="number" name="total" class="form-control score-box jio" value="{{ $accreditation->total }}" readonly>

                        <p class="mt-2"><em>Note: Standard Passing Score is 75 points.</em>
                            <span class="pass-fail-status fw-bold"></span>
                        </p>
                    </div>
                <input type="hidden" name="status" value="{{ $accreditation->status }}" readonly>
                <input type="hidden" name="updated_by" value="{{ auth()->id() }}">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Update Accreditation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include Select2 CSS/JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize Select2 on speaker dropdown
        $('#rstbl_id').select2({
            placeholder: 'Select Speaker',
            allowClear: true
        });

        // Set expertise when a speaker is selected
        $('#rstbl_id').on('change', function () {
            const selectedOption = $(this).find(':selected');
            const expertise = selectedOption.data('expertise') || '';
            $('#field_of_expertise').val(expertise);
        });

        // Score calculation
        $('.score-box').on('input', function () {
            let total = 0;
            $('input.score-box[name]:not([name="total"])').each(function () {
                const val = parseFloat($(this).val());
                if (!isNaN(val)) {
                    total += val;
                }
            });

            $('input[name="total"]').val(total);

            const statusEl = $('.pass-fail-status');
            if (total >= 75) {
                statusEl.text('PASSED').removeClass('text-danger').addClass('text-success');
            } else {
                statusEl.text('FAILED').removeClass('text-success').addClass('text-danger');
            }
        });

        // Trigger calculation on load
        $('.score-box').first().trigger('input');

        // Pre-fill field of expertise on load
        $('#rstbl_id').trigger('change');
    });
</script>
@endsection
