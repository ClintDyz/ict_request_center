@extends('layouts.admin')

@section('content')

<style>
.view-toggle {
    text-align: right;
    margin-bottom: 10px;
}

#toggleViewBtn {
    background: #007bff;
    color: white;
    padding: 8px 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#toggleViewBtn.active {
    background: #28a745;
}

/* Status badges */
.badge-status {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
    font-weight: 600;
}

/* ==== Calendar Styling ==== */
#calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
}

.calendar-header {
    font-weight: bold;
    text-align: center;
    padding: 5px;
    background: #f1f1f1;
}

.calendar-day {
    padding: 5px;
    border: 1px solid #ddd;
    min-height: 90px;
    background: #fff;
    position: relative;
    font-size: 12px;
}

.calendar-day strong {
    display: block;
    font-size: 14px;
    margin-bottom: 3px;
}

.event {
    background: #dc3545;
    padding: 2px 4px;
    border-radius: 3px;
    margin-top: 2px;
    display: block;
    font-size: 11px;
    color: white;
}

/* Holiday and today highlights */
.calendar-day.today {
    background-color: #90ee90;
}

.calendar-day.holiday {
    background-color: #ff6961;
    color: white;
}

/* Pagination Style */
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

.search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.search-input-wrapper {
    margin-left: auto;
}

/* auto Search */
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
</style>

<!-- Content header -->
<div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0 me-auto">Declined Zoom Requests</h1>

    <div class="view-toggle">
        <button id="toggleViewBtn">Switch to Calendar View</button>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div id="tableView">
    <!-- Card with table -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-danger text-white">
            <div><i class="fa fa-times-circle me-2"></i> Declined Zoom Requests</div>
        </div>
        <div class="card-body">
        <div class="search-container">
            <div class="page-size-selector">
                <label for="pageSizeSelect">Show:</label>
                <select id="pageSizeSelect">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="width: 250px;">
            </div>
        </div>

            <div class="table-responsive">
                <table id="zoomRequestsTable" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Topic</th>
                            <th>Date</th>
                            <th>Requested By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($zoom_request as $zoom)
                        <tr>
                            <td>{{ $zoom->topic }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($zoom->start_date)->format('M d, Y') }}
                                {{ \Carbon\Carbon::parse($zoom->start_time)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($zoom->end_date)->format('M d, Y') }}
                                {{ \Carbon\Carbon::parse($zoom->end_time)->format('h:i A') }}
                            </td>
                            <td>{{ $zoom->f_name }} {{ $zoom->m_name }} {{ $zoom->l_name }}</td>
                            <td>
                                <span class="badge bg-danger badge-status">Declined</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#eventModal-{{ $zoom->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if(auth()->user()->roles == 'Admin')

                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateZoomRequestModal-{{ $zoom->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteZoomRequestModal-{{ $zoom->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>


                                <!-- Quick Status Update Buttons -->
                                 @if($zoom->status != 'Approved')
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal-{{ $zoom->id }}">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif

                                @if($zoom->status != 'Pending')
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#pendingModal-{{ $zoom->id }}">
                                    <i class="fa-solid fa-arrow-rotate-right"></i>
                                </button>
                                @endif
                                @endif

                            </td>

                        </tr>

                                                <!-- Approve Modal -->
                        <div class="modal fade" id="approveModal-{{ $zoom->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('zoom_request.updateStatus', $zoom->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Approved">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Approve Zoom Request</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to approve this zoom request for "<strong>{{ $zoom->topic }}</strong>"?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                                                <!-- Pending Modal -->
                        <div class="modal fade" id="pendingModal-{{ $zoom->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('zoom_request.updateStatus', $zoom->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="Pending">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title">Pending Zoom Request</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to put this zoom request for Pending"<strong>{{ $zoom->topic }}</strong>"?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-warning">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Update Modal -->
                        <div class="modal fade" id="updateZoomRequestModal-{{ $zoom->id }}" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <form action="{{ route('zoom_request.update', $zoom->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title">Update Zoom Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" name="f_name" value="{{ $zoom->f_name }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" name="l_name" value="{{ $zoom->l_name }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control" name="m_name" value="{{ $zoom->m_name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label class="form-label">Topic</label>
                                                    <input type="text" class="form-control" name="topic" value="{{ $zoom->topic }}" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label">No. of Participants</label>
                                                    <input type="number" class="form-control" name="no_of_participants" value="{{ $zoom->no_of_participants }}" required>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Position</label>
                                                    <div class="searchable-dropdown">
                                                        <input
                                                            type="text"
                                                            class="form-control dropdown-input"
                                                            placeholder="Search Position..."
                                                            value="{{ optional($zoom->position)->position ?? '' }}"
                                                        >
                                                        <ul class="dropdown-list">
                                                            @foreach($position as $pos)
                                                                <li data-value="{{ $pos->id }}">{{ $pos->position }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <input
                                                            type="hidden"
                                                            name="id_position"
                                                            value="{{ optional($zoom->position)->id ?? '' }}"
                                                            required
                                                        >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label">Division Unit</label>
                                                    <div class="searchable-dropdown">
                                                        <input
                                                            type="text"
                                                            class="form-control dropdown-input"
                                                            placeholder="Search Division Unit..."
                                                            value="{{ optional($zoom->divisionUnit)->division_unit ?? '' }}"
                                                        >
                                                        <ul class="dropdown-list">
                                                            @foreach($division_units as $unit)
                                                                <li data-value="{{ $unit->id }}">{{ $unit->division_unit }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <input
                                                            type="hidden"
                                                            name="id_division_unit"
                                                            value="{{ optional($zoom->divisionUnit)->id ?? '' }}"
                                                            required
                                                        >
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-3">
                                                    <label class="form-label">Status *</label>
                                                    <select class="form-select" name="status" required>
                                                        <option value="Pending" {{ $zoom->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="Approved" {{ $zoom->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="Declined" {{ $zoom->status == 'Declined' ? 'selected' : '' }}>Declined</option>
                                                    </select>
                                                </div> --}}
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label">Start Date</label>
                                                    <input type="date" class="form-control" name="start_date" value="{{ $zoom->start_date }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Start Time</label>
                                                    <input type="time" class="form-control" name="start_time" value="{{ $zoom->start_time }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">End Date</label>
                                                    <input type="date" class="form-control" name="end_date" value="{{ $zoom->end_date }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">End Time</label>
                                                    <input type="time" class="form-control" name="end_time" value="{{ $zoom->end_time }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-warning">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteZoomRequestModal-{{ $zoom->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('zoom_request.destroy', $zoom->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Delete Zoom Request</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this zoom request?</p>
                                            <div class="alert alert-warning">
                                                <strong>Topic:</strong> {{ $zoom->topic }}<br>
                                                <strong>Requested By:</strong> {{ $zoom->f_name }} {{ $zoom->l_name }}<br>
                                                <strong>Status:</strong> {{ $zoom->status }}
                                            </div>
                                            <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone!</p>
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
            </div>

        <!-- Pagination Container -->
        <div class="pagination-container">
            <div class="pagination" id="pagination"></div>
        </div>
        </div>
    </div>
</div>

<div id="calendarView" style="display:none;">
    <div id="calendar"></div>
</div>

<!-- View Details Modal -->
@foreach($zoom_request as $zoom)
<div class="modal fade" id="eventModal-{{ $zoom->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Event Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4 class="mb-3">{{ $zoom->topic }}</h4>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p><strong>Requested By:</strong> {{ $zoom->f_name }} {{ $zoom->m_name }} {{ $zoom->l_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong>
                            <span class="badge bg-danger">Declined</span>
                        </p>
                    </div>
                </div>

                <p><strong>Date & Time:</strong><br>
                    {{ \Carbon\Carbon::parse($zoom->start_date)->format('M d, Y') }}
                    {{ \Carbon\Carbon::parse($zoom->start_time)->format('h:i A') }}
                    -
                    {{ \Carbon\Carbon::parse($zoom->end_date)->format('M d, Y') }}
                    {{ \Carbon\Carbon::parse($zoom->end_time)->format('h:i A') }}
                </p>

                <div class="row">
                    <div class="col-md-4">
                        <p><strong>No. of Participants:</strong> {{ $zoom->no_of_participants }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Position:</strong> {{ optional($zoom->position)->position ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Division Unit:</strong> {{ optional($zoom->divisionUnit)->division_unit ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
let currentDate = new Date();

document.getElementById("toggleViewBtn").addEventListener("click", function () {
    const tableView = document.getElementById("tableView");
    const calendarView = document.getElementById("calendarView");

    if (tableView.style.display === "none") {
        tableView.style.display = "block";
        calendarView.style.display = "none";
        this.textContent = "Switch to Calendar View";
        this.classList.remove("active");
    } else {
        tableView.style.display = "none";
        calendarView.style.display = "block";
        this.textContent = "Switch to Table View";
        this.classList.add("active");
        renderCalendar();
    }
});

const zoomEvents = @json($zoom_request);

// === Philippine Holidays - Dynamic by Year ===
function getPhilippineHolidays(year) {
    const fixedHolidays = [
        { month: 1, day: 1, name: "New Year's Day" },
        { month: 5, day: 1, name: "Labor Day" },
        { month: 6, day: 12, name: "Independence Day" },
        { month: 11, day: 1, name: "All Saints' Day" },
        { month: 11, day: 2, name: "All Souls' Day" },
        { month: 11, day: 30, name: "Bonifacio Day" },
        { month: 12, day: 8, name: "Feast of the Immaculate Conception" },
        { month: 12, day: 25, name: "Christmas Day" },
        { month: 12, day: 30, name: "Rizal Day" }
    ];

    const movableHolidays = {
        2025: [
            { month: 2, day: 24, name: "EDSA People Power Anniversary" },
            { month: 3, day: 30, name: "Eid'l Fitr (Tentative)" },
            { month: 4, day: 17, name: "Maundy Thursday" },
            { month: 4, day: 18, name: "Good Friday" },
            { month: 4, day: 19, name: "Black Saturday" },
            { month: 6, day: 6, name: "Eid'l Adha (Tentative)" },
            { month: 8, day: 25, name: "National Heroes Day" }
        ],
        2026: [
            { month: 2, day: 25, name: "EDSA People Power Anniversary" },
            { month: 3, day: 19, name: "Eid'l Fitr (Tentative)" },
            { month: 4, day: 2, name: "Maundy Thursday" },
            { month: 4, day: 3, name: "Good Friday" },
            { month: 4, day: 4, name: "Black Saturday" },
            { month: 4, day: 6, name: "Araw ng Kagitingan" },
            { month: 5, day: 27, name: "Eid'l Adha (Tentative)" },
            { month: 8, day: 31, name: "National Heroes Day" },
            { month: 12, day: 31, name: "Last Day of the Year" }
        ]
    };

    const yearHolidays = [];

    fixedHolidays.forEach(h => {
        yearHolidays.push({
            date: `${year}-${String(h.month).padStart(2, '0')}-${String(h.day).padStart(2, '0')}`,
            name: h.name
        });
    });

    if (movableHolidays[year]) {
        movableHolidays[year].forEach(h => {
            yearHolidays.push({
                date: `${year}-${String(h.month).padStart(2, '0')}-${String(h.day).padStart(2, '0')}`,
                name: h.name
            });
        });
    }

    return yearHolidays;
}

function renderCalendar() {
    const calendar = document.getElementById("calendar");
    calendar.innerHTML = "";

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const today = new Date();
    today.setHours(0,0,0,0);

    const monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];

    const header = document.createElement("div");
    header.style.gridColumn = "span 7";
    header.style.display = "flex";
    header.style.justifyContent = "space-between";
    header.style.alignItems = "center";
    header.style.padding = "15px 10px";
    header.style.background = "linear-gradient(135deg, #dc3545 0%, #c82333 100%)";
    header.style.borderRadius = "8px";
    header.style.marginBottom = "10px";
    header.innerHTML = `
        <button onclick="changeMonth(-1)" style="background: white; color: #dc3545; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.3s;">&#8592; Prev</button>
        <strong style="color: white; font-size: 20px; font-weight: 600;">${monthNames[month]} ${year}</strong>
        <div style="display: flex; gap: 8px;">
            <button onclick="goToday()" style="background: #ffd700; color: #333; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.3s;">Today</button>
            <button onclick="changeMonth(1)" style="background: white; color: #dc3545; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.3s;">Next &#8594;</button>
        </div>
    `;
    calendar.appendChild(header);

    const weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    weekdays.forEach((day, index) => {
        const cell = document.createElement("div");
        cell.classList.add("calendar-header");
        cell.textContent = day;
        cell.style.color = index === 0 ? "#dc3545" : "#007bff";
        cell.style.fontWeight = "bold";
        calendar.appendChild(cell);
    });

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement("div");
        empty.classList.add("calendar-day");
        calendar.appendChild(empty);
    }

    for (let d = 1; d <= daysInMonth; d++) {
        const day = document.createElement("div");
        day.classList.add("calendar-day");
        const current = new Date(year, month, d);
        day.innerHTML = `<strong>${d}</strong>`;

        if (current.getTime() === today.getTime()) {
            day.classList.add("today");
        }

        const currentISO = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
        const holidays = getPhilippineHolidays(year);
        const holiday = holidays.find(h => h.date === currentISO);
        if (holiday) {
            day.classList.add("holiday");
            const holidaySpan = document.createElement('span');
            holidaySpan.className = 'event';
            holidaySpan.style.background = '#ff6961';
            holidaySpan.textContent = holiday.name;
            day.appendChild(holidaySpan);
        }

        zoomEvents.forEach(event => {
            const start = new Date(event.start_date);
            const end = new Date(event.end_date);
            start.setHours(0, 0, 0, 0);
            end.setHours(0, 0, 0, 0);
            current.setHours(0, 0, 0, 0);

            if (current >= start && current <= end) {
                const eventSpan = document.createElement('span');
                eventSpan.className = 'event';
                eventSpan.style.background = '#dc3545';
                eventSpan.style.color = 'white';
                eventSpan.style.cursor = 'pointer';
                eventSpan.textContent = event.topic;
                eventSpan.setAttribute('data-event-id', event.id);
                day.appendChild(eventSpan);
            }
        });

        calendar.appendChild(day);
    }

    // Reinitialize Bootstrap modal triggers
    const eventSpans = calendar.querySelectorAll('.event[data-event-id]');
    eventSpans.forEach(eventSpan => {
        eventSpan.addEventListener('click', function(e) {
            e.preventDefault();
            const eventId = this.getAttribute('data-event-id');
            const modalElement = document.getElementById(`eventModal-${eventId}`);
            if (modalElement && typeof bootstrap !== 'undefined') {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        });
    });
}

function changeMonth(step) {
    currentDate.setMonth(currentDate.getMonth() + step);
    renderCalendar();
}

function goToday() {
    currentDate = new Date();
    renderCalendar();
}

// DataTable Pagination
document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("#zoomRequestsTable tbody");
    const rows = Array.from(table.querySelectorAll("tr"));
    const searchInput = document.getElementById("searchInput");
    const pageSizeSelect = document.getElementById("pageSizeSelect");
    const paginationContainer = document.getElementById("pagination");

    let currentPage = 1;
    let rowsPerPage = 10;

    function renderTable() {
        table.innerHTML = "";

        let filteredRows = rows.filter(row =>
            row.textContent.toLowerCase().includes(searchInput.value.toLowerCase())
        );

        let totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        currentPage = Math.min(currentPage, totalPages) || 1;

        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        filteredRows.slice(start, end).forEach(row => table.appendChild(row));

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationContainer.innerHTML = "";

        let prevBtn = document.createElement("button");
        prevBtn.textContent = "‹";
        prevBtn.disabled = currentPage === 1;
        prevBtn.classList.toggle("disabled", currentPage === 1);
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        };
        paginationContainer.appendChild(prevBtn);

        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        if (startPage > 1) {
            let firstBtn = createPageButton(1);
            paginationContainer.appendChild(firstBtn);

            if (startPage > 2) {
                let dots = document.createElement("button");
                dots.textContent = "...";
                dots.classList.add("disabled");
                dots.disabled = true;
                paginationContainer.appendChild(dots);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            let pageBtn = createPageButton(i);
            paginationContainer.appendChild(pageBtn);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                let dots = document.createElement("button");
                dots.textContent = "...";
                dots.classList.add("disabled");
                dots.disabled = true;
                paginationContainer.appendChild(dots);
            }

            let lastBtn = createPageButton(totalPages);
            paginationContainer.appendChild(lastBtn);
        }

        let nextBtn = document.createElement("button");
        nextBtn.textContent = "›";
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.classList.toggle("disabled", currentPage === totalPages);
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        };
        paginationContainer.appendChild(nextBtn);
    }

    function createPageButton(pageNum) {
        let btn = document.createElement("button");
        btn.textContent = pageNum;
        btn.classList.toggle("active", pageNum === currentPage);
        btn.onclick = () => {
            currentPage = pageNum;
            renderTable();
        };
        return btn;
    }

    searchInput.addEventListener("input", () => {
        currentPage = 1;
        renderTable();
    });

    pageSizeSelect.addEventListener("change", () => {
        rowsPerPage = parseInt(pageSizeSelect.value);
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
</script>
@endsection
