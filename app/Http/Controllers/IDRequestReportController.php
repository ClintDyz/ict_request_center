<?php

namespace App\Http\Controllers;

use App\Models\IDRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IDRequestReportController extends Controller
{
    public function index(Request $request)
    {
        $query = IDRequest::with(['position', 'divisionUnit']);

        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Month filter
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('created_at', $request->month)
                  ->whereYear('created_at', $request->year);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Division Unit filter
        if ($request->filled('division_unit')) {
            $query->where('id_division_unit', $request->division_unit);
        }

        // Position filter
        if ($request->filled('position')) {
            $query->where('id_position', $request->position);
        }

        // Blood type filter
        if ($request->filled('blood_type')) {
            $query->where('blood_type', $request->blood_type);
        }

        // Get paginated results
        $idRequests = $query->orderBy('created_at', 'desc')->paginate(25);

        // Statistics
        $stats = $this->getStatistics($request);

        // Get filter options
        $positions = \App\Models\Position::orderBy('position', 'asc')->get();
        $divisionUnits = \App\Models\DivisionUnit::orderBy('division_unit', 'asc')->get();
        $statuses = IDRequest::select('status')->distinct()->whereNotNull('status')->pluck('status');
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        return view('report.id_report', compact(
            'idRequests',
            'stats',
            'positions',
            'divisionUnits',
            'statuses',
            'bloodTypes'
        ));
    }

    private function getStatistics($request)
    {
        $query = IDRequest::query();

        // Apply same filters for statistics
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('id_request.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('id_request.created_at', $request->month)
                  ->whereYear('id_request.created_at', $request->year);
        }

        if ($request->filled('status')) {
            $query->where('id_request.status', $request->status);
        }

        if ($request->filled('division_unit')) {
            $query->where('id_request.id_division_unit', $request->division_unit);
        }

        if ($request->filled('position')) {
            $query->where('id_request.id_position', $request->position);
        }

        if ($request->filled('blood_type')) {
            $query->where('id_request.blood_type', $request->blood_type);
        }

        $totalCount = $query->count();

        // Get by status
        $byStatusQuery = IDRequest::query();
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $byStatusQuery->whereBetween('id_request.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        if ($request->filled('month') && $request->filled('year')) {
            $byStatusQuery->whereMonth('id_request.created_at', $request->month)
                  ->whereYear('id_request.created_at', $request->year);
        }
        if ($request->filled('division_unit')) {
            $byStatusQuery->where('id_request.id_division_unit', $request->division_unit);
        }
        if ($request->filled('position')) {
            $byStatusQuery->where('id_request.id_position', $request->position);
        }
        if ($request->filled('blood_type')) {
            $byStatusQuery->where('id_request.blood_type', $request->blood_type);
        }

        $byStatus = $byStatusQuery->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Get by division
        $byDivisionQuery = IDRequest::query();
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $byDivisionQuery->whereBetween('id_request.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        if ($request->filled('month') && $request->filled('year')) {
            $byDivisionQuery->whereMonth('id_request.created_at', $request->month)
                  ->whereYear('id_request.created_at', $request->year);
        }
        if ($request->filled('status')) {
            $byDivisionQuery->where('id_request.status', $request->status);
        }
        if ($request->filled('position')) {
            $byDivisionQuery->where('id_request.id_position', $request->position);
        }
        if ($request->filled('blood_type')) {
            $byDivisionQuery->where('id_request.blood_type', $request->blood_type);
        }

        $byDivision = $byDivisionQuery
            ->join('division_unit', 'id_request.id_division_unit', '=', 'division_unit.id')
            ->select('division_unit.division_unit as division_name', DB::raw('count(id_request.id) as count'))
            ->groupBy('division_unit.division_unit')
            ->pluck('count', 'division_name');

        // Get by blood type
        $byBloodTypeQuery = IDRequest::query();
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $byBloodTypeQuery->whereBetween('id_request.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        if ($request->filled('month') && $request->filled('year')) {
            $byBloodTypeQuery->whereMonth('id_request.created_at', $request->month)
                  ->whereYear('id_request.created_at', $request->year);
        }
        if ($request->filled('status')) {
            $byBloodTypeQuery->where('id_request.status', $request->status);
        }
        if ($request->filled('division_unit')) {
            $byBloodTypeQuery->where('id_request.id_division_unit', $request->division_unit);
        }
        if ($request->filled('position')) {
            $byBloodTypeQuery->where('id_request.id_position', $request->position);
        }

        $byBloodType = $byBloodTypeQuery->select('blood_type', DB::raw('count(*) as count'))
            ->groupBy('blood_type')
            ->pluck('count', 'blood_type');

        return [
            'total' => $totalCount,
            'by_status' => $byStatus,
            'by_division' => $byDivision,
            'by_blood_type' => $byBloodType,
        ];
    }

    public function export(Request $request)
    {
        $query = IDRequest::with(['position', 'divisionUnit']);

        // Apply same filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('created_at', $request->month)
                  ->whereYear('created_at', $request->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $idRequests = $query->orderBy('created_at', 'desc')->get();

        $filename = 'id_requests_report_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($idRequests) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'ID',
                'First Name',
                'Last Name',
                'Middle Name',
                'Nickname',
                'Birthdate',
                'Blood Type',
                'Position',
                'Division/Unit',
                'Emergency Contact',
                'Emergency Address',
                'Emergency Number',
                'Status',
                'Created At',
                'Updated At'
            ]);

            // CSV Data
            foreach ($idRequests as $request) {
                fputcsv($file, [
                    $request->id,
                    $request->f_name,
                    $request->l_name,
                    $request->m_name,
                    $request->nick_name,
                    $request->birthdate,
                    $request->blood_type,
                    $request->position->position ?? 'N/A',
                    $request->divisionUnit->division_unit ?? 'N/A',
                    $request->emergency_contact_name,
                    $request->emergency_contact_address,
                    $request->emergency_contact_number,
                    $request->status,
                    $request->created_at,
                    $request->updated_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
