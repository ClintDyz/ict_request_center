@extends('layouts.admin')

@section('content')

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>

{{-- Notification Alert for New Speakers --}}
@if($newSpeakersCount > 0)
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-bell me-2"></i>
            <strong>{{ $newSpeakersCount }} New Resource Speaker{{ $newSpeakersCount > 1 ? 's' : '' }}!</strong>
            <span class="ms-2">Added in the last 24 hours</span>
        </div>
        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="collapse" data-bs-target="#newSpeakersList">
            <i class="fas fa-eye me-1"></i> View Names
        </button>
    </div>

    {{-- Collapsible list of new speakers --}}
    <div class="collapse mt-3" id="newSpeakersList">
        <hr>
        <h6 class="fw-bold mb-2">Newly Added Speakers:</h6>
        <ul class="mb-0">
            @foreach($newSpeakers as $speaker)
            <li>
                <strong>{{ $speaker->first_name }} {{ $speaker->last_name }}</strong>
                <span class="badge bg-{{ $speaker->status == 'Pending' ? 'warning' : ($speaker->status == 'Approved' ? 'info' : 'success') }} ms-2">
                    {{ $speaker->status }}
                </span>
                <small class="text-muted ms-2">
                    ({{ $speaker->created_at->diffForHumans() }})
                </small>
            </li>
            @endforeach
        </ul>
    </div>

    <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<style>
    .dashboard-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform .2s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-4px);
    }
    .card-title {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: .5px;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 32px;
        font-weight: 900;
    }
    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: bold;
        animation: pulse 2s infinite;
        z-index: 10;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>

<div class="row">

    {{-- Pending --}}
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white dashboard-card">
            <div class="card-body">
                <div class="card-title">Pending</div>
                <div class="stat-value">{{ $pendingCount }}</div>
                <i class="fas fa-hourglass-start fa-3x float-end opacity-75"></i>
            </div>
            <div class="card-footer text-white d-flex justify-content-between">
                <a class="small text-white stretched-link" href="{{ url('/rstbl') }}">View Details</a>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

    {{-- Approved --}}
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white dashboard-card">
            <div class="card-body">
                <div class="card-title">Approved</div>
                <div class="stat-value">{{ $approvedCount }}</div>
                <i class="fas fa-thumbs-up fa-3x float-end opacity-75"></i>
            </div>
            <div class="card-footer text-white d-flex justify-content-between">
                <a class="small text-white stretched-link" href="{{ url('/approved-speakers') }}">View Details</a>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

    {{-- Accredited --}}
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white dashboard-card">
            <div class="card-body">
                <div class="card-title">Accredited</div>
                <div class="stat-value">{{ $accreditedCount }}</div>
                <i class="fas fa-certificate fa-3x float-end opacity-75"></i>
            </div>
            <div class="card-footer text-white d-flex justify-content-between">
                <a class="small text-white stretched-link" href="{{ url('/accreditation_average') }}">View Details</a>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

    {{-- Resource Speakers with Notification Badge --}}
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white dashboard-card position-relative">
            {{-- Notification Badge --}}
            @if($newSpeakersCount > 0)
            <span class="notification-badge">{{ $newSpeakersCount }}</span>
            @endif

            <div class="card-body">
                <div class="card-title">Specialist</div>
                <div class="stat-value">{{ $resourceSpeakerCount }}</div>
                <i class="fas fa-users fa-3x float-end opacity-75"></i>
            </div>
            <div class="card-footer text-white d-flex justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

</div>

{{-- Latest Resource Speakers Section --}}
@if($latestSpeakers->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-clock me-1"></i> Recently Added Resource Speakers
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Added Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestSpeakers as $speaker)
                            <tr>
                                <td>
                                    <i class="fas fa-user-circle me-2 text-primary"></i>
                                    {{ $speaker->first_name }} {{ $speaker->last_name }}
                                    @if($speaker->created_at >= Carbon\Carbon::now()->subDay())
                                        <span class="badge bg-danger ms-2">New</span>
                                    @endif
                                </td>
                                <td>{{ $speaker->gender }}</td>
                                <td>
                                    @if($speaker->status == 'Pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($speaker->status == 'Approved')
                                        <span class="badge bg-info">Approved</span>
                                    @else
                                        <span class="badge bg-success">Accredited</span>
                                    @endif
                                </td>
                                <td>{{ $speaker->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Charts --}}
<div class="row mt-4">

    {{-- Gender Chart --}}
    <div class="col-xl-4 col-md-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-chart-pie me-1"></i> Gender Distribution
            </div>
            <div class="card-body">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Status Chart --}}
    <div class="col-xl-4 col-md-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-chart-pie me-1"></i> Accreditation Status Overview
            </div>
            <div class="card-body">
                <canvas id="accreditationChart"></canvas>
            </div>
        </div>
    </div>

</div>

@endsection


@section('scripts')
{{-- Gender Chart --}}
<script>
    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [{{ $maleCount }}, {{ $femaleCount }}],
                backgroundColor: ['#007bff', '#e83e8c']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

{{-- Accreditation Chart --}}
<script>
    new Chart(document.getElementById('accreditationChart'), {
        type: 'pie',
        data: {
            labels: ['Pending', 'Approved', 'Accredited'],
            datasets: [{
                data: [
                    {{ $pendingCount }},
                    {{ $approvedCount }},
                    {{ $accreditedCount }}
                ],
                backgroundColor: ['#ffc107', '#17a2b8', '#28a745']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection
