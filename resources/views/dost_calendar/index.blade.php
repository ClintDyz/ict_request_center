@extends('layouts.admin')

@section('content')

<style>
.calendar-container {
    padding: 20px 0;
}

.calendar-grid {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    background: white;
}

.calendar-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.calendar-day-header {
    padding: 12px;
    text-align: center;
    font-weight: 600;
    color: white !important;
    border-right: 1px solid rgba(255,255,255,0.2);
}

.calendar-day-header:last-child {
    border-right: none;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0;
}

.calendar-day {
    min-height: 100px;
    padding: 8px;
    border: 1px solid #dee2e6;
    background: white;
    position: relative;
    transition: all 0.2s;
}

.calendar-day:hover {
    background: #f8f9fa;
}

.calendar-day.other-month {
    background: #f8f9fa;
    opacity: 0.5;
}

.calendar-day.today {
    background: #fff3cd;
    border: 2px solid #ffc107;
}

.day-number {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 4px;
}

.event-item {
    background: #28a745;
    color: white;
    padding: 4px 6px;
    margin: 2px 0;
    border-radius: 4px;
    font-size: 11px;
    cursor: pointer;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    transition: all 0.2s;
}

.event-item:hover {
    background: #218838;
    transform: scale(1.02);
}

.btn-group .btn.active {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}
</style>


<!-- Content header -->
<div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0 me-auto">DOST-CAR Calendar</h1>
</div>

<!-- Card with toggle and views -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
        <div><i class="fa fa-calendar me-2"></i>DOST-CAR Calendar</div>
        <div class="d-flex gap-2">
            <!-- View Toggle Buttons -->
            <div class="btn-group gap-2" role="group">
                <button type="button" class="btn btn-light btn-sm active" id="tableViewBtn" onclick="switchView('table')">
                    <i class="fa fa-table me-1"></i> Table View
                </button>
                <button type="button" class="btn btn-light btn-sm" id="calendarViewBtn" onclick="switchView('calendar')">
                    <i class="fa fa-calendar me-1"></i> Calendar View
                </button>
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUnitModal">
                <i class="fa-solid fa-circle-plus me-1"></i> Create
            </button>
        </div>
    </div>

    <div class="card-body">
        <!-- Table View -->
        <div id="tableView">
            <!-- Search and Page Size Controls -->
            <div class="search-container">
                <div class="page-size-selector">
                    <label>Show:</label>
                    <select data-table="eventsTable" data-control="pagesize">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="search-input-wrapper">
                    <input type="text" data-table="eventsTable" data-control="search" class="form-control" placeholder="Search..." style="width: 250px;">
                </div>
            </div>

            <div class="table-responsive">
                <table id="eventsTable" class="table table-striped table-bordered auto-paginate" style="width:100%">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>{{ $event->event_title }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-{{ $event->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $event->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination" data-table="eventsTable" data-control="pagination"></div>
            </div>
        </div>

        <!-- Calendar View -->
        <div id="calendarView" style="display: none;">
            <div class="calendar-container">
                <!-- Calendar Navigation -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-primary" onclick="previousMonth()">← Prev</button>
                    <h4 id="currentMonthYear" class="mb-0"></h4>
                    <div>
                        <button class="btn btn-warning" onclick="goToToday()">Today</button>
                        <button class="btn btn-primary" onclick="nextMonth()">Next →</button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="calendar-grid">
                    <div class="calendar-header">
                        <div class="calendar-day-header text-danger">Sun</div>
                        <div class="calendar-day-header text-primary">Mon</div>
                        <div class="calendar-day-header text-primary">Tue</div>
                        <div class="calendar-day-header text-primary">Wed</div>
                        <div class="calendar-day-header text-primary">Thu</div>
                        <div class="calendar-day-header text-primary">Fri</div>
                        <div class="calendar-day-header text-primary">Sat</div>
                    </div>
                    <div id="calendarDays" class="calendar-days"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modals (Create, Update, Delete) -->
@foreach($events as $event)
    <!-- Update Modal -->
    <div class="modal fade" id="updateModal-{{ $event->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('dost_calendar.update', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Update Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Event Title</label>
                            <input type="text" class="form-control" name="event_title" value="{{ $event->event_title }}" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="{{ $event->start_date }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="start_time" value="{{ $event->start_time }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" value="{{ $event->end_date }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">End Time</label>
                                <input type="time" class="form-control" name="end_time" value="{{ $event->end_time }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal-{{ $event->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dost_calendar.destroy', $event->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Delete Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete <strong>{{ $event->event_title }}</strong>?
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Create Event Modal -->
<div class="modal fade" id="createUnitModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('dost_calendar.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Create Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Event Title</label>
                        <input type="text" class="form-control" name="event_title" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="form-control" name="start_time" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">End Time</label>
                            <input type="time" class="form-control" name="end_time" required>
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


<!-- Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" >Event Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <h5 id="eventTitle">Event Details</h5><br>
        <p><strong>Start:</strong> <span id="eventStart"></span></p>
        <p><strong>End:</strong> <span id="eventEnd"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
// Convert PHP events to JavaScript
const events = @json($events);

let currentDate = new Date();
let currentView = 'table';

// Parse events and organize by date
function getEventsForDate(year, month, day) {
    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    return events.filter(event => {
        const eventStart = event.start_date;
        const eventEnd = event.end_date;
        return dateStr >= eventStart && dateStr <= eventEnd;
    });
}

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    // Update header
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                       'July', 'August', 'September', 'October', 'November', 'December'];
    document.getElementById('currentMonthYear').textContent = `${monthNames[month]} ${year}`;

    // Get first day of month and number of days
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    const calendarDays = document.getElementById('calendarDays');
    calendarDays.innerHTML = '';

    const today = new Date();
    const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;

    // Previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        const dayDiv = createDayCell(day, true, false, year, month - 1);
        calendarDays.appendChild(dayDiv);
    }

    // Current month days
    for (let day = 1; day <= daysInMonth; day++) {
        const isToday = isCurrentMonth && day === today.getDate();
        const dayDiv = createDayCell(day, false, isToday, year, month);
        calendarDays.appendChild(dayDiv);
    }

    // Next month days
    const totalCells = calendarDays.children.length;
    const remainingCells = 35 - totalCells; // 5 rows * 7 days
    for (let day = 1; day <= remainingCells; day++) {
        const dayDiv = createDayCell(day, true, false, year, month + 1);
        calendarDays.appendChild(dayDiv);
    }
}

function createDayCell(day, isOtherMonth, isToday, year, month) {
    const dayDiv = document.createElement('div');
    dayDiv.className = 'calendar-day';
    if (isOtherMonth) dayDiv.classList.add('other-month');
    if (isToday) dayDiv.classList.add('today');

    const dayNumber = document.createElement('div');
    dayNumber.className = 'day-number';
    dayNumber.textContent = day;
    dayDiv.appendChild(dayNumber);

    // Add events for this day
    if (!isOtherMonth) {
        const dayEvents = getEventsForDate(year, month, day);
        dayEvents.forEach(event => {
            const eventDiv = document.createElement('div');
            eventDiv.className = 'event-item';
            eventDiv.textContent = event.event_title;
            eventDiv.title = event.event_title;
            eventDiv.onclick = () => showEventDetails(event);
            dayDiv.appendChild(eventDiv);
        });
    }

    return dayDiv;
}

function showEventDetails(event) {
    const startDate = new Date(event.start_date + ' ' + event.start_time);
    const endDate = new Date(event.end_date + ' ' + event.end_time);

    document.getElementById('eventTitle').textContent = event.event_title;
    document.getElementById('eventStart').textContent = startDate.toLocaleString();
    document.getElementById('eventEnd').textContent = endDate.toLocaleString();

    // Show Bootstrap modal
    const modal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
    modal.show();
}


function switchView(view) {
    currentView = view;
    const tableView = document.getElementById('tableView');
    const calendarView = document.getElementById('calendarView');
    const tableBtn = document.getElementById('tableViewBtn');
    const calendarBtn = document.getElementById('calendarViewBtn');

    if (view === 'table') {
        tableView.style.display = 'block';
        calendarView.style.display = 'none';
        tableBtn.classList.add('active');
        calendarBtn.classList.remove('active');
    } else {
        tableView.style.display = 'none';
        calendarView.style.display = 'block';
        tableBtn.classList.remove('active');
        calendarBtn.classList.add('active');
        renderCalendar();
    }
}

function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
}

function goToToday() {
    currentDate = new Date();
    renderCalendar();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    renderCalendar();
});
</script>
@endsection
