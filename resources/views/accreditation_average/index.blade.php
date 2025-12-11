@extends('layouts.admin')

@section('content')
    <div class="card mb-4 mt-4">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <div class="col-md-6" style="color: white">
                <i class="fas fa-table me-1"></i>
                Evaluated SMS
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
                        <th>Status</th>
                        <th>Evaluation Team</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accredited as $trainer)
                        <tr>
                            {{-- Speaker Name --}}
                            <td>
                                <a href="{{ route('resource_speaker.view', optional($trainer->speaker)->id) }}" style="text-decoration:none">
                                    {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                                </a>
                            </td>
                            {{-- Field of Expertise --}}
                            <td>
                                {{ $trainer->speaker->expertises->pluck('expertis')->implode(', ') ?: 'N/A' }}
                            </td>
                            {{-- Averages --}}
                            <td>{{ $trainer->avg_education }}</td>
                            <td>{{ $trainer->avg_work }}</td>
                            <td>{{ $trainer->avg_seminar }}</td>
                            <td>{{ $trainer->avg_experience }}</td>
                            <td>{{ $trainer->avg_award }}</td>
                            <td>{{ $trainer->avg_total }}</td>
                            <td>
                                @php
                                    $total = $trainer->avg_total;
                                @endphp

                                @if($total >= 75)
                                    <span class="badge bg-success">
                                        <i class="fa-solid fa-check-circle me-1"></i>Pass
                                    </span>
                                @elseif($total >= 70)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fa-solid fa-exclamation-triangle me-1"></i>Near Pass
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $total }} points</small>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fa-solid fa-times-circle me-1"></i>Fail
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $total }} points</small>
                                @endif
                            </td>
                            <td>
                                @if($trainer->rawAccreditations->isNotEmpty())
                                    @php
                                        // Get all evaluators (not unique, include duplicates)
                                        $evaluators = $trainer->rawAccreditations
                                            ->filter(function($acc) {
                                                return $acc->createdBy !== null;
                                            })
                                            ->pluck('createdBy');
                                    @endphp

                                    @if($evaluators->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($evaluators as $evaluator)
                                                <span class="badge bg-info">
                                                    {{ $evaluator->firstname }} {{ $evaluator->lastname }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                            <td>
                            @if(auth()->user()->emp_type == '0')
                                {{-- Print Accreditation Report --}}
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#printPdfModal-{{ $trainer->id }}" title="Print Accreditation Report">
                                    <i class="fa-solid fa-chart-bar"></i>
                                </button>

                                {{-- Print Application Form --}}
                                <button type="button" class="btn btn-sm btn-primary" onclick="loadApplicationPDF({{ $trainer->speaker->id }})" data-bs-toggle="modal" data-bs-target="#applicationPdfModal-{{ $trainer->speaker->id }}" title="Print Application Form">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </button>
                                @endif
                                {{-- View Raw Scores --}}
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accreditationModal-{{ $trainer->id }}" title="View Raw Scores">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-success">
            <div class="d-flex justify-content-end">
                {{ $accredited->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Raw Scores Modal --}}
    @foreach($accredited as $trainer)
        <div class="modal fade" id="accreditationModal-{{ $trainer->id }}" tabindex="-1" aria-labelledby="accreditationModalLabel-{{ $trainer->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            Raw Accreditation Scores - {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($trainer->rawAccreditations->isEmpty())
                            <p class="text-center">No raw accreditation scores available.</p>
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
                                        <th>Status</th>
                                        <th>Evaluated By</th>
                                        <th>Date</th>
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
                                            <td><strong>{{ $raw->total }}</strong></td>
                                            <td>
                                                @php
                                                    $total = $raw->total;
                                                @endphp

                                                @if($total >= 75)
                                                    <span class="badge bg-success">
                                                        <i class="fa-solid fa-check-circle me-1"></i>Pass
                                                    </span>
                                                @elseif($total >= 70)
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fa-solid fa-exclamation-triangle me-1"></i>Near Pass
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $total }} points</small>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fa-solid fa-times-circle me-1"></i>Fail
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $total }} points</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($raw->createdBy)
                                                    <span class="badge bg-info">
                                                        <i class="fa-solid fa-user me-1"></i>
                                                        {{ $raw->createdBy->firstname }} {{ $raw->createdBy->lastname }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $raw->created_at->format('M d, Y') }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Average:</strong></td>
                                        <td colspan="4">
                                            <strong>{{ $trainer->avg_total }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Accreditation Report PDF Modal --}}
        <div class="modal fade" id="printPdfModal-{{ $trainer->id }}" tabindex="-1" aria-labelledby="printPdfModalLabel-{{ $trainer->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-resizable">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            Accreditation Report - {{ optional($trainer->speaker)->given_name }} {{ optional($trainer->speaker)->last_name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0" style="height: 80vh; position: relative;">
                        <iframe
                            id="pdfIframe-{{ $trainer->id }}"
                            src=""
                            style="width: 100%; height: 100%; border: none;"
                            title="PDF Preview">
                        </iframe>
                    </div>
                    <div class="modal-footer bg-light py-2 d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="d-flex align-items-center">
                                <label for="fontScaleInput-{{ $trainer->id }}" class="me-2 mb-0 small text-muted">Font (%):</label>
                                <input
                                    type="number"
                                    id="fontScaleInput-{{ $trainer->id }}"
                                    class="form-control form-control-sm"
                                    style="width: 70px;"
                                    value="100"
                                    min="-100"
                                    max="150"
                                    step="5"
                                >
                                <button class="btn btn-sm btn-outline-secondary ms-1" onclick="document.getElementById('fontScaleInput-{{ $trainer->id }}').value = 100; updatePdf{{ $trainer->id }}()">Reset</button>
                            </div>
                            <div class="d-flex align-items-center">
                                <label for="paperSize-{{ $trainer->id }}" class="me-2 mb-0 small text-muted">Paper:</label>
                                <select id="paperSize-{{ $trainer->id }}" class="form-select form-select-sm" style="width: 100px;">
                                    <option value="A4">A4</option>
                                    <option value="Letter" selected>Letter</option>
                                    <option value="Legal">Legal</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" onclick="printIframe('pdfIframe-{{ $trainer->id }}')">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Application Form PDF Modal --}}
        <div class="modal fade" id="applicationPdfModal-{{ $trainer->speaker->id }}" tabindex="-1" aria-labelledby="applicationPdfModalLabel-{{ $trainer->speaker->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="applicationPdfModalLabel-{{ $trainer->speaker->id }}">
                            Application Form - {{ optional($trainer->speaker)->last_name }}, {{ optional($trainer->speaker)->given_name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="pdfLoader-{{ $trainer->speaker->id }}" class="text-center p-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading PDF...</p>
                        </div>
                        <iframe
                            id="applicationPdfFrame-{{ $trainer->speaker->id }}"
                            src=""
                            style="width:100%; height:80vh; display:none;"
                            frameborder="0">
                        </iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="printIframe('applicationPdfFrame-{{ $trainer->speaker->id }}')">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('styles')
    <style>
        .modal-dialog-resizable {
            resize: both;
            overflow: auto;
            max-width: 95vw !important;
            max-height: 95vh !important;
        }
        .modal-content {
            height: 100%;
        }
        .modal-body iframe {
            transition: opacity 0.2s ease;
        }
        .font-control {
            font-size: 0.9rem;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Initialize DataTables
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('datatablesSimple');
            if (table) {
                new simpleDatatables.DataTable(table, {
                    searchable: true,
                    perPage: 10,
                    perPageSelect: [10, 25, 50, 100]
                });
            }

            // Print iframe content
            window.printIframe = function(iframeId) {
                const iframe = document.getElementById(iframeId);
                if (iframe) {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                }
            };

            // === ACCREDITATION REPORT PDF MODAL SETUP ===
            @foreach($accredited as $trainer)
                (function() {
                    const modalId = '#printPdfModal-{{ $trainer->id }}';
                    const iframe = document.getElementById('pdfIframe-{{ $trainer->id }}');
                    const fontInput = document.getElementById('fontScaleInput-{{ $trainer->id }}');
                    const paperSelect = document.getElementById('paperSize-{{ $trainer->id }}');
                    const baseUrl = '{{ route('accreditation.average.print', $trainer->id) }}';

                    let currentFont = 100;
                    let currentPaper = 'Letter';

                    // Update PDF
                    window['updatePdf{{ $trainer->id }}'] = function() {
                        let font = parseInt(fontInput.value) || 100;
                        font = Math.max(-100, Math.min(150, font));
                        fontInput.value = font;

                        currentFont = font;
                        currentPaper = paperSelect.value;

                        const url = `${baseUrl}?font=${font}&paper=${currentPaper}`;
                        iframe.src = url;
                    };

                    // Attach to modal open
                    const triggerBtn = document.querySelector(`[data-bs-target="${modalId}"]`);
                    if (triggerBtn) {
                        triggerBtn.addEventListener('click', function() {
                            const modalEl = document.querySelector(modalId);

                            modalEl.addEventListener('shown.bs.modal', function() {
                                // Reset + load
                                fontInput.value = 100;
                                paperSelect.value = 'Letter';
                                window['updatePdf{{ $trainer->id }}']();
                            }, { once: true });

                            modalEl.addEventListener('hide.bs.modal', function() {
                                iframe.src = ''; // Clear
                            });
                        });
                    }

                    // Live updates
                    fontInput.addEventListener('input', window['updatePdf{{ $trainer->id }}']);
                    fontInput.addEventListener('change', window['updatePdf{{ $trainer->id }}']);
                    paperSelect.addEventListener('change', window['updatePdf{{ $trainer->id }}']);
                })();
            @endforeach
        });

        // Load Application Form PDF
        function loadApplicationPDF(speakerId) {
            const loader = document.getElementById('pdfLoader-' + speakerId);
            const iframe = document.getElementById('applicationPdfFrame-' + speakerId);

            if (!loader || !iframe) {
                console.error('Loader or iframe not found for speaker ID:', speakerId);
                return;
            }

            loader.style.display = 'block';
            iframe.style.display = 'none';
            iframe.src = "{{ route('resource_speaker.print', '') }}/" + speakerId;

            iframe.onload = function() {
                loader.style.display = 'none';
                iframe.style.display = 'block';
            };

            iframe.onerror = function() {
                loader.innerHTML = '<div class="alert alert-danger">Failed to load PDF</div>';
            };
        }
    </script>
@endsection
