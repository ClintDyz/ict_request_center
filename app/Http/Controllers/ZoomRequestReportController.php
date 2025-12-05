<?php

namespace App\Http\Controllers;

use App\Models\ZoomRequest;
use App\Models\Position;
use App\Models\DivisionUnit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\PdfHelper;

class ZoomRequestReportController extends Controller
{
    public function index(Request $request)
    {
        $query = ZoomRequest::with(['position', 'divisionUnit']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date type
        if ($request->filled('filter_type')) {
            switch ($request->filter_type) {
                case 'date_range':
                    if ($request->filled('start_date') && $request->filled('end_date')) {
                        $query->whereBetween('start_date', [
                            $request->start_date,
                            $request->end_date
                        ]);
                    }
                    break;

                case 'month':
                    if ($request->filled('month')) {
                        $date = Carbon::parse($request->month);
                        $query->whereYear('start_date', $date->year)
                              ->whereMonth('start_date', $date->month);
                    }
                    break;

                case 'week':
                    if ($request->filled('week')) {
                        $parts = explode('-W', $request->week);
                        if (count($parts) == 2) {
                            $year = $parts[0];
                            $week = $parts[1];

                            $startDate = Carbon::now()->setISODate($year, $week)->startOfWeek();
                            $endDate = Carbon::now()->setISODate($year, $week)->endOfWeek();

                            $query->whereBetween('start_date', [
                                $startDate->format('Y-m-d'),
                                $endDate->format('Y-m-d')
                            ]);
                        }
                    }
                    break;
            }
        }

        $zoom_requests = $query->orderBy('created_at', 'desc')->get();

        // Statistics
        $total_requests = $zoom_requests->count();
        $pending_requests = $zoom_requests->where('status', 'Pending')->count();
        $approved_requests = $zoom_requests->where('status', 'Approved')->count();
        $declined_requests = $zoom_requests->where('status', 'Declined')->count();

        // Export to PDF if requested
        if ($request->has('export') && $request->export == 'pdf') {
            return $this->exportToPdf($zoom_requests, $request);
        }

        return view('report.zoom_report', compact(
            'zoom_requests',
            'total_requests',
            'pending_requests',
            'approved_requests',
            'declined_requests'
        ));
    }

    private function exportToPdf($zoom_requests, $request)
    {
        // Create new PDF document
        $pdf = new PdfHelper('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('ICT Management System');
        $pdf->SetAuthor('ICT Management System');
        $pdf->SetTitle('Zoom Request Report');
        $pdf->SetSubject('Zoom Request Report');

        // Set margins
        $pdf->SetMargins(15, 35, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 20);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 9);

        // Filter Information
        $filterHtml = $this->getFilterInfo($request);
        if ($filterHtml) {
            $pdf->writeHTML($filterHtml, true, false, true, false, '');
            $pdf->Ln(5);
        }

        // Statistics Summary
        $statsHtml = $this->getStatisticsHtml($zoom_requests);
        $pdf->writeHTML($statsHtml, true, false, true, false, '');
        $pdf->Ln(8);

        // Table Header
        $html = '
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th {
                background-color: #667eea;
                color: white;
                font-weight: bold;
                padding: 8px;
                text-align: left;
                font-size: 8px;
            }
            td {
                padding: 6px;
                border-bottom: 1px solid #e2e8f0;
                font-size: 8px;
            }
            tr:nth-child(even) {
                background-color: #f8fafc;
            }
            .badge {
                padding: 3px 8px;
                border-radius: 3px;
                font-weight: bold;
                font-size: 7px;
            }
            .badge-pending {
                background-color: #fef3c7;
                color: #92400e;
            }
            .badge-approved {
                background-color: #d1fae5;
                color: #065f46;
            }
            .badge-declined {
                background-color: #fee2e2;
                color: #991b1b;
            }
        </style>

        <table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th width="20%">Topic</th>
                    <th width="15%">Requested By</th>
                    <th width="12%">Position</th>
                    <th width="12%">Division/Unit</th>
                    <th width="10%">Start Date</th>
                    <th width="10%">End Date</th>
                    <th width="6%">Participants</th>
                    <th width="8%">Status</th>
                    <th width="12%">Created At</th>
                </tr>
            </thead>
            <tbody>';

        // Table Body
        $index = 1;
        foreach ($zoom_requests as $zoom) {
            $statusClass = '';
            $statusText = $zoom->status;

            if ($zoom->status == 'Pending') {
                $statusClass = 'badge-pending';
            } elseif ($zoom->status == 'Approved') {
                $statusClass = 'badge-approved';
            } else {
                $statusClass = 'badge-declined';
            }

            $fullName = $zoom->f_name . ' ' . ($zoom->m_name ? $zoom->m_name . ' ' : '') . $zoom->l_name;

            $html .= '
                <tr>
                    <td align="center">' . $index++ . '</td>
                    <td><strong>' . htmlspecialchars($zoom->topic) . '</strong></td>
                    <td>' . htmlspecialchars($fullName) . '</td>
                    <td>' . htmlspecialchars(optional($zoom->position)->position ?? 'N/A') . '</td>
                    <td>' . htmlspecialchars(optional($zoom->divisionUnit)->division_unit ?? 'N/A') . '</td>
                    <td>' . Carbon::parse($zoom->start_date)->format('M d, Y') . '<br/><small>' . Carbon::parse($zoom->start_time)->format('h:i A') . '</small></td>
                    <td>' . Carbon::parse($zoom->end_date)->format('M d, Y') . '<br/><small>' . Carbon::parse($zoom->end_time)->format('h:i A') . '</small></td>
                    <td align="center">' . $zoom->no_of_participants . '</td>
                    <td align="center"><span class="badge ' . $statusClass . '">' . $statusText . '</span></td>
                    <td>' . Carbon::parse($zoom->created_at)->format('M d, Y') . '<br/><small>' . Carbon::parse($zoom->created_at)->format('h:i A') . '</small></td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>';

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $filename = 'zoom_request_report_' . date('Y-m-d_His') . '.pdf';
        return $pdf->Output($filename, 'D'); // D = Download
    }

    private function getFilterInfo($request)
    {
        $filters = [];

        if ($request->filled('status')) {
            $filters[] = '<strong>Status:</strong> ' . $request->status;
        }

        if ($request->filled('filter_type')) {
            switch ($request->filter_type) {
                case 'date_range':
                    if ($request->filled('start_date') && $request->filled('end_date')) {
                        $filters[] = '<strong>Date Range:</strong> ' .
                            Carbon::parse($request->start_date)->format('M d, Y') . ' - ' .
                            Carbon::parse($request->end_date)->format('M d, Y');
                    }
                    break;
                case 'month':
                    if ($request->filled('month')) {
                        $filters[] = '<strong>Month:</strong> ' . Carbon::parse($request->month)->format('F Y');
                    }
                    break;
                case 'week':
                    if ($request->filled('week')) {
                        $filters[] = '<strong>Week:</strong> ' . $request->week;
                    }
                    break;
            }
        }

        if (!empty($filters)) {
            return '<div style="background-color: #f1f5f9; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                        <strong style="color: #667eea;">Applied Filters:</strong> ' .
                        implode(' | ', $filters) .
                    '</div>';
        }

        return '';
    }

    private function getStatisticsHtml($zoom_requests)
    {
        $total = $zoom_requests->count();
        $pending = $zoom_requests->where('status', 'Pending')->count();
        $approved = $zoom_requests->where('status', 'Approved')->count();
        $declined = $zoom_requests->where('status', 'Declined')->count();

        return '
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td width="25%" style="background-color: #667eea; color: white; text-align: center; border-radius: 5px;">
                    <strong style="font-size: 20px;">' . $total . '</strong><br/>
                    <span style="font-size: 10px;">Total Requests</span>
                </td>
                <td width="25%" style="background-color: #fbbf24; color: white; text-align: center; border-radius: 5px;">
                    <strong style="font-size: 20px;">' . $pending . '</strong><br/>
                    <span style="font-size: 10px;">Pending</span>
                </td>
                <td width="25%" style="background-color: #10b981; color: white; text-align: center; border-radius: 5px;">
                    <strong style="font-size: 20px;">' . $approved . '</strong><br/>
                    <span style="font-size: 10px;">Approved</span>
                </td>
                <td width="25%" style="background-color: #ef4444; color: white; text-align: center; border-radius: 5px;">
                    <strong style="font-size: 20px;">' . $declined . '</strong><br/>
                    <span style="font-size: 10px;">Declined</span>
                </td>
            </tr>
        </table>';
    }
}
