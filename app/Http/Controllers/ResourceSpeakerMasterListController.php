<?php

namespace App\Http\Controllers;

use App\Models\Rstbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ResourceSpeakerMasterListController extends Controller
{
public function index(Request $request)
{
    $status = $request->get('status', 'all');

    // Check if user is admin
    $isAdmin = auth()->user()->emp_type == '0';

    // Join with accreditation_averages table to get avg_total
    $query = Rstbl::with(['expertises', 'office'])
                  ->leftJoin('accreditation_averages', 'rstbl.id', '=', 'accreditation_averages.rstbl_id')
                  ->select('rstbl.*', 'accreditation_averages.avg_total');

    if ($isAdmin) {
        // Admin can see all speakers based on status filter
        if ($status !== 'all') {
            $query->where('rstbl.status', $status);
        }
    } else {
        // Non-admin: Only show Accredited speakers with score >= 75
        $query->where('rstbl.status', 'Accredited')
              ->where('accreditation_averages.avg_total', '>=', 75);
    }

    $speakers = $query->orderBy('rstbl.created_at', 'desc')->get();

    // Calculate stats based on user role
    if ($isAdmin) {
        $stats = [
            'total' => Rstbl::count(),
            'pending' => Rstbl::where('status', 'Pending')->count(),
            'approved' => Rstbl::where('status', 'Approved')->count(),
            'accredited' => Rstbl::where('status', 'Accredited')->count(),
        ];
    } else {
        // Non-admin: Only count Accredited with score >= 75
        $accreditedCount = Rstbl::join('accreditation_averages', 'rstbl.id', '=', 'accreditation_averages.rstbl_id')
                                ->where('rstbl.status', 'Accredited')
                                ->where('accreditation_averages.avg_total', '>=', 75)
                                ->count();

        $stats = [
            'total' => $accreditedCount,
            'pending' => 0,
            'approved' => 0,
            'accredited' => $accreditedCount,
        ];
    }

    return view('resource_speaker.masterlist', compact('speakers', 'status', 'stats', 'isAdmin'));
}

    public function export(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Rstbl::with(['expertises', 'office']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $speakers = $query->orderBy('created_at', 'desc')->get();

        // Create CSV content
        $headers = [
            'Content-Type' => 'text/csv',
            
            'Content-Disposition' => 'attachment; filename="resource_speakers_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($speakers) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel to recognize UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Add headers
            fputcsv($file, [
                'ID',
                'Last Name',
                'Given Name',
                'Middle Name',
                'Extension',
                'Email',
                'Gender',
                'Date of Birth',
                'Age',
                'Expertise',
                'Office/Agency',
                'Home Address',
                'Municipality',
                'Province',
                'Contact Number',
                'Status',
                'Date Registered',
            ]);

            // Add data
            foreach ($speakers as $speaker) {
                fputcsv($file, [
                    $speaker->id,
                    $speaker->last_name,
                    $speaker->given_name,
                    $speaker->middle_name,
                    $speaker->ext_name,
                    $speaker->email,
                    $speaker->gender,
                    $speaker->date_of_birth,
                    $speaker->age,
                    $speaker->expertises->pluck('expertis')->implode(', '),
                    optional($speaker->office)->office_organization,
                    $speaker->home_address,
                    $speaker->home_municipality,
                    $speaker->home_province,
                    $speaker->home_cell_no,
                    $speaker->status ?? 'Pending',
                    $speaker->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // Alternative: Export as Excel using PhpSpreadsheet
    public function exportExcel(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Rstbl::with(['expertises', 'office']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $speakers = $query->orderBy('created_at', 'desc')->get();

        // Create a simple HTML table that Excel can read
        $filename = 'resource_speakers_' . date('Y-m-d') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        echo '</head>';
        echo '<body>';
        echo '<table border="1">';

        // Headers
        echo '<tr style="background-color: #0070C0; color: white; font-weight: bold;">';
        echo '<th>ID</th>';
        echo '<th>Last Name</th>';
        echo '<th>Given Name</th>';
        echo '<th>Middle Name</th>';
        echo '<th>Extension</th>';
        echo '<th>Email</th>';
        echo '<th>Gender</th>';
        echo '<th>Date of Birth</th>';
        echo '<th>Age</th>';
        echo '<th>Expertise</th>';
        echo '<th>Office/Agency</th>';
        echo '<th>Home Address</th>';
        echo '<th>Municipality</th>';
        echo '<th>Province</th>';
        echo '<th>Contact Number</th>';
        echo '<th>Status</th>';
        echo '<th>Date Registered</th>';
        echo '</tr>';

        // Data
        foreach ($speakers as $speaker) {
            echo '<tr>';
            echo '<td>' . $speaker->id . '</td>';
            echo '<td>' . $speaker->last_name . '</td>';
            echo '<td>' . $speaker->given_name . '</td>';
            echo '<td>' . $speaker->middle_name . '</td>';
            echo '<td>' . $speaker->ext_name . '</td>';
            echo '<td>' . $speaker->email . '</td>';
            echo '<td>' . $speaker->gender . '</td>';
            echo '<td>' . $speaker->date_of_birth . '</td>';
            echo '<td>' . $speaker->age . '</td>';
            echo '<td>' . $speaker->expertises->pluck('expertis')->implode(', ') . '</td>';
            echo '<td>' . optional($speaker->office)->office_organization . '</td>';
            echo '<td>' . $speaker->home_address . '</td>';
            echo '<td>' . $speaker->home_municipality . '</td>';
            echo '<td>' . $speaker->home_province . '</td>';
            echo '<td>' . $speaker->home_cell_no . '</td>';
            echo '<td>' . ($speaker->status ?? 'Pending') . '</td>';
            echo '<td>' . $speaker->created_at->format('Y-m-d H:i:s') . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</body>';
        echo '</html>';

        exit;
    }
}
