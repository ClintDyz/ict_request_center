@extends('layouts.admin')

@section('content')
<style>
/* Pagination and Search Styles */
.pagination-container {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-top: 15px;
    gap: 15px;
}

.pagination {
    display: flex;
    gap: 5px;
    align-items: center;
}

.pagination button {
    padding: 6px 12px;
    border: 1px solid #dee2e6;
    background: white;
    color: #0d6efd;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
    min-width: 38px;
}

.pagination button:hover:not(.disabled):not(.active) {
    background: #e7f1ff;
    border-color: #0d6efd;
}

.pagination button.active {
    background: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.pagination button.disabled {
    background: #e9ecef;
    color: #6c757d;
    cursor: not-allowed;
    border-color: #dee2e6;
}

.page-size-selector {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.page-size-selector select {
    padding: 6px 10px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.search-filter-container {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    font-size: 13px;
    font-weight: 600;
    color: #495057;
    margin: 0;
}

.filter-group input,
.filter-group select {
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.filter-group input:focus,
.filter-group select:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
}

.filter-actions {
    display: flex;
    align-items: flex-end;
    gap: 8px;
}

.filter-actions button {
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-reset {
    background: #6c757d;
    color: white;
}

.btn-reset:hover {
    background: #5a6268;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge::before {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.status-badge.pending {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-badge.pending::before {
    background: #ffc107;
}

.status-badge.approved {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-badge.approved::before {
    background: #28a745;
}

.status-badge.declined {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.status-badge.declined::before {
    background: #dc3545;
}

.btn-view {
    background: #17a2b8;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s;
}

.btn-view:hover {
    background: #138496;
}

.action-buttons {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}

.searchable-dropdown {
    position: relative;
}

.searchable-dropdown .dropdown-list {
    position: absolute;
    width: 100%;
    max-height: 180px;
    overflow-y: auto;
    background: white;
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index: 1000;
    display: none;
    list-style: none;
    padding: 0;
    margin: 0;
}

.searchable-dropdown .dropdown-list li {
    padding: 8px 12px;
    cursor: pointer;
}

.searchable-dropdown .dropdown-list li:hover {
    background-color: #007bff;
    color: white;
}

.searchable-dropdown.active .dropdown-list {
    display: block;
}

.calendar-container {
    display: none;
}

.calendar-container.active {
    display: block;
}

.table-container {
    display: block;
}

.table-container.hidden {
    display: none;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.calendar-nav {
    display: flex;
    gap: 10px;
    align-items: center;
}

.calendar-nav button {
    padding: 8px 16px;
    border: 1px solid #dee2e6;
    background: white;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
}

.calendar-nav button:hover {
    background: #e7f1ff;
}

.calendar-nav .today-btn {
    background: #ffc107;
    border-color: #ffc107;
    color: #000;
}

.calendar-nav .today-btn:hover {
    background: #ffb300;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background: #dee2e6;
    border: 1px solid #dee2e6;
}

.calendar-day-header {
    background: #6c63ff;
    color: white;
    padding: 12px;
    text-align: center;
    font-weight: 600;
}

.calendar-day {
    background: white;
    min-height: 120px;
    padding: 8px;
    position: relative;
    overflow: hidden;
}

.calendar-day.other-month {
    background: #f8f9fa;
    color: #6c757d;
}

.calendar-day.today {
    background: #fff9e6;
}

.day-number {
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}

.calendar-events-container {
    max-height: 85px;
    overflow: hidden;
}

.calendar-event {
    background: #28a745;
    color: white;
    padding: 4px 6px;
    margin-bottom: 4px;
    border-radius: 4px;
    font-size: 11px;
    cursor: pointer;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    transition: all 0.2s;
}

.calendar-event:hover {
    background: #218838;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.calendar-event.pending {
    background: #ffc107;
    color: #000;
}

.calendar-event.approved {
    background: #28a745;
}

.calendar-event.declined {
    background: #dc3545;
}

.show-more {
    background: #6c757d;
    color: white;
    padding: 4px 6px;
    border-radius: 4px;
    font-size: 11px;
    cursor: pointer;
    text-align: center;
    margin-top: 4px;
    font-weight: 600;
}

.show-more:hover {
    background: #5a6268;
}

.requestor-item {
    background: #f8f9fa;
    border: 2px solid #dee2e6 !important;
}

.remove-requestor-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}

.view-toggle {
    display: flex;
    gap: 0;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    overflow: hidden;
}

.view-toggle button {
    padding: 8px 20px;
    border: none;
    background: white;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
}

.view-toggle button.active {
    background: #0d6efd;
    color: white;
}

.view-toggle button:hover:not(.active) {
    background: #e7f1ff;
}

.no-results {
    text-align: center;
    padding: 40px;
    color: #6c757d;
    font-size: 16px;
}

.no-results i {
    font-size: 48px;
    margin-bottom: 15px;
    opacity: 0.5;
}
</style>

<div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0 me-auto">Vehicle Reservations</h1>
    <div class="view-toggle me-3">
        <button id="tableViewBtn" class="active">
            <i class="fa fa-table me-1"></i> Table View
        </button>
        <button id="calendarViewBtn">
            <i class="fa fa-calendar me-1"></i> Calendar View
        </button>
    </div>
</div>

<!-- Table View -->
<div class="table-container" id="tableView">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
            <div><i class="fa fa-car me-2"></i> Vehicle Reservation List</div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReservationModal">
                <i class="fa-solid fa-circle-plus me-1"></i> Create Reservation
            </button>
        </div>

        <div class="card-body">
            <div class="search-filter-container">
                <div class="filter-group">
                    <label for="searchInput">🔍 Search</label>
                    <input type="text" id="searchInput" placeholder="Search by name, destination..." />
                </div>
                <div class="filter-group">
                    <label for="vehicleFilter">🚗 Vehicle</label>
                    <select id="vehicleFilter">
                        <option value="">All Vehicles</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="statusFilter">📊 Status</label>
                    <select id="statusFilter">
                        <option value="">All Status</option>
                        <option value="Pending">🟡 Pending</option>
                        <option value="Approved">🟢 Approved</option>
                        <option value="Declined">🔴 Declined</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button class="btn-reset" id="resetFilters">
                        <i class="fa fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="page-size-selector">
                    <label for="pageSizeSelect">Show:</label>
                    <select id="pageSizeSelect">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div id="resultCount" style="color: #6c757d; font-size: 14px;"></div>
            </div>

            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered display">
                    <thead>
                        <tr>
                            <th>Requested By</th>
                            <th>Division</th>
                            <th>Position</th>
                            <th>Destination</th>
                            <th>Departure</th>
                            <th>Return</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Status</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $r)
                        <tr data-vehicle="{{ $r->vehicle_name }}" data-status="{{ $r->status }}" data-division="{{ $r->division->division_unit ?? '' }}">
                            <td>{{ $r->f_name }} {{ $r->m_name }} {{ $r->l_name }}</td>
                            <td>{{ $r->division->division_unit ?? 'N/A' }}</td>
                            <td>{{ $r->position->position ?? 'N/A' }}</td>
                            <td>{{ $r->destination }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->departure_date)->format('M d, Y') }} {{ $r->departure_time }}</td>
                            <td>{{ $r->return_date ? \Carbon\Carbon::parse($r->return_date)->format('M d, Y') : 'N/A' }} {{ $r->return_time }}</td>
                            <td>{{ $r->vehicle_name }} ({{ $r->plate_number }})</td>
                            <td>{{ $r->driver_name }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($r->status) }}">
                                    {{ $r->status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-view" onclick='viewReservationDetails(@json($r))'>
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="openEditModal({{ $r->id }})">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteReservationModal-{{ $r->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteReservationModal-{{ $r->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('vehicle_reservations.destroy', $r->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Delete Reservation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete the reservation of <strong>{{ $r->f_name }} {{ $r->l_name }}</strong> to <strong>{{ $r->destination }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
                <div id="noResults" class="no-results" style="display: none;">
                    <i class="fa fa-search"></i>
                    <p>No reservations found matching your filters.</p>
                </div>
            </div>

            <div class="pagination-container">
                <div class="pagination" id="pagination"></div>
            </div>
        </div>
    </div>
</div>

<!-- Calendar View -->
<div class="calendar-container" id="calendarView">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
            <div><i class="fa fa-calendar me-2"></i> Vehicle Reservation Calendar</div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReservationModal">
                <i class="fa-solid fa-circle-plus me-1"></i> Create Reservation
            </button>
        </div>

        <div class="card-body">
            <div class="calendar-header">
                <div class="calendar-nav">
                    <button id="prevMonth"><i class="fa fa-chevron-left"></i> Prev</button>
                    <button class="today-btn" id="todayBtn">Today</button>
                    <button id="nextMonth">Next <i class="fa fa-chevron-right"></i></button>
                </div>
                <h4 id="currentMonth" class="mb-0"></h4>
            </div>

            <div class="calendar-grid" id="calendarGrid">
                <div class="calendar-day-header">Sun</div>
                <div class="calendar-day-header">Mon</div>
                <div class="calendar-day-header">Tue</div>
                <div class="calendar-day-header">Wed</div>
                <div class="calendar-day-header">Thu</div>
                <div class="calendar-day-header">Fri</div>
                <div class="calendar-day-header">Sat</div>
            </div>
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fa fa-info-circle me-2"></i>Reservation Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column: Details -->
                    <div class="col-md-6">
                        <div id="viewDetailsContent"></div>
                    </div>

                    <!-- Right Column: Attachment Preview -->
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2 mb-3"><i class="fa fa-paperclip me-2"></i>Attachment</h6>
                        <div id="attachmentPreview" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background: #f8f9fa; min-height: 400px;">
                            <p class="text-center text-muted">No attachment available</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Universal Edit Modal -->
<div class="modal fade" id="editReservationModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="editReservationForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Vehicle Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Requestors Section -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0"><i class="fa fa-users me-2"></i>Requestor Information</h6>
                                <button type="button" class="btn btn-sm btn-success" id="addRequestorBtnEdit">
                                    <i class="fa fa-plus me-1"></i> Add Requestor
                                </button>
                            </div>
                        </div>

                        <div class="col-12" id="requestorsContainerEdit">
                            <!-- Requestors will be populated here -->
                        </div>

                        <!-- Trip Details -->
                        <div class="col-12">
                            <h6 class="mb-3 mt-2"><i class="fa fa-map-marker-alt me-2"></i>Trip Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label>Destination</label>
                            <input type="text" name="destination" id="edit_destination" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Purpose</label>
                            <textarea name="purpose" id="edit_purpose" class="form-control" rows="1" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Departure Date</label>
                            <input type="date" name="departure_date" id="edit_departure_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Departure Time</label>
                            <input type="time" name="departure_time" id="edit_departure_time" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Return Date</label>
                            <input type="date" name="return_date" id="edit_return_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Return Time</label>
                            <input type="time" name="return_time" id="edit_return_time" class="form-control">
                        </div>

                        <!-- Vehicle Details -->
                        <div class="col-12">
                            <h6 class="mb-3 mt-2"><i class="fa fa-car me-2"></i>Vehicle & Driver Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label>Vehicle Name</label>
                            <input type="text" name="vehicle_name" id="edit_vehicle_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Plate Number</label>
                            <input type="text" name="plate_number" id="edit_plate_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Driver Name</label>
                            <input type="text" name="driver_name" id="edit_driver_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" id="edit_status" class="form-select" required>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Declined">Declined</option>
                            </select>
                        </div>

                        <!-- File Attachment -->
                        <div class="col-12">
                            <h6 class="mb-3 mt-2"><i class="fa fa-paperclip me-2"></i>Attachment (Optional)</h6>
                        </div>
                        <div class="col-12">
                            <div id="currentAttachment"></div>
                            <label>Upload New File (Leave empty to keep current)</label>
                            <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="text-muted">Allowed: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Reservation Modal -->
<div class="modal fade" id="createReservationModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('vehicle_reservations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Create Vehicle Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0"><i class="fa fa-users me-2"></i>Requestor Information</h6>
                                <button type="button" class="btn btn-sm btn-success" id="addRequestorBtn">
                                    <i class="fa fa-plus me-1"></i> Add Requestor
                                </button>
                            </div>
                        </div>

                        <div class="col-12" id="requestorsContainer">
                            <div class="requestor-item border rounded p-3 mb-3 position-relative">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label>Last Name</label>
                                        <input type="text" name="requestors[0][l_name]" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>First Name</label>
                                        <input type="text" name="requestors[0][f_name]" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Middle Name</label>
                                        <input type="text" name="requestors[0][m_name]" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Position</label>
                                        <div class="searchable-dropdown">
                                            <input type="text" class="form-control dropdown-input" placeholder="Search...">
                                            <ul class="dropdown-list">
                                                @foreach($position as $pos)
                                                    <li data-value="{{ $pos->id }}">{{ $pos->position }}</li>
                                                @endforeach
                                            </ul>
                                            <input type="hidden" name="requestors[0][id_position]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Division Unit</label>
                                        <div class="searchable-dropdown">
                                            <input type="text" class="form-control dropdown-input" placeholder="Search...">
                                            <ul class="dropdown-list">
                                                @foreach($division_units as $unit)
                                                    <li data-value="{{ $unit->id }}">{{ $unit->division_unit }}</li>
                                                @endforeach
                                            </ul>
                                            <input type="hidden" name="requestors[0][id_division_unit]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <h6 class="mb-3 mt-2"><i class="fa fa-map-marker-alt me-2"></i>Trip Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label>Destination</label>
                            <input type="text" name="destination" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Purpose</label>
                            <textarea name="purpose" class="form-control" rows="1" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Departure Date</label>
                            <input type="date" name="departure_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Departure Time</label>
                            <input type="time" name="departure_time" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Return Date</label>
                            <input type="date" name="return_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Return Time</label>
                            <input type="time" name="return_time" class="form-control">
                        </div>

                        <div class="col-12">
                            <h6 class="mb-3 mt-2"><i class="fa fa-car me-2"></i>Vehicle & Driver Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label>Vehicle Name</label>
                            <input type="text" name="vehicle_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Plate Number</label>
                            <input type="text" name="plate_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Driver Name</label>
                            <input type="text" name="driver_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="status" value="Pending">
                        </div>

                        <!-- File Attachment -->
                        <div class="col-12">
                            <h6 class="mb-3 mt-2"><i class="fa fa-paperclip me-2"></i>Attachment (Optional)</h6>
                        </div>
                        <div class="col-12">
                            <label>Upload File</label>
                            <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="text-muted">Allowed: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const reservations = @json($reservations);
const positions = @json($position);
const divisions = @json($division_units);

let requestorCount = 1;
let editRequestorCount = 1;

// Open Edit Modal
function openEditModal(id) {
    const reservation = reservations.find(r => r.id === id);
    if (!reservation) return;

    // Set form action
document.getElementById('editReservationForm').action = `/SMC/public/vehicle-reservations/${id}/update`;



    // Populate trip details
    document.getElementById('edit_destination').value = reservation.destination;
    document.getElementById('edit_purpose').value = reservation.purpose;
    document.getElementById('edit_departure_date').value = reservation.departure_date;
    document.getElementById('edit_departure_time').value = reservation.departure_time || '';
    document.getElementById('edit_return_date').value = reservation.return_date || '';
    document.getElementById('edit_return_time').value = reservation.return_time || '';
    document.getElementById('edit_vehicle_name').value = reservation.vehicle_name;
    document.getElementById('edit_plate_number').value = reservation.plate_number;
    document.getElementById('edit_driver_name').value = reservation.driver_name;
    document.getElementById('edit_status').value = reservation.status;

    // Show current attachment
    const currentAttachmentDiv = document.getElementById('currentAttachment');
    if (reservation.attachment) {
        currentAttachmentDiv.innerHTML = `
            <div class="alert alert-info mb-3">
                <i class="fa fa-file me-2"></i>
                <strong>Current File:</strong> ${reservation.attachment.split('/').pop()}
                <a href="/SMC/public/storage/${reservation.attachment}" target="_blank" class="btn btn-sm btn-primary ms-2">
                    <i class="fa fa-eye"></i> View
                </a>
            </div>
        `;
    } else {
        currentAttachmentDiv.innerHTML = '<p class="text-muted">No attachment currently uploaded.</p>';
    }

    // Populate requestors
    const container = document.getElementById('requestorsContainerEdit');
    container.innerHTML = '';
    editRequestorCount = 0;

    // Get requestors array (from JSON or single requestor)
    let requestorsData = [];
    if (reservation.requestors && Array.isArray(reservation.requestors)) {
        requestorsData = reservation.requestors;
    } else {
        // Single requestor fallback
        requestorsData = [{
            l_name: reservation.l_name,
            f_name: reservation.f_name,
            m_name: reservation.m_name,
            id_position: reservation.id_position,
            id_division_unit: reservation.id_division_unit
        }];
    }

    requestorsData.forEach((req, index) => {
        const positionName = positions.find(p => p.id == req.id_position)?.position || '';
        const divisionName = divisions.find(d => d.id == req.id_division_unit)?.division_unit || '';

        addEditRequestor(req, positionName, divisionName, index === 0);
    });

    // Show modal
    new bootstrap.Modal(document.getElementById('editReservationModal')).show();
}

// View reservation details with attachment
function viewReservationDetails(reservation) {
    const modal = new bootstrap.Modal(document.getElementById('viewDetailsModal'));
    const detailsContent = document.getElementById('viewDetailsContent');
    const attachmentPreview = document.getElementById('attachmentPreview');

    const statusClass = reservation.status.toLowerCase();
    const statusEmoji = reservation.status === 'Pending' ? '🟡' :
                       reservation.status === 'Approved' ? '🟢' : '🔴';

    // Populate details
    detailsContent.innerHTML = `
        <h6 class="border-bottom pb-2 mb-3"><i class="fa fa-user me-2"></i>Requestor Information</h6>
        <div class="mb-3">
            <strong>Name:</strong><br>
            ${reservation.f_name} ${reservation.m_name || ''} ${reservation.l_name}
        </div>
        <div class="mb-3">
            <strong>Position:</strong><br>
            ${reservation.position?.position || 'N/A'}
        </div>
        <div class="mb-3">
            <strong>Division:</strong><br>
            ${reservation.division?.division_unit || 'N/A'}
        </div>

        <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fa fa-map-marker-alt me-2"></i>Trip Information</h6>
        <div class="mb-3">
            <strong>Destination:</strong><br>
            ${reservation.destination}
        </div>
        <div class="mb-3">
            <strong>Purpose:</strong><br>
            ${reservation.purpose}
        </div>
        <div class="mb-3">
            <strong>Departure:</strong><br>
            ${new Date(reservation.departure_date).toLocaleDateString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric'
            })} ${reservation.departure_time || ''}
        </div>
        <div class="mb-3">
            <strong>Return:</strong><br>
            ${reservation.return_date
                ? new Date(reservation.return_date).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'long', day: 'numeric'
                })
                : 'N/A'} ${reservation.return_time || ''}
        </div>

        <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fa fa-car me-2"></i>Vehicle & Driver</h6>
        <div class="mb-3">
            <strong>Vehicle:</strong><br>
            ${reservation.vehicle_name}
        </div>
        <div class="mb-3">
            <strong>Plate Number:</strong><br>
            ${reservation.plate_number}
        </div>
        <div class="mb-3">
            <strong>Driver:</strong><br>
            ${reservation.driver_name}
        </div>
        <div class="mb-3">
            <strong>Status:</strong><br>
            <span class="status-badge ${statusClass}">${statusEmoji} ${reservation.status}</span>
        </div>
    `;

    // Populate attachment preview
    if (reservation.attachment) {
        const fileExtension = reservation.attachment.split('.').pop().toLowerCase();
        const fileUrl = `/SMC/public/storage/${reservation.attachment}`;

        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
            // Display image
            attachmentPreview.innerHTML = `
                <div class="text-center">
                    <img src="${fileUrl}" class="img-fluid" style="max-height: 500px; border-radius: 8px;" alt="Attachment">
                    <div class="mt-3">
                        <a href="${fileUrl}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-external-link-alt"></i> Open in New Tab
                        </a>
                    </div>
                </div>
            `;
        } else if (fileExtension === 'pdf') {
            // Display PDF
            attachmentPreview.innerHTML = `
                <iframe src="${fileUrl}" style="width: 100%; height: 500px; border: none; border-radius: 8px;"></iframe>
                <div class="text-center mt-3">
                    <a href="${fileUrl}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-external-link-alt"></i> Open in New Tab
                    </a>

                </div>
            `;
        } else {
            // For other file types (doc, docx)
            attachmentPreview.innerHTML = `
                <div class="text-center p-5">
                    <i class="fa fa-file fa-5x text-primary mb-3"></i>
                    <p class="mb-3"><strong>File:</strong> ${reservation.attachment.split('/').pop()}</p>
                    <p class="text-muted mb-3">This file type cannot be previewed in the browser.</p>
                </div>
            `;
        }
    } else {
        attachmentPreview.innerHTML = `
            <div class="text-center p-5">
                <i class="fa fa-paperclip fa-5x text-muted mb-3" style="opacity: 0.3;"></i>
                <p class="text-muted">No attachment uploaded for this reservation.</p>
            </div>
        `;
    }

    modal.show();
}

// Add requestor to edit modal
function addEditRequestor(data = {}, positionName = '', divisionName = '', isFirst = false) {
    const container = document.getElementById('requestorsContainerEdit');

    const newRequestor = document.createElement('div');
    newRequestor.className = 'requestor-item border rounded p-3 mb-3 position-relative';
    newRequestor.innerHTML = `
        ${!isFirst ? `<button type="button" class="btn btn-sm btn-danger remove-requestor-btn"><i class="fa fa-times"></i></button>` : ''}
        <div class="row g-3">
            <div class="col-md-3">
                <label>Last Name</label>
                <input type="text" name="requestors[${editRequestorCount}][l_name]" class="form-control" value="${data.l_name || ''}" required>
            </div>
            <div class="col-md-3">
                <label>First Name</label>
                <input type="text" name="requestors[${editRequestorCount}][f_name]" class="form-control" value="${data.f_name || ''}" required>
            </div>
            <div class="col-md-2">
                <label>Middle Name</label>
                <input type="text" name="requestors[${editRequestorCount}][m_name]" class="form-control" value="${data.m_name || ''}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Position</label>
                <div class="searchable-dropdown">
                    <input type="text" class="form-control dropdown-input" placeholder="Search..." value="${positionName}">
                    <ul class="dropdown-list">
                        ${positions.map(pos => `<li data-value="${pos.id}">${pos.position}</li>`).join('')}
                    </ul>
                    <input type="hidden" name="requestors[${editRequestorCount}][id_position]" value="${data.id_position || ''}" required>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">Division Unit</label>
                <div class="searchable-dropdown">
                    <input type="text" class="form-control dropdown-input" placeholder="Search..." value="${divisionName}">
                    <ul class="dropdown-list">
                        ${divisions.map(unit => `<li data-value="${unit.id}">${unit.division_unit}</li>`).join('')}
                    </ul>
                    <input type="hidden" name="requestors[${editRequestorCount}][id_division_unit]" value="${data.id_division_unit || ''}" required>
                </div>
            </div>
        </div>
    `;

    container.appendChild(newRequestor);
    editRequestorCount++;

    initializeSearchableDropdowns(newRequestor);

    if (!isFirst) {
        newRequestor.querySelector('.remove-requestor-btn').addEventListener('click', function() {
            newRequestor.remove();
        });
    }
}

// Add requestor button for edit modal
document.getElementById('addRequestorBtnEdit').addEventListener('click', function() {
    addEditRequestor({}, '', '', false);
});

// Populate filter dropdowns
function populateFilters() {
    const vehicles = new Set();
    reservations.forEach(r => vehicles.add(r.vehicle_name));

    const vehicleFilter = document.getElementById('vehicleFilter');
    vehicles.forEach(v => {
        const option = document.createElement('option');
        option.value = v;
        option.textContent = v;
        vehicleFilter.appendChild(option);
    });
}

// View Toggle
const tableViewBtn = document.getElementById('tableViewBtn');
const calendarViewBtn = document.getElementById('calendarViewBtn');
const tableView = document.getElementById('tableView');
const calendarView = document.getElementById('calendarView');

tableViewBtn.addEventListener('click', () => {
    tableViewBtn.classList.add('active');
    calendarViewBtn.classList.remove('active');
    tableView.classList.remove('hidden');
    calendarView.classList.remove('active');
});

calendarViewBtn.addEventListener('click', () => {
    calendarViewBtn.classList.add('active');
    tableViewBtn.classList.remove('active');
    tableView.classList.add('hidden');
    calendarView.classList.add('active');
    renderCalendar();
});

// Calendar functionality
let currentDate = new Date();

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];
    document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    const grid = document.getElementById('calendarGrid');
    while (grid.children.length > 7) {
        grid.removeChild(grid.lastChild);
    }

    const today = new Date();
    const isCurrentMonth = today.getMonth() === month && today.getFullYear() === year;

    for (let i = firstDay - 1; i >= 0; i--) {
        const dayDiv = createDayCell(daysInPrevMonth - i, true, false);
        grid.appendChild(dayDiv);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const isToday = isCurrentMonth && day === today.getDate();
        const dayDiv = createDayCell(day, false, isToday, year, month);
        grid.appendChild(dayDiv);
    }

    const totalCells = firstDay + daysInMonth;
    const remainingCells = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
    for (let day = 1; day <= remainingCells; day++) {
        const dayDiv = createDayCell(day, true, false);
        grid.appendChild(dayDiv);
    }
}

function createDayCell(day, otherMonth, isToday, year, month) {
    const dayDiv = document.createElement('div');
    dayDiv.className = 'calendar-day';
    if (otherMonth) dayDiv.classList.add('other-month');
    if (isToday) dayDiv.classList.add('today');

    const dayNumber = document.createElement('div');
    dayNumber.className = 'day-number';
    dayNumber.textContent = day;
    dayDiv.appendChild(dayNumber);

    if (!otherMonth && year && month !== undefined) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const currentDateObj = new Date(dateStr);

        const dayReservations = reservations.filter(r => {
            const departureDate = new Date(r.departure_date);
            const returnDate = r.return_date ? new Date(r.return_date) : departureDate;
            return currentDateObj >= departureDate && currentDateObj <= returnDate;
        });

        if (dayReservations.length > 0) {
            const eventsContainer = document.createElement('div');
            eventsContainer.className = 'calendar-events-container';
            const maxVisible = 2;

            dayReservations.slice(0, maxVisible).forEach(reservation => {
                const departureDate = new Date(reservation.departure_date);
                const isFirstDay = currentDateObj.getTime() === departureDate.getTime();

                const eventDiv = document.createElement('div');
                eventDiv.className = `calendar-event ${reservation.status.toLowerCase()}`;

                if (isFirstDay) {
                    eventDiv.textContent = `${reservation.f_name} ${reservation.l_name} - ${reservation.destination}`;
                } else {
                    eventDiv.textContent = `↔ ${reservation.f_name} ${reservation.l_name}`;
                }

                eventDiv.onclick = () => openEditModal(reservation.id);
                eventsContainer.appendChild(eventDiv);
            });

            if (dayReservations.length > maxVisible) {
                const showMore = document.createElement('div');
                showMore.className = 'show-more';
                showMore.textContent = `+${dayReservations.length - maxVisible} more`;
                showMore.onclick = (e) => {
                    e.stopPropagation();
                    showAllReservationsForDay(dateStr, dayReservations);
                };
                eventsContainer.appendChild(showMore);
            }

            dayDiv.appendChild(eventsContainer);
        }
    }

    return dayDiv;
}

function showAllReservationsForDay(date, dayReservations) {
    alert(`${dayReservations.length} reservations on this day. Click individual items to view details.`);
}

document.getElementById('prevMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

document.getElementById('nextMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

document.getElementById('todayBtn').addEventListener('click', () => {
    currentDate = new Date();
    renderCalendar();
});

// Table pagination/search with filters
document.addEventListener("DOMContentLoaded", function () {
    populateFilters();

    const table = document.querySelector("#dataTable tbody");
    const rows = Array.from(table.querySelectorAll("tr"));
    const searchInput = document.getElementById("searchInput");
    const vehicleFilter = document.getElementById("vehicleFilter");
    const statusFilter = document.getElementById("statusFilter");
    const pageSizeSelect = document.getElementById("pageSizeSelect");
    const paginationContainer = document.getElementById("pagination");
    const resultCount = document.getElementById("resultCount");
    const noResults = document.getElementById("noResults");
    const dataTable = document.getElementById("dataTable");
    const resetBtn = document.getElementById("resetFilters");

    let currentPage = 1;
    let rowsPerPage = 10;

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedVehicle = vehicleFilter.value;
        const selectedStatus = statusFilter.value;

        return rows.filter(row => {
            const text = row.textContent.toLowerCase();
            const vehicle = row.dataset.vehicle || '';
            const status = row.dataset.status || '';

            const matchesSearch = text.includes(searchTerm);
            const matchesVehicle = !selectedVehicle || vehicle === selectedVehicle;
            const matchesStatus = !selectedStatus || status === selectedStatus;

            return matchesSearch && matchesVehicle && matchesStatus;
        });
    }

    function renderTable() {
        table.innerHTML = "";
        const filtered = applyFilters();
        const totalPages = Math.ceil(filtered.length / rowsPerPage);
        currentPage = Math.min(currentPage, totalPages) || 1;

        resultCount.textContent = `Showing ${filtered.length} of ${rows.length} reservations`;

        if (filtered.length === 0) {
            noResults.style.display = 'block';
            dataTable.style.display = 'none';
            paginationContainer.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            dataTable.style.display = 'table';
            paginationContainer.style.display = 'flex';
        }

        filtered.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage)
                .forEach(r => table.appendChild(r));

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationContainer.innerHTML = "";
        const createBtn = (txt, cls, disabled, click) => {
            const b = document.createElement("button");
            b.textContent = txt;
            if (cls) b.classList.add(cls);
            if (disabled) b.classList.add('disabled');
            b.disabled = disabled;
            if (click) b.onclick = click;
            paginationContainer.appendChild(b);
            return b;
        };

        createBtn("‹", null, currentPage === 1, () => { currentPage--; renderTable(); });

        for (let i = 1; i <= totalPages; i++) {
            createBtn(i, i === currentPage ? "active" : "", false, () => { currentPage = i; renderTable(); });
        }

        createBtn("›", null, currentPage === totalPages, () => { currentPage++; renderTable(); });
    }

    searchInput.addEventListener("input", () => { currentPage = 1; renderTable(); });
    vehicleFilter.addEventListener("change", () => { currentPage = 1; renderTable(); });
    statusFilter.addEventListener("change", () => { currentPage = 1; renderTable(); });
    pageSizeSelect.addEventListener("change", () => { rowsPerPage = +pageSizeSelect.value; renderTable(); });
    resetBtn.addEventListener("click", () => {
        searchInput.value = '';
        vehicleFilter.value = '';
        statusFilter.value = '';
        currentPage = 1;
        renderTable();
    });

    renderTable();
});

// Auto Search Dropdown
document.querySelectorAll('.searchable-dropdown').forEach(dropdown => {
    const input = dropdown.querySelector('.dropdown-input');
    const list = dropdown.querySelector('.dropdown-list');
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');
    const items = list.querySelectorAll('li');

    input.addEventListener('focus', () => dropdown.classList.add('active'));

    input.addEventListener('input', () => {
        const filter = input.value.toLowerCase();
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? 'block' : 'none';
        });
    });

    items.forEach(item => {
        item.addEventListener('click', () => {
            input.value = item.textContent;
            hiddenInput.value = item.dataset.value;
            dropdown.classList.remove('active');
        });
    });

    document.addEventListener('click', e => {
        if (!dropdown.contains(e.target)) dropdown.classList.remove('active');
    });
});

// Add requestor for create modal
document.getElementById('addRequestorBtn').addEventListener('click', function() {
    const container = document.getElementById('requestorsContainer');

    const newRequestor = document.createElement('div');
    newRequestor.className = 'requestor-item border rounded p-3 mb-3 position-relative';
    newRequestor.innerHTML = `
        <button type="button" class="btn btn-sm btn-danger remove-requestor-btn">
            <i class="fa fa-times"></i>
        </button>
        <div class="row g-3">
            <div class="col-md-3">
                <label>Last Name</label>
                <input type="text" name="requestors[${requestorCount}][l_name]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>First Name</label>
                <input type="text" name="requestors[${requestorCount}][f_name]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>Middle Name</label>
                <input type="text" name="requestors[${requestorCount}][m_name]" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Position</label>
                <div class="searchable-dropdown">
                    <input type="text" class="form-control dropdown-input" placeholder="Search...">
                    <ul class="dropdown-list">
                        ${positions.map(pos => `<li data-value="${pos.id}">${pos.position}</li>`).join('')}
                    </ul>
                    <input type="hidden" name="requestors[${requestorCount}][id_position]" required>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">Division Unit</label>
                <div class="searchable-dropdown">
                    <input type="text" class="form-control dropdown-input" placeholder="Search...">
                    <ul class="dropdown-list">
                        ${divisions.map(unit => `<li data-value="${unit.id}">${unit.division_unit}</li>`).join('')}
                    </ul>
                    <input type="hidden" name="requestors[${requestorCount}][id_division_unit]" required>
                </div>
            </div>
        </div>
    `;

    container.appendChild(newRequestor);
    requestorCount++;

    initializeSearchableDropdowns(newRequestor);

    newRequestor.querySelector('.remove-requestor-btn').addEventListener('click', function() {
        newRequestor.remove();
    });
});

function initializeSearchableDropdowns(container) {
    container.querySelectorAll('.searchable-dropdown').forEach(dropdown => {
        const input = dropdown.querySelector('.dropdown-input');
        const list = dropdown.querySelector('.dropdown-list');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
        const items = list.querySelectorAll('li');

        input.addEventListener('focus', () => dropdown.classList.add('active'));

        input.addEventListener('input', () => {
            const filter = input.value.toLowerCase();
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? 'block' : 'none';
            });
        });

        items.forEach(item => {
            item.addEventListener('click', () => {
                input.value = item.textContent;
                hiddenInput.value = item.dataset.value;
                dropdown.classList.remove('active');
            });
        });

        document.addEventListener('click', e => {
            if (!dropdown.contains(e.target)) dropdown.classList.remove('active');
        });
    });
}
</script>

@endsection
