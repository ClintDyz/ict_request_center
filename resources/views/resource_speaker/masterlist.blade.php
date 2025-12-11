@extends('layouts.admin')

@section('content')

<style>
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

    <!-- Statistics Cards -->
    <div class="row mt-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('resource_speaker.masterlist', ['status' => 'all']) }}" class="text-decoration-none">
                <div class="card stat-card bg-primary text-white {{ $status == 'all' ? 'active' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Speakers</div>
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

    <!-- Main Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-list me-2"></i>
                Resource Speakers Master List
                @if($status !== 'all')
                    <span class="badge bg-light text-dark ms-2">{{ $status }}</span>
                @endif
            </div>
           <!-- Replace the export button with this -->
                <div>
                    <!-- CSV Export -->
                    {{-- <form action="{{ route('resource_speaker.export') }}" method="GET" class="d-inline">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="btn btn-success btn-sm me-2">
                            <i class="fas fa-file-csv me-1"></i>Export to CSV
                        </button>
                    </form> --}}

                    <!-- Excel Export (Alternative) -->
                    <form action="{{ route('resource_speaker.export_excel') }}" method="GET" class="d-inline">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel me-1"></i>Export to Excel
                        </button>
                    </form>
                </div>
        </div>

        <div class="card-body">
            <!-- Filter Buttons -->
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

            <hr>

            <!-- Table -->
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
                        <th>Contact</th>
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
                            <td>{{ $speaker->home_cell_no }}</td>
                            <td>
                                <span class="badge status-{{ strtolower($speaker->status ?? 'pending') }}">
                                    {{ $speaker->status ?? 'Pending' }}
                                </span>
                            </td>
                            <td>{{ $speaker->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('resource_speaker.view', $speaker->id) }}"
                                   class="btn btn-sm btn-info"
                                   title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- <a href="{{ route('resource_speaker.edit', $speaker->id) }}"
                                   class="btn btn-sm btn-primary"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a> --}}
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
</script>
@endsection
