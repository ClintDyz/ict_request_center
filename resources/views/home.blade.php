@extends('layouts.admin')

@section('content')

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>

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

    {{-- Resource Speakers --}}
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white dashboard-card">
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


    {{-- <div class="col-xl-4 col-md-6 mb-4">
    <div class="card bg-dark text-white dashboard-card">
        <div class="card-body">
            <div class="card-title">Age Profile</div>
            <div class="stat-value">{{ $age_18_25 + $age_26_35 + $age_36_45 + $age_46_60 + $age_60_plus }}</div>
            <i class="fas fa-user-clock fa-3x float-end opacity-75"></i>
        </div>
        <div class="card-footer text-white d-flex justify-content-between">
            <span>Total Profiles Analyzed</span>
        </div>
    </div>
</div> --}}

</div>

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

    {{-- <div class="col-xl-4 col-md-12 mb-4">
    <div class="card dashboard-card">
        <div class="card-header bg-light fw-bold">
            <i class="fas fa-chart-bar me-1"></i> Age Profile Distribution
        </div>
        <div class="card-body">
            <canvas id="ageChart"></canvas>
        </div>
    </div>
</div> --}}


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
        new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: [
                '18–25',
                '26–35',
                '36–45',
                '46–60',
                '60+'
            ],
            datasets: [{
                label: 'Age Count',
                data: [
                    {{ $age_18_25 }},
                    {{ $age_26_35 }},
                    {{ $age_36_45 }},
                    {{ $age_46_60 }},
                    {{ $age_60_plus }}
                ],
                backgroundColor: [
                    '#007bff',
                    '#17a2b8',
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endsection
