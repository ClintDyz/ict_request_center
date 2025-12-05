@extends('layouts.admin')

@section('content')

@push('styles')
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
        --success-color: #1cc88a;
        --danger-color: #e74a3b;
        --warning-color: #f6c23e;
        --info-color: #36b9cc;
    }

    body {
        background-color: #f8f9fc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border-radius: 12px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card .stat-icon {
        background: rgba(255, 255, 255, 0.2);
    }

    .stat-card h1 {
        color: white;
    }

    .stat-card .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .professional-table thead th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-bottom: 2px solid #dee2e6;
    }

    .professional-table tbody tr {
        transition: all 0.2s ease;
    }

    .professional-table tbody tr:hover {
        background-color: #f8f9fc;
        transform: scale(1.01);
    }

    .badge {
        font-weight: 500;
        padding: 0.4em 0.8em;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #d1d3e2;
        padding: 0.625rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(17, 153, 142, 0.4);
    }

    .modal-content {
        border-radius: 12px;
    }

    .modal-header {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .empty-state i {
        opacity: 0.5;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.075) !important;
    }

    .bg-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Pagination Styling */
    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid #d1d3e2;
        color: var(--primary-color);
    }

    .page-link:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .stat-card .display-4 {
            font-size: 2.5rem;
        }

        .professional-table {
            font-size: 0.875rem;
        }
    }
</style>
@endpush

<div class="container-fluid px-4 py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1 text-dark">ID Request Report</h2>
                    <p class="text-muted mb-0">Comprehensive analysis and reporting of ID requests</p>
                </div>
                <div>
                    <span class="badge bg-light text-dark px-3 py-2 fs-6">
                        <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('F d, Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 stat-card">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary bg-opacity-10 rounded-3 p-3 me-4">
                                    <i class="fas fa-id-card fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 text-uppercase small fw-semibold">Total ID Requests</p>
                                    <h1 class="display-4 fw-bold mb-0 text-dark">{{ number_format($stats['total']) }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            {{-- <a href="{{ route('id_report.export') }}?{{ http_build_query(request()->all()) }}"
                               class="btn btn-success btn-lg px-4">
                                <i class="fas fa-file-excel me-2"></i>Export Report
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-filter text-primary me-2"></i>Filter Options
                </h5>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('report.id_report') }}" id="filterForm">
                    <div class="row g-3">
                        <!-- Date Range Filter -->
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-calendar-day text-primary me-1"></i>Date Range
                            </label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="date" name="start_date" class="form-control form-control-lg"
                                           value="{{ request('start_date') }}"
                                           placeholder="Start Date">
                                </div>
                                <div class="col-6">
                                    <input type="date" name="end_date" class="form-control form-control-lg"
                                           value="{{ request('end_date') }}"
                                           placeholder="End Date">
                                </div>
                            </div>
                        </div>

                        <!-- Month & Year Filter -->
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-calendar text-primary me-1"></i>Month & Year
                            </label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <select name="month" class="form-select form-select-lg">
                                        <option value="">Select Month</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="year" class="form-select form-select-lg">
                                        <option value="">Select Year</option>
                                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-check-circle text-primary me-1"></i>Status
                            </label>
                            <select name="status" class="form-select form-select-lg">
                                <option value="">All Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Division Unit Filter -->
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-building text-primary me-1"></i>Division/Unit
                            </label>
                            <select name="division_unit" class="form-select form-select-lg">
                                <option value="">All Divisions</option>
                                @foreach($divisionUnits as $unit)
                                    <option value="{{ $unit->id }}" {{ request('division_unit') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->division_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Position Filter -->
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-user-tie text-primary me-1"></i>Position
                            </label>
                            <select name="position" class="form-select form-select-lg">
                                <option value="">All Positions</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ request('position') == $position->id ? 'selected' : '' }}>
                                        {{ $position->position }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Blood Type Filter -->
                        <div class="col-md-3">
                            <label class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-tint text-primary me-1"></i>Blood Type
                            </label>
                            <select name="blood_type" class="form-select form-select-lg">
                                <option value="">All Blood Types</option>
                                @foreach($bloodTypes as $type)
                                    <option value="{{ $type }}" {{ request('blood_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-search me-2"></i>Apply Filters
                                </button>
                                <a href="{{ route('report.id_report') }}" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    {{-- <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-table text-primary me-2"></i>ID Requests
                    <span class="badge bg-primary ms-2">{{ $idRequests->total() }}</span>
                </h5>
                <div class="text-muted small">
                    Showing {{ $idRequests->firstItem() ?? 0 }} - {{ $idRequests->lastItem() ?? 0 }} of {{ $idRequests->total() }}
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 professional-table">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Photo</th>
                            <th class="px-4 py-3">Full Name</th>
                            <th class="px-4 py-3">Birthdate</th>
                            <th class="px-4 py-3">Blood Type</th>
                            <th class="px-4 py-3">Position</th>
                            <th class="px-4 py-3">Division/Unit</th>
                            <th class="px-4 py-3">Emergency Contact</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Created At</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($idRequests as $request)
                        <tr class="border-bottom">
                            <td class="px-4">
                                <span class="badge bg-light text-dark fw-semibold">#{{ $request->id }}</span>
                            </td>
                            <td class="px-4">
                                @if($request->image)
                                    <img src="{{ asset('storage/' . $request->image) }}"
                                         alt="Photo"
                                         class="rounded-circle shadow-sm"
                                         width="45"
                                         height="45"
                                         style="object-fit: cover; border: 2px solid #e9ecef;">
                                @else
                                    <div class="bg-gradient rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                         style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4">
                                <div>
                                    <p class="mb-0 fw-semibold text-dark">{{ $request->f_name }} {{ $request->l_name }}</p>
                                    <small class="text-muted">{{ $request->m_name }}</small>
                                    @if($request->nick_name)
                                        <span class="badge bg-info bg-opacity-10 text-info ms-1">"{{ $request->nick_name }}"</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4">
                                <span class="text-dark">{{ \Carbon\Carbon::parse($request->birthdate)->format('M d, Y') }}</span>
                            </td>
                            <td class="px-4">
                                <span class="badge bg-danger bg-opacity-90 px-3 py-2">{{ $request->blood_type }}</span>
                            </td>
                            <td class="px-4">
                                <span class="text-dark">{{ $request->position->position ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4">
                                <span class="text-dark">{{ $request->divisionUnit->division_unit ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4">
                                <div>
                                    <p class="mb-0 fw-semibold text-dark">{{ $request->emergency_contact_name }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>{{ $request->emergency_contact_number }}
                                    </small>
                                </div>
                            </td>
                            <td class="px-4">
                                @if($request->status == 'Approved')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>{{ $request->status }}
                                    </span>
                                @elseif($request->status == 'Pending')
                                    <span class="badge bg-warning px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>{{ $request->status }}
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>{{ $request->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4">
                                <div>
                                    <p class="mb-0 text-dark">{{ $request->created_at->format('M d, Y') }}</p>
                                    <small class="text-muted">{{ $request->created_at->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group shadow-sm" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="modal"
                                       data-bs-target="#viewModal{{ $request->id }}"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{ $request->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">
                                            <i class="fas fa-id-card me-2"></i>ID Request Details - #{{ $request->id }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row">
                                            <div class="col-md-4 text-center mb-3">
                                                @if($request->image)
                                                    <img src="{{ asset('storage/' . $request->image) }}"
                                                         alt="Photo"
                                                         class="img-fluid rounded shadow"
                                                         style="max-height: 300px;">
                                                @else
                                                    <div class="bg-gradient rounded d-flex align-items-center justify-content-center shadow"
                                                         style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                        <i class="fas fa-user fa-5x text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-8">
                                                <h4 class="fw-bold mb-1">{{ $request->f_name }} {{ $request->m_name }} {{ $request->l_name }}</h4>
                                                @if($request->nick_name)
                                                    <p class="text-muted">"{{ $request->nick_name }}"</p>
                                                @endif
                                                <hr>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="40%" class="text-muted">Birthdate:</th>
                                                            <td class="fw-semibold">{{ \Carbon\Carbon::parse($request->birthdate)->format('F d, Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-muted">Blood Type:</th>
                                                            <td><span class="badge bg-danger px-3 py-2">{{ $request->blood_type }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-muted">Position:</th>
                                                            <td class="fw-semibold">{{ $request->position->position ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-muted">Division/Unit:</th>
                                                            <td class="fw-semibold">{{ $request->divisionUnit->division_unit ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-muted">Status:</th>
                                                            <td>
                                                                @if($request->status == 'Approved')
                                                                    <span class="badge bg-success px-3 py-2">{{ $request->status }}</span>
                                                                @elseif($request->status == 'Pending')
                                                                    <span class="badge bg-warning px-3 py-2">{{ $request->status }}</span>
                                                                @else
                                                                    <span class="badge bg-danger px-3 py-2">{{ $request->status }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <h5 class="mt-4 mb-3 fw-bold">Emergency Contact</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="40%" class="text-muted">Name:</th>
                                                            <td class="fw-semibold">{{ $request->emergency_contact_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-muted">Phone:</th>
                                                            <td class="fw-semibold">{{ $request->emergency_contact_number }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-muted">Address:</th>
                                                            <td class="fw-semibold">{{ $request->emergency_contact_address }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <div class="empty-state py-5">
                                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">No ID Requests Found</h5>
                                    <p class="text-muted">Try adjusting your filters to see more results.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($idRequests->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-center">
                {{ $idRequests->appends(request()->all())->links() }}
            </div>
        </div>
        @endif
    </div> --}}

    <!-- Statistics Section -->
    {{-- <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-building text-primary me-2"></i>By Division/Unit
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(count($stats['by_division']) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                @foreach($stats['by_division'] as $division => $count)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">
                                        <span class="fw-semibold text-dark">{{ $division }}</span>
                                    </td>
                                    <td class="text-end px-4 py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fw-semibold">
                                            {{ number_format($count) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-tint text-primary me-2"></i>By Blood Type
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(count($stats['by_blood_type']) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                @foreach($stats['by_blood_type'] as $type => $count)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">
                                        <span class="badge bg-danger bg-opacity-90 px-3 py-2 fw-semibold">{{ $type }}</span>
                                    </td>
                                    <td class="text-end px-4 py-3">
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 fw-semibold">
                                            {{ number_format($count) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

</div>


@endsection
