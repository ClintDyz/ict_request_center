@extends('layouts.admin')

@section('content')

<style>
/* ... (Keep your existing styles here) ... */
    .stat-card {
        transition: transform 0.2s;
        cursor: pointer;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .stat-card.active {
        border: 2px solid #0d6efd;
    }

    .filter-btn {
        margin: 5px;
    }

    .status-pending {
        background-color: #ffc107;
        color: #000;
    }

    .status-approved {
        background-color: #17a2b8;
        color: #fff;
    }

    .status-accredited {
        background-color: #28a745;
        color: #fff;
    }
</style>

<div class="container-fluid px-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(auth()->user()->emp_type == '0')
    {{-- (Keep your existing statistics cards here) --}}
    <div class="row mt-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('resource_speaker.masterlist', ['status' => 'all']) }}" class="text-decoration-none">
                <div class="card stat-card bg-primary text-white {{ $status == 'all' ? 'active' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Specialist</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $stats['total'] }}</div>
                            </div>
                            <div class="text-white-50">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('resource_speaker.masterlist', ['status' => 'Pending']) }}" class="text-decoration-none">
                <div class="card stat-card bg-warning text-dark {{ $status == 'Pending' ? 'active' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Pending</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $stats['pending'] }}</div>
                            </div>
                            <div class="text-dark-50">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('resource_speaker.masterlist', ['status' => 'Approved']) }}" class="text-decoration-none">
                <div class="card stat-card bg-info text-white {{ $status == 'Approved' ? 'active' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Approved</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $stats['approved'] }}</div>
                            </div>
                            <div class="text-white-50">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('resource_speaker.masterlist', ['status' => 'Accredited']) }}" class="text-decoration-none">
                <div class="card stat-card bg-success text-white {{ $status == 'Accredited' ? 'active' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Accredited</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $stats['accredited'] }}</div>
                            </div>
                            <div class="text-white-50">
                                <i class="fas fa-certificate fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endif

    <div class="card mb-4 mt-2">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-list me-2"></i>
                Specialist Master List
                @if($status !== 'all')
                    <span class="badge bg-light text-dark ms-2">{{ $status }}</span>
                @endif
            </div>
            <div>
                {{-- @if(auth()->user()->emp_type == '0')
                <form action="{{ route('resource_speaker.export_excel') }}" method="GET" class="d-inline">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel me-1"></i>Export to Excel
                    </button>
                </form>
                @endif --}}
                @if(auth()->user()->emp_type == '2')
                <a href="{{ route('resource_speaker.create') }}" class="btn btn-success">
                    <i class="fa-solid fa-circle-plus"></i> Create
                </a>
                @endif

            </div>
        </div>

        <div class="card-body">
            @if(auth()->user()->emp_type == '0')
            <div class="mb-3">
                <strong>Filter by Status:</strong>
                <div class="btn-group ms-2" role="group">
                    <a href="{{ route('resource_speaker.masterlist', ['status' => 'all']) }}"
                       class="btn btn-sm {{ $status == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                        All ({{ $stats['total'] }})
                    </a>
                    <a href="{{ route('resource_speaker.masterlist', ['status' => 'Pending']) }}"
                       class="btn btn-sm {{ $status == 'Pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                        Pending ({{ $stats['pending'] }})
                    </a>
                    <a href="{{ route('resource_speaker.masterlist', ['status' => 'Approved']) }}"
                       class="btn btn-sm {{ $status == 'Approved' ? 'btn-info' : 'btn-outline-info' }}">
                        Approved ({{ $stats['approved'] }})
                    </a>
                    <a href="{{ route('resource_speaker.masterlist', ['status' => 'Accredited']) }}"
                       class="btn btn-sm {{ $status == 'Accredited' ? 'btn-success' : 'btn-outline-success' }}">
                        Accredited ({{ $stats['accredited'] }})
                    </a>
                </div>
            </div>
            @endif


            <hr>

            <table id="datatablesSimple" class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Expertise</th>
                        <th>Office/Agency</th>
                        <th>Address</th>
                        <th>Tota Avg.</th>
                        <th>Status</th>
                        <th>Date Registered</th>
                        <th>Actions</th>
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
                            <td>{{ $speaker->gender }}</td>
                            <td>{{ $speaker->age }}</td>
                            <td>
                                @if($speaker->expertises->isNotEmpty())
                                    {{ $speaker->expertises->pluck('expertis')->implode(', ') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ optional($speaker->office)->office_name ?? 'N/A' }}</td>
                            <td>
                                {{ $speaker->home_address }}, {{ $speaker->home_municipality }}, {{ $speaker->home_province }}
                            </td>
                            <td>
                                @if($speaker->avg_total)
                                    <span class="badge {{ $speaker->avg_total >= 75 ? 'bg-success' : 'bg-warning' }}">
                                        {{ number_format($speaker->avg_total, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge status-{{ strtolower($speaker->status ?? 'pending') }}">
                                    {{ $speaker->status ?? 'Pending' }}
                                </span>
                            </td>
                            <td>{{ $speaker->created_at->format('M d, Y') }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('resource_speaker.view', $speaker->id) }}"
                                   class="btn btn-sm btn-info"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- NEW BUTTON TO VIEW THE LETTER LINK --}}
                                @if($speaker->letter->rs_letter ?? false)
                                <button type="button"
                                        class="btn btn-sm btn-success viewLetterModal"
                                        data-letter-link="{{ $speaker->letter->rs_letter }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewLetterModal"
                                        title="View Letter">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                                @endif

                                {{-- EXISTING BUTTON TO EDIT/CREATE THE LETTER LINK --}}
                                @if(auth()->user()->emp_type == '0')

                                <button type="button"
                                        class="btn btn-sm btn-primary openLetterModal"
                                        data-id="{{ $speaker->id }}"
                                        data-letter="{{ $speaker->letter->rs_letter ?? '' }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#createUnitModal"
                                        title="Edit Link">
                                    <i class="fas fa-edit"></i>
                                </button>

                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No resource speakers found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light">
            <small class="text-muted">
                Showing {{ $speakers->count() }} of {{ $stats['total'] }} total resource speakers
            </small>
        </div>
    </div>
</div>



{{-- NEW MODAL FOR VIEWING THE LINK --}}
<div class="modal fade" id="viewLetterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">View Specialist Letter Link</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Click the link below to view the Specialist Letter:</p>
                <div class="input-group">
                    <a href="#" id="view_rs_letter_link" target="_blank" class="form-control btn btn-link text-break text-start p-0">
                        <i class="fas fa-external-link-alt me-2"></i>
                        <span id="view_rs_letter_text"></span>
                    </a>
                </div>
                <small class="text-muted mt-2 d-block">The link will open in a new tab.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL FOR ADDING/EDITING LETTER LINK --}}
<div class="modal fade" id="createUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="letterForm" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-link me-2"></i>
                        Accreditation Letter Link
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Please enter the complete URL of the accreditation letter (e.g., Google Drive link, Dropbox link, etc.)
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-external-link-alt me-1"></i>
                            Accreditation Letter URL
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="url"
                                   class="form-control"
                                   name="rs_letter"
                                   id="rs_letter"
                                   placeholder="https://drive.google.com/file/d/..."
                                   >
                        </div>
                        <small class="text-muted">
                            Make sure the link is accessible to anyone with the link
                        </small>
                    </div>

                    <div id="preview-section" class="d-none">
                        <label class="form-label fw-bold">Preview:</label>
                        <div class="card bg-light">
                            <div class="card-body">
                                <a href="#" id="preview-link" target="_blank" class="text-break">
                                    <i class="fas fa-external-link-alt me-2"></i>
                                    <span id="preview-text"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Save Letter Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#datatablesSimple').DataTable({
            "pageLength": 10,
            "ordering": true,
            "searching": true,
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            },
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
        });
    });

    // JavaScript for EDITING/CREATING the Letter Link
    $(document).on('click', '.openLetterModal', function() {
        var id = $(this).data('id');
        var letter = $(this).data('letter');

        $('#rs_letter').val(letter);

        // This is the fix for the previous issue: set the form action dynamically
        var route = '{{ route("resource_speaker.letter.store", ["id" => ":id"]) }}';
        route = route.replace(':id', id);
        $('#letterForm').attr('action', route);
    });

    // JavaScript for VIEWING the Letter Link
    $(document).on('click', '.viewLetterModal', function() {
        var letterLink = $(this).data('letter-link');

        // Set the href attribute and the text content of the link inside the view modal
        $('#view_rs_letter_link').attr('href', letterLink);

        // Use the link itself as the displayed text, or a shortened version
        // This example displays the whole link
        $('#view_rs_letter_text').text(letterLink);
    });
</script>
@endsection
