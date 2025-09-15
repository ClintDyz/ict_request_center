@extends('layouts.admin')

@section('content')

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
{{-- <div class="row"> --}}


    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs row font-weight-bold text-uppercase mb-1">
                                <h4> Resource Speaker </h4> </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resourceSpeakerCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-group fa-4x"></i>
                        </div>
                    </div>       </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('/rstbl') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                <h4> List of To Be Accredited </h4>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $toBeAccreditedCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-chalkboard-user fa-4x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('/accreditation') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                <h4> List of the Accredited </h4>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $accreditedCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-chalkboard-user fa-4x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ url('/accreditation_average') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

    </div>

        <div class="row">

        <div class="col-xl-4 col-md-6">

        <div class="card">
            <div class="card-header">
                 <i class="fas fa-chart-pie me-1"></i>
                Resource Speaker Gender Distribution</div>
            <div class="card-body">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        </div>

                <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Accreditation Status Overview
                    </div>
                    <div class="card-body"><canvas id="accreditationChart" width="100%" height="40"></canvas></div>
                </div>
            </div>

        </div>
    {{-- <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Warning Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Success Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Danger Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div> --}}

@endsection


@section('scripts')

<script>
    const ctx = document.getElementById('genderChart').getContext('2d');
    const genderChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                label: 'Gender Distribution',
                data: [{{ $maleCount }}, {{ $femaleCount }}],
                backgroundColor: ['#36A2EB', '#FF6384'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('accreditationChart');

        new Chart(ctx, {
            type: 'pie', // You can also use 'bar' for a bar chart
            data: {
                labels: ['To Be Accredited', 'Accredited'],
                datasets: [{
                    data: [{{ $toBeAccreditedCount }}, {{ $accreditedCount }}],
                    backgroundColor: ['#17a2b8', '#28a745'], // Info and Success colors
                    hoverBackgroundColor: ['#138496', '#218838']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                }
            }
        });
    });
</script>
@endsection
