@extends('layouts.admin')

@section('content')
    <div class="card mb-4 mt-4">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <div class="col-md-6" style="color: white">
                <i class="fas fa-table me-1"></i>
                List of Accredited
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Speaker Name</th>
                        <th>Field of Expertise</th>
                        <th>Education</th>
                        <th>Work</th>
                        <th>Seminar</th>
                        <th>Experience</th>
                        <th>Award</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accredited as $trainer)
                        <tr>
                            {{-- Speaker Name --}}
                            <td id="avgSpeaker">
                                <a href="{{ route('resource_speaker.view', optional($trainer->speaker)->id) }}" style="text-decoration:none">
                                    {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                                </a>
                            </td>
                            {{-- Field of Expertise --}}
                            <td id="avgExpertise">
                                {{ $trainer->speaker->expertises->pluck('expertis')->implode(', ') ?: 'N/A' }}
                            </td>
                            {{-- Averages --}}
                            <td id="avgEducation">{{ $trainer->avg_education }}</td>
                            <td id="avgWork">{{ $trainer->avg_work }}</td>
                            <td id="avgSeminar">{{ $trainer->avg_seminar }}</td>
                            <td id="avgExperience">{{ $trainer->avg_experience }}</td>
                            <td id="avgAward">{{ $trainer->avg_award }}</td>
                            <td id="avgTotal">{{ $trainer->avg_total }}</td>
                            <td>
                                {{-- Print Button - Opens PDF in Modal --}}
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#printPdfModal-{{ $trainer->id }}">
                                    <i class="fa-solid fa-print"></i>
                                </button>
                                {{-- View Raw Scores --}}
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accreditationModal-{{ $trainer->id }}">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-success"></div>
    </div>
    {{-- Raw Scores Modal --}}
    @foreach($accredited as $trainer)
        <div class="modal fade" id="accreditationModal-{{ $trainer->id }}" tabindex="-1" aria-labelledby="accreditationModalLabel-{{ $trainer->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="accreditationModalLabel-{{ $trainer->id }}">
                            Raw Accreditation Scores - {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($trainer->rawAccreditations->isEmpty())
                            <p class="text-center">No raw accreditation scores available for this trainer.</p>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>Education</th>
                                        <th>Work</th>
                                        <th>Seminar</th>
                                        <th>Experience</th>
                                        <th>Award</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trainer->rawAccreditations as $raw)
                                        <tr>
                                            <td>{{ $raw->education }}</td>
                                            <td>{{ $raw->work }}</td>
                                            <td>{{ $raw->seminar }}</td>
                                            <td>{{ $raw->experience }}</td>
                                            <td>{{ $raw->award }}</td>
                                            <td>{{ $raw->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- PDF Preview Modal - Original Size (modal-xl), Resizable, With Controls --}}
        <div class="modal fade" id="printPdfModal-{{ $trainer->id }}" tabindex="-1" aria-labelledby="printPdfModalLabel-{{ $trainer->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-resizable">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="printPdfModalLabel-{{ $trainer->id }}">
                            Accreditation Average Report - {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0" style="height: 80vh;">
                        <iframe
                            id="pdfIframe-{{ $trainer->id }}"
                            src="{{ route('accreditation.average.print', $trainer->id) }}"
                            style="width: 100%; height: 100%; border: none;"
                            title="PDF Preview">
                        </iframe>
                    </div>
                    <div class="modal-footer bg-light py-2 d-flex justify-content-start gap-4 align-items-center">
                        <div class="d-flex align-items-center">
                            <label for="fontScaleInput-{{ $trainer->id }}" class="me-2 mb-0 small text-muted">Font (%):</label>
                            <input
                                type="number"
                                id="fontScaleInput-{{ $trainer->id }}"
                                class="form-control form-control-sm"
                                style="width: 75px;"
                                value="100"
                                min="-100"
                                max="150"
                                step="1"
                            >
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="paperSize-{{ $trainer->id }}" class="me-2 mb-0 small text-muted">Paper:</label>
                            <select id="paperSize-{{ $trainer->id }}" class="form-select form-select-sm" style="width: auto;">
                                <option value="A4">A4</option>
                                <option value="Letter" selected>Letter</option>
                                <option value="Legal">Legal</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('styles')
    <style>
        /* Make modal resizable */
        .modal-dialog-resizable {
            resize: both;
            overflow: auto;
        }
        .modal-dialog-resizable .modal-content {
            overflow: hidden;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Initialize DataTables
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('datatablesSimple');
            if (table) {
                new simpleDatatables.DataTable(table);
            }
        });

        // Update iframe src with query params on change
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function () {
                const target = this.getAttribute('data-bs-target');
                const modal = document.querySelector(target);
                if (modal && target.includes('printPdfModal')) {
                    modal.addEventListener('shown.bs.modal', function () {
                        const iframe = this.querySelector('iframe');
                        const fontInput = this.querySelector('input[id^="fontScaleInput-"]');
                        const paperSelect = this.querySelector('select[id^="paperSize-"]');
                        const baseSrc = iframe.src; // Original route without params

                        function updatePdf() {
                            let font = parseInt(fontInput.value, 10);
                            if (isNaN(font) || font < -100) font = -100;
                            if (font > 150) font = 150;
                            const paper = paperSelect.value;
                            iframe.src = baseSrc + `?font=${font}&paper=${paper}`;
                        }

                        fontInput.addEventListener('input', updatePdf);
                        paperSelect.addEventListener('change', updatePdf);
                    });
                }
            });
        });
    </script>
@endsection