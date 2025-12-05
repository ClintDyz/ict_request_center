@extends('layouts.admin')

@section('content')
<style>
body {
    background-color: #f9fafb;
    font-family: 'Poppins', sans-serif;
}
.dashboard-container {
    padding: 2rem;
}
.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2563eb;
    margin-bottom: 1rem;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}
.stat-card {
    background: white;
    border-radius: 14px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.stat-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}
.stat-card-link .stat-card {
    cursor: pointer;
}
.stat-card-link:hover .stat-card {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.12);
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #2563eb, #3b82f6);
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.12);
}
.stat-card.success::before {
    background: linear-gradient(180deg, #10b981, #34d399);
}
.stat-card.warning::before {
    background: linear-gradient(180deg, #f59e0b, #fbbf24);
}
.stat-card.danger::before {
    background: linear-gradient(180deg, #ef4444, #f87171);
}
.stat-card.info::before {
    background: linear-gradient(180deg, #6366f1, #818cf8);
}
.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
}
.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
}
.stat-icon.success {
    background: linear-gradient(135deg, #10b981, #34d399);
}
.stat-icon.warning {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
}
.stat-icon.danger {
    background: linear-gradient(135deg, #ef4444, #f87171);
}
.stat-icon.info {
    background: linear-gradient(135deg, #6366f1, #818cf8);
}
.stat-title {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}
.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
}
.stat-subtitle {
    font-size: 0.85rem;
    color: #9ca3af;
    margin-top: 0.25rem;
}
.table-section {
    background: white;
    padding: 1.5rem;
    border-radius: 14px;
    margin-top: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.summary-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}
.summary-table th, .summary-table td {
    padding: 0.75rem;
    text-align: center;
    border: 1px solid #e5e7eb;
}
.summary-table thead {
    background-color: #2563eb;
    color: white;
}
.summary-table tbody tr:hover {
    background-color: #f3f4f6;
}
.section-divider {
    margin: 3rem 0 2rem 0;
    border: 0;
    height: 2px;
    background: linear-gradient(to right, transparent, #e5e7eb, transparent);
}
.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}
.status-pending {
    background: #fef3c7;
    color: #92400e;
}
.status-approved {
    background: #d1fae5;
    color: #065f46;
}
.status-declined {
    background: #fee2e2;
    color: #991b1b;
}
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .stat-value {
        font-size: 1.5rem;
    }
    .dashboard-container {
        padding: 1rem;
    }
}
</style>

<div class="dashboard-container">
    <h1 class="section-title"><i class="fa fa-dashboard me-2"></i> Dashboard</h1>

    {{-- =======================
        ZOOM REQUEST DASHBOARD
    ======================== --}}
    <h1 class="section-title mt-2">📊 Zoom Request Dashboard</h1>

    <div class="stats-grid">
            <!-- Pending -->
<a href="{{ url('/zoom_request?status=Pending') }}" class="stat-card-link">
    <div class="stat-card warning">
        <div class="stat-header">
            <div>
                <div class="stat-title">Pending Requests</div>
                <div class="stat-value">{{ $zoom_pending }}</div>
            </div>
            <div class="stat-icon warning">
                <i class="fa fa-hourglass-half"></i>
            </div>
        </div>
    </div>
</a>

<!-- Approved -->
<a href="{{ url('/approved') }}" class="stat-card-link">
    <div class="stat-card success">
        <div class="stat-header">
            <div>
                <div class="stat-title">Approved Requests</div>
                <div class="stat-value">{{ $zoom_approved }}</div>
            </div>
            <div class="stat-icon success">
                <i class="fa fa-check-circle"></i>
            </div>
        </div>
    </div>
</a>

<!-- Declined -->
<a href="{{ url('/declined') }}" class="stat-card-link">
    <div class="stat-card danger">
        <div class="stat-header">
            <div>
                <div class="stat-title">Declined Requests</div>
                <div class="stat-value">{{ $zoom_declined }}</div>
            </div>
            <div class="stat-icon danger">
                <i class="fa fa-times-circle"></i>
            </div>
        </div>
    </div>
</a>

        <a href="{{ url('/zoom_request') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-title">Total Zoom Requests</div>
                        <div class="stat-value">{{ $zoom_totalRequests }}</div>
                    </div>
                    <div class="stat-icon info">
                        <i class="fa fa-video"></i>
                    </div>
                </div>
            </div>
        </a>
        {{-- <div class="stat-card success">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Most Active Division</div>
                    <div class="stat-value" style="font-size: 1.3rem;">{{ $zoom_mostActiveDivision->division_name ?? 'N/A' }}</div>
                    <div class="stat-subtitle">({{ $zoom_mostActiveDivision->count ?? 0 }} requests)</div>
                </div>
                <div class="stat-icon success">
                    <i class="fa fa-building"></i>
                </div>
            </div>
        </div>
        <div class="stat-card warning">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Latest Request</div>
                    <div class="stat-value" style="font-size: 1.1rem;">
                        {{ $zoom_latestRequest ? \Carbon\Carbon::parse($zoom_latestRequest->created_at)->format('M d, Y') : 'N/A' }}
                    </div>
                    <div class="stat-subtitle">{{ $zoom_latestRequest->topic ?? '' }}</div>
                </div>
                <div class="stat-icon warning">
                    <i class="fa fa-clock"></i>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- ===== Zoom Meetings for Today ===== --}}
    @if($todayMeetings->count() > 0)
    <div class="table-section mt-4">
        <h6 class="fw-bold text-success">
            <i class="fa fa-calendar-check me-2"></i>Zoom Meetings for Today ({{ \Carbon\Carbon::today()->format('M d, Y') }})
        </h6>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Requested By</th>
                    <th>Topic</th>
                    <th>Division</th>
                    <th>Schedule</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todayMeetings as $index => $meeting)
                <tr>
                    <td>{{ $todayMeetings->firstItem() + $index }}</td>
                    <td>{{ trim($meeting->f_name . ' ' . ($meeting->m_name ?? '') . ' ' . $meeting->l_name) }}</td>
                    <td>{{ $meeting->topic }}</td>
                    <td>{{ optional($meeting->divisionUnit)->division_unit ?? 'N/A' }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($meeting->start_date)->format('M d, Y') }}
                        {{ $meeting->start_time ? \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') : '' }}
                        -
                        {{ \Carbon\Carbon::parse($meeting->end_date)->format('M d, Y') }}
                        {{ $meeting->end_time ? \Carbon\Carbon::parse($meeting->end_time)->format('h:i A') : '' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2 d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Showing {{ $todayMeetings->firstItem() }} to {{ $todayMeetings->lastItem() }} of {{ $todayMeetings->total() }} meetings
            </div>
            <div>{{ $todayMeetings->links() }}</div>
        </div>
    </div>
    @else
        <div class="alert alert-info mt-3">
            <i class="fa fa-info-circle me-2"></i><strong>No meetings scheduled for today.</strong>
        </div>
    @endif

    <hr class="section-divider">

    {{-- =======================
        ID REQUEST DASHBOARD
    ======================== --}}
    {{-- <h1 class="section-title mt-5">📸 ID Request Dashboard</h1>

    <div class="stats-grid">
        <a href="{{ url('/id_request') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-title">Total ID Requests</div>
                        <div class="stat-value">{{ $id_totalRequests }}</div>
                    </div>
                    <div class="stat-icon info">
                        <i class="fa fa-id-card"></i>
                    </div>
                </div>
            </div>
        </a>
        <div class="stat-card success">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Most Active Division</div>
                    <div class="stat-value" style="font-size: 1.3rem;">{{ $id_mostActiveDivision->division_name ?? 'N/A' }}</div>
                    <div class="stat-subtitle">({{ $id_mostActiveDivision->count ?? 0 }} requests)</div>
                </div>
                <div class="stat-icon success">
                    <i class="fa fa-building"></i>
                </div>
            </div>
        </div>
        <div class="stat-card warning">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Latest Request</div>
                    <div class="stat-value" style="font-size: 1.1rem;">
                        {{ $id_latestRequest ? \Carbon\Carbon::parse($id_latestRequest->created_at)->format('M d, Y') : 'N/A' }}
                    </div>
                    <div class="stat-subtitle">
                        {{ $id_latestRequest ? $id_latestRequest->f_name . ' ' . $id_latestRequest->l_name : '' }}
                    </div>
                </div>
                <div class="stat-icon warning">
                    <i class="fa fa-clock"></i>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- ===== ID Requests for Today ===== --}}
    {{-- @if($todayIdRequests->count() > 0)
    <div class="table-section mt-4">
        <h6 class="fw-bold text-primary">
            <i class="fa fa-calendar-check me-2"></i>ID Requests for Today ({{ \Carbon\Carbon::today()->format('M d, Y') }})
        </h6>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Requested By</th>
                    <th>Division</th>
                    <th>Date Requested</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todayIdRequests as $index => $req)
                <tr>
                    <td>{{ $todayIdRequests->firstItem() + $index }}</td>
                    <td>{{ trim($req->f_name . ' ' . ($req->m_name ?? '') . ' ' . $req->l_name) }}</td>
                    <td>{{ optional($req->divisionUnit)->division_unit ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($req->created_at)->format('M d, Y h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2 d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Showing {{ $todayIdRequests->firstItem() }} to {{ $todayIdRequests->lastItem() }} of {{ $todayIdRequests->total() }} requests
            </div>
            <div>{{ $todayIdRequests->links() }}</div>
        </div>
    </div>
    @else
        <div class="alert alert-info mt-3">
            <i class="fa fa-info-circle me-2"></i><strong>No ID requests submitted today.</strong>
        </div>
    @endif

    <hr class="section-divider"> --}}

    {{-- =======================
        VEHICLE RESERVATION DASHBOARD
    ======================== --}}
    {{-- <h1 class="section-title mt-5">🚗 Vehicle Reservation Dashboard</h1>

    <div class="stats-grid">
        <a href="{{ url('/vehicle-reservations') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-title">Total Reservations</div>
                        <div class="stat-value">{{ $vehicle_totalReservations }}</div>
                    </div>
                    <div class="stat-icon info">
                        <i class="fa fa-car"></i>
                    </div>
                </div>
            </div>
        </a>

        <div class="stat-card warning">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Pending Requests</div>
                    <div class="stat-value">{{ $vehicle_pendingRequests }}</div>
                    <div class="stat-subtitle">Awaiting approval</div>
                </div>
                <div class="stat-icon warning">
                    <i class="fa fa-hourglass-half"></i>
                </div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Vehicles in Use Today</div>
                    <div class="stat-value">{{ $vehicle_inUseToday }}</div>
                    <div class="stat-subtitle">Currently deployed</div>
                </div>
                <div class="stat-icon success">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Approved</div>
                    <div class="stat-value">{{ $vehicle_approved }}</div>
                </div>
                <div class="stat-icon success">
                    <i class="fa fa-thumbs-up"></i>
                </div>
            </div>
        </div>

        <div class="stat-card danger">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Declined</div>
                    <div class="stat-value">{{ $vehicle_declined }}</div>
                </div>
                <div class="stat-icon danger">
                    <i class="fa fa-times-circle"></i>
                </div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Most Used Vehicle</div>
                    <div class="stat-value" style="font-size: 1.2rem;">{{ $vehicle_mostUsed->vehicle_name ?? 'N/A' }}</div>
                    <div class="stat-subtitle">({{ $vehicle_mostUsed->count ?? 0 }} reservations)</div>
                </div>
                <div class="stat-icon success">
                    <i class="fa fa-trophy"></i>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- ===== Additional Stats Row ===== --}}
    {{-- <div class="stats-grid mt-3">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Most Active Division</div>
                    <div class="stat-value" style="font-size: 1.3rem;">{{ $vehicle_mostActiveDivision->division_name ?? 'N/A' }}</div>
                    <div class="stat-subtitle">({{ $vehicle_mostActiveDivision->count ?? 0 }} reservations)</div>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-building"></i>
                </div>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Latest Reservation</div>
                    <div class="stat-value" style="font-size: 1.1rem;">
                        {{ $vehicle_latestReservation ? \Carbon\Carbon::parse($vehicle_latestReservation->created_at)->format('M d, Y') : 'N/A' }}
                    </div>
                    <div class="stat-subtitle">
                        {{ $vehicle_latestReservation ? $vehicle_latestReservation->vehicle_name : '' }}
                    </div>
                </div>
                <div class="stat-icon warning">
                    <i class="fa fa-clock"></i>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- ===== Vehicle Reservations for Today ===== --}}
    {{-- @if($todayVehicleReservations->count() > 0)
    <div class="table-section mt-4">
        <h6 class="fw-bold" style="color: #10b981;">
            <i class="fa fa-calendar-check me-2"></i>Vehicle Reservations for Today ({{ \Carbon\Carbon::today()->format('M d, Y') }})
        </h6>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Requested By</th>
                    <th>Division</th>
                    <th>Vehicle</th>
                    <th>Destination</th>
                    <th>Driver</th>
                    <th>Schedule</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todayVehicleReservations as $index => $reservation)
                <tr>
                    <td>{{ $todayVehicleReservations->firstItem() + $index }}</td>
                    <td>{{ trim($reservation->f_name . ' ' . ($reservation->m_name ?? '') . ' ' . $reservation->l_name) }}</td>
                    <td>{{ optional($reservation->division)->division_unit ?? 'N/A' }}</td>
                    <td>{{ $reservation->vehicle_name }}<br><small class="text-muted">({{ $reservation->plate_number }})</small></td>
                    <td>{{ $reservation->destination }}</td>
                    <td>{{ $reservation->driver_name }}</td>
                    <td>
                        <strong>Depart:</strong> {{ \Carbon\Carbon::parse($reservation->departure_date)->format('M d') }}
                        {{ $reservation->departure_time ? \Carbon\Carbon::parse($reservation->departure_time)->format('h:i A') : '' }}<br>
                        <strong>Return:</strong> {{ \Carbon\Carbon::parse($reservation->return_date)->format('M d') }}
                        {{ $reservation->return_time ? \Carbon\Carbon::parse($reservation->return_time)->format('h:i A') : '' }}
                    </td>
                    <td>
                        <span class="status-badge status-{{ strtolower($reservation->status) }}">
                            {{ $reservation->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2 d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Showing {{ $todayVehicleReservations->firstItem() }} to {{ $todayVehicleReservations->lastItem() }} of {{ $todayVehicleReservations->total() }} reservations
            </div>
            <div>{{ $todayVehicleReservations->links() }}</div>
        </div>
    </div>
    @else
        <div class="alert alert-info mt-3">
            <i class="fa fa-info-circle me-2"></i><strong>No vehicle reservations for today.</strong>
        </div>
    @endif
</div> --}}
@endsection
