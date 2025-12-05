@extends('layouts.admin')

@section('content')

<style>
/* Filter Card Styles */
.filter-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 24px;
}

.filter-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-body {
    padding: 24px;
}

.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 16px;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
}

.filter-group select,
.filter-group input {
    padding: 10px 12px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s;
}

.filter-group select:focus,
.filter-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.filter-actions {
    display: flex;
    gap: 12px;
    margin-top: 20px;
}

.btn-filter {
    padding: 10px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-apply {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-apply:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-reset {
    background: #f1f5f9;
    color: #475569;
}

.btn-reset:hover {
    background: #e2e8f0;
}

.btn-export {
    background: #10b981;
    color: white;
    margin-left: auto;
}

.btn-export:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

/* Statistics Cards */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
}

.stat-card {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
}

.stat-icon.pending {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
}

.stat-icon.approved {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.stat-icon.declined {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.stat-icon.total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-content h3 {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    color: #1e293b;
}

.stat-content p {
    font-size: 14px;
    color: #64748b;
    margin: 4px 0 0 0;
    font-weight: 500;
}

/* Table Styles */
.report-table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table-header {
    background: #f8fafc;
    padding: 20px;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
}

.search-box {
    position: relative;
}

.search-box input {
    padding: 8px 12px 8px 36px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    width: 280px;
    font-size: 14px;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.table-responsive {
    overflow-x: auto;
}

.report-table {
    width: 100%;
    border-collapse: collapse;
}

.report-table thead {
    background: #f1f5f9;
}

.report-table th {
    padding: 16px;
    text-align: left;
    font-size: 13px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
}

.report-table td {
    padding: 16px;
    font-size: 14px;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
}

.report-table tbody tr:hover {
    background: #f8fafc;
}

.badge {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.badge-pending {
    background: #fef3c7;
    color: #92400e;
}

.badge-approved {
    background: #d1fae5;
    color: #065f46;
}

.badge-declined {
    background: #fee2e2;
    color: #991b1b;
}

/* Pagination */
.pagination-container {
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 2px solid #f1f5f9;
}

.pagination-info {
    font-size: 14px;
    color: #64748b;
}

.pagination {
    display: flex;
    gap: 6px;
}

.pagination button {
    padding: 8px 12px;
    border: 2px solid #e2e8f0;
    background: white;
    color: #475569;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s;
    min-width: 36px;
}

.pagination button:hover:not(.disabled):not(.active) {
    background: #f1f5f9;
    border-color: #667eea;
}

.pagination button.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.pagination button.disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    font-size: 64px;
    color: #cbd5e1;
    margin-bottom: 16px;
}

.empty-state h3 {
    font-size: 20px;
    color: #475569;
    margin-bottom: 8px;
}

.empty-state p {
    color: #94a3b8;
    font-size: 14px;
}

/* Print Styles */
@media print {
    .filter-card,
    .btn-export,
    .search-box,
    .pagination-container {
        display: none;
    }
}
</style>

<!-- Page Header -->
<div class="d-flex align-items-center mb-4">
    <h1 class="h3 mb-0 me-auto">
        <i class="fas fa-chart-bar me-2"></i>Zoom Request Report
    </h1>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Card -->
<div class="filter-card">
    <div class="filter-header">
        <div>
            <h4 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Options</h4>
            <small style="opacity: 0.9;">Select criteria to generate report</small>
        </div>
    </div>
    <div class="filter-body">
        <form action="{{ route('report.zoom_report') }}" method="GET" id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-flag me-1"></i>Status</label>
                    <select name="status" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Declined" {{ request('status') == 'Declined' ? 'selected' : '' }}>Declined</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label><i class="fas fa-calendar me-1"></i>Filter By</label>
                    <select name="filter_type" id="filterType" onchange="toggleDateInputs()">
                        <option value="">Select Filter</option>
                        <option value="date_range" {{ request('filter_type') == 'date_range' ? 'selected' : '' }}>Date Range</option>
                        <option value="month" {{ request('filter_type') == 'month' ? 'selected' : '' }}>Month</option>
                        <option value="week" {{ request('filter_type') == 'week' ? 'selected' : '' }}>Week</option>
                    </select>
                </div>

                <div class="filter-group" id="dateRangeGroup" style="display: none;">
                    <label><i class="fas fa-calendar-day me-1"></i>Start Date</label>
                    <input type="date" name="start_date" id="startDate" value="{{ request('start_date') }}">
                </div>

                <div class="filter-group" id="endDateGroup" style="display: none;">
                    <label><i class="fas fa-calendar-day me-1"></i>End Date</label>
                    <input type="date" name="end_date" id="endDate" value="{{ request('end_date') }}">
                </div>

                <div class="filter-group" id="monthGroup" style="display: none;">
                    <label><i class="fas fa-calendar-alt me-1"></i>Month</label>
                    <input type="month" name="month" id="monthInput" value="{{ request('month') }}">
                </div>

                <div class="filter-group" id="weekGroup" style="display: none;">
                    <label><i class="fas fa-calendar-week me-1"></i>Week</label>
                    <input type="week" name="week" id="weekInput" value="{{ request('week') }}">
                </div>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter btn-apply">
                    <i class="fas fa-search"></i>
                    Generate Report
                </button>
                <button type="button" class="btn-filter btn-reset" onclick="resetFilters()">
                    <i class="fas fa-redo"></i>
                    Reset
                </button>
                {{-- <button type="button" class="btn-filter btn-export" onclick="exportToPdf()">
                    <i class="fas fa-file-pdf"></i>
                    Export to PDF
                </button> --}}
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon total">
            <i class="fas fa-list"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $total_requests }}</h3>
            <p>Total Requests</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon pending">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $pending_requests }}</h3>
            <p>Pending</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon approved">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $approved_requests }}</h3>
            <p>Approved</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon declined">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $declined_requests }}</h3>
            <p>Declined</p>
        </div>
    </div>
</div>

<!-- Report Table -->
    {{-- <div class="report-table-container">
    <div class="table-header">
        <h3>
            <i class="fas fa-table me-2"></i>Report Results
            @if(request('filter_type'))
                <small style="font-size: 14px; font-weight: 400; color: #64748b;">
                    ({{ ucfirst(str_replace('_', ' ', request('filter_type'))) }})
                </small>
            @endif
        </h3>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search in results...">
        </div>
    </div>

<div class="table-responsive">
        @if($zoom_requests->isEmpty())
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Records Found</h3>
                <p>Try adjusting your filter criteria</p>
            </div>
        @else
            <table class="report-table" id="reportTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Topic</th>
                        <th>Requested By</th>
                        <th>Position</th>
                        <th>Division/Unit</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Participants</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($zoom_requests as $index => $zoom)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $zoom->topic }}</strong></td>
                        <td>{{ $zoom->f_name }} {{ $zoom->m_name }} {{ $zoom->l_name }}</td>
                        <td>{{ optional($zoom->position)->position ?? 'N/A' }}</td>
                        <td>{{ optional($zoom->divisionUnit)->division_unit ?? 'N/A' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($zoom->start_date)->format('M d, Y') }}
                            <br>
                            <small style="color: #64748b;">{{ \Carbon\Carbon::parse($zoom->start_time)->format('h:i A') }}</small>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($zoom->end_date)->format('M d, Y') }}
                            <br>
                            <small style="color: #64748b;">{{ \Carbon\Carbon::parse($zoom->end_time)->format('h:i A') }}</small>
                        </td>
                        <td>{{ $zoom->no_of_participants }}</td>
                        <td>
                            @if($zoom->status == 'Pending')
                                <span class="badge badge-pending">Pending</span>
                            @elseif($zoom->status == 'Approved')
                                <span class="badge badge-approved">Approved</span>
                            @else
                                <span class="badge badge-declined">Declined</span>
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($zoom->created_at)->format('M d, Y') }}
                            <br>
                            <small style="color: #64748b;">{{ \Carbon\Carbon::parse($zoom->created_at)->format('h:i A') }}</small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if(!$zoom_requests->isEmpty())
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <strong>1</strong> to <strong>{{ $zoom_requests->count() }}</strong> of <strong>{{ $zoom_requests->count() }}</strong> entries
        </div>
    </div>
    @endif
</div> --}}

<script>
// Toggle date input visibility based on filter type
function toggleDateInputs() {
    const filterType = document.getElementById('filterType').value;

    // Hide all groups first
    document.getElementById('dateRangeGroup').style.display = 'none';
    document.getElementById('endDateGroup').style.display = 'none';
    document.getElementById('monthGroup').style.display = 'none';
    document.getElementById('weekGroup').style.display = 'none';

    // Show relevant groups
    if (filterType === 'date_range') {
        document.getElementById('dateRangeGroup').style.display = 'block';
        document.getElementById('endDateGroup').style.display = 'block';
    } else if (filterType === 'month') {
        document.getElementById('monthGroup').style.display = 'block';
    } else if (filterType === 'week') {
        document.getElementById('weekGroup').style.display = 'block';
    }
}

// Reset all filters
function resetFilters() {
    window.location.href = "{{ route('report.zoom_report') }}";
}

// Export to PDF
function exportToPdf() {
    const params = new URLSearchParams(window.location.search);
    params.append('export', 'pdf');
    window.location.href = "{{ route('report.zoom_report') }}?" + params.toString();
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#reportTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleDateInputs();
});
</script>

@endsection
