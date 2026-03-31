<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('action') && $request->action != '') {
            $query->where('action', $request->action);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(25);

        $users = AuditLog::select('user_id')
            ->join('users', 'audit_logs.user_id', '=', 'users.id')
            ->select('users.id', 'users.firstname', 'users.lastname')
            ->distinct()
            ->get();

        $actions = AuditLog::select('action')->distinct()->pluck('action');

        return view('audit_logs.index', compact('logs', 'users', 'actions'));
    }

    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);
        return view('audit_logs.show', compact('log'));
    }

    public function export(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        AuditLog::log('export', 'Exported audit logs', null, null, ['count' => $logs->count()]);

        $csvData = [];
        $csvData[] = ['Date', 'User', 'Action', 'Description', 'Model Type', 'Model ID', 'IP Address'];

        foreach ($logs as $log) {
            $csvData[] = [
                $log->created_at->format('Y-m-d H:i:s'),
                $log->user ? $log->user->firstname . ' ' . $log->user->lastname : 'N/A',
                $log->action,
                $log->description,
                $log->model_type ?? 'N/A',
                $log->model_id ?? 'N/A',
                $log->ip_address ?? 'N/A',
            ];
        }

        $filename = 'audit_logs_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen($filename, 'w');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        AuditLog::log('export', 'Exported audit logs to CSV', null, null, ['count' => $logs->count()]);

        return response()->download($filename)->deleteFileAfterSend();
    }
}
