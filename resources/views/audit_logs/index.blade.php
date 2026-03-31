@extends('layouts.admin')

@php
use App\Models\AuditLog;
@endphp

@section('content')
<div class="container-fluid">
    {{-- <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-history"></i> Audit Logs
        </h1> --}}
        {{-- <a href="{{ route('audit_logs.export', request()->all()) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-download"></i> Export CSV
        </a> --}}
    </div>

    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3 bg-success">
            <h6 class="m-0 font-weight-bold" style="color: white">Filter Logs</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('audit_logs.index') }}" class="row g-3">
                <div class="col-md-2">
                    <label for="user_id">User</label>
                    <select name="user_id" id="user_id" class="form-control form-control-sm">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->firstname }} {{ $user->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="action">Action</label>
                    <select name="action" id="action" class="form-control form-control-sm">
                        <option value="">All Actions</option>
                        @foreach($actions as $act)
                            <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>
                                {{ ucfirst($act) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from">Date From</label>
                    <input type="date" name="date_from" id="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to">Date To</label>
                    <input type="date" name="date_to" id="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label for="search">Search Description</label>
                    <input type="text" name="search" id="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Search...">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Date & Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <small>{{ $log->created_at->format('M d, Y') }}</small><br>
                                    <strong>{{ $log->created_at->format('h:i:s A') }}</strong>
                                </td>
                                <td>
                                    @if($log->user)
                                        {{ $log->user->firstname }} {{ $log->user->lastname }}
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>{!! AuditLog::getActionLabel($log->action) !!}</td>
                                <td>{{ $log->description }}</td>
                                <td><small>{{ $log->ip_address ?? 'N/A' }}</small></td>
                                <td>
                                    @if($log->old_values || $log->new_values)
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>

                                        <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1" aria-labelledby="logModalLabel{{ $log->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background: linear-gradient(90deg, #1a2f5a 0%, #243a6e 100%); color: white;">
                                                        <h5 class="modal-title" id="logModalLabel{{ $log->id }}"><i class="fas fa-history"></i> Log Details</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if($log->old_values)
                                                            <h6><strong>Old Values:</strong></h6>
                                                            <pre class="bg-light p-3 rounded" style="font-size: 12px;">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                                        @endif
                                                        @if($log->new_values)
                                                            <h6 class="mt-3"><strong>New Values:</strong></h6>
                                                            <pre class="bg-light p-3 rounded" style="font-size: 12px;">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                                        @endif
                                                        @if($log->model_type)
                                                            <h6 class="mt-3"><strong>Model:</strong></h6>
                                                            <p>{{ class_basename($log->model_type) }} #{{ $log->model_id }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>No audit logs found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
