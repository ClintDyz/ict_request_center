<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AccreditationPDFService;
use App\Models\RequestResourceSpeaker;
use App\Models\Rstbl;
use App\Models\Accreditation;
use App\Models\Expertis;
use App\Models\AccreditationAverage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use TCPDF;

class AccreditationAverageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $accredited = AccreditationAverage::with([
        'speaker.expertises',
        'rawAccreditations.createdBy'
    ])->paginate(10); // <-- Backend pagination

    return view('accreditation_average.index', compact('accredited'));
}

    public function generate($id, Request $request)
    {
        $accredit = AccreditationAverage::with('speaker.expertises')->findOrFail($id);

        // ✅ Get font scale from request (percentage) and convert to decimal
        $fontPercentage = $request->input('font', 100); // Default 100%
        $fontScale = $fontPercentage / 100; // Convert to decimal (e.g., 100 -> 1.0, 120 -> 1.2)

        // ✅ Get paper size from request
        $paperSize = $request->input('paper', 'Letter'); // Default Letter

        // Map paper sizes to TCPDF format
        $paperFormats = [
            'A4' => 'A4',
            'Letter' => 'LETTER',
            'Legal' => 'LEGAL'
        ];
        $paperFormat = $paperFormats[$paperSize] ?? 'LETTER';

        // ✅ Initialize PDF with selected paper size
        $pdf = new TCPDF('P', 'mm', $paperFormat, true, 'UTF-8', false);
        $pdf->SetCreator('DOST-CAR Accreditation System');
        $pdf->SetAuthor('DOST-CAR');
        $pdf->SetTitle('Accreditation Form');
        $pdf->SetMargins(15, 15, 15);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $speakerName = optional($accredit->speaker)->given_name . ' ' . optional($accredit->speaker)->last_name;
        $expertise   = $accredit->speaker && $accredit->speaker->expertises
            ? $accredit->speaker->expertises->pluck('expertis')->implode(', ')
            : 'N/A';

        // ✅ Apply scaled base font before writing HTML
        $baseFontSize = 12;
        $pdf->SetFont('times', '', $baseFontSize * $fontScale);

        $html = '
        <h4 style="text-align:center; font-size:' . (14 * $fontScale) . 'pt;">
            CRITERIA FOR ACCREDITATION OF TRAINERS/<br>
            RESOURCE SPEAKERS/SUBJECT MATTER<br>SPECIALISTS
        </h4>
        <br>

        <table width="100%" cellpadding="2" cellspacing="0" style="font-size:' . (11 * $fontScale) . 'pt;">
        <tr>
            <td width="28%"><strong>Name of Applicant:</strong></td>
            <td width="72%" style="border-bottom:1px solid #000;">' . htmlspecialchars($speakerName, ENT_QUOTES, "UTF-8") . '&nbsp;</td>
        </tr>
        <tr>
            <td width="28%"><strong>Field of Expertise:</strong></td>
            <td width="72%" style="border-bottom:1px solid #000;">' . htmlspecialchars($expertise, ENT_QUOTES, "UTF-8") . '&nbsp;</td>
        </tr>
        </table>
        <br><br>

        <table cellpadding="4" cellspacing="0" width="100%" style="font-size:' . (11 * $fontScale) . 'pt;">
            <tr>
                <td width="80%"><strong>1.0 Relevant Educational Qualifications – 30 points</strong></td>
                <td width="20%" align="right">' . number_format($accredit->avg_education, 2) . '</td>
            </tr>
            <tr><td style="padding-left:20px;">Technical Vocational Course</td><td style="padding-right:100px;">15</td></tr>
            <tr><td style="padding-left:20px;">Bachelor\'s Degree</td><td style="padding-right:100px;">20</td></tr>
            <tr><td style="padding-left:20px;">Master\'s Degree</td><td style="padding-right:100px;">25</td></tr>
            <tr><td style="padding-left:20px;">Doctorate Degree</td><td style="padding-right:100px;">30</td></tr>
            <tr>
                <td><br><strong>2.0 Relevant Work Experience – 30 points</strong></td>
                <td align="right"><br>' . number_format($accredit->avg_work, 2) . '</td>
            </tr>
            <tr><td style="padding-left:20px;">At least two (2) years</td><td style="padding-right:100px;">20</td></tr>
            <tr><td style="padding-left:20px;">Three (3) to five (5) years</td><td style="padding-right:100px;">25</td></tr>
            <tr><td style="padding-left:20px;">More than five (5) years</td><td style="padding-right:100px;">30</td></tr>
            <tr>
                <td><br><strong>3.0 Relevant Trainings/Seminars Attended – 20 points</strong></td>
                <td align="right"><br>' . number_format($accredit->avg_seminar, 2) . '</td>
            </tr>
            <tr><td style="padding-left:20px;">40 – 80 hours</td><td style="padding-right:100px;">10</td></tr>
            <tr><td style="padding-left:20px;">81 – 120 hours</td><td style="padding-right:100px;">15</td></tr>
            <tr><td style="padding-left:20px;">121 hours and above</td><td style="padding-right:100px;">20</td></tr>
            <tr>
                <td><br><strong>4.0 Experience As Trainer/ Resource Person – 10 points</strong></td>
                <td align="right"><br>' . number_format($accredit->avg_experience, 2) . '</td>
            </tr>
            <tr><td style="padding-left:20px;">Conducted training lectures ≥ 30 hours</td><td style="padding-right:100px;">10</td></tr>
            <tr><td style="padding-left:20px;">Recognized as trainer by institution</td><td style="padding-right:100px;">5</td></tr>
            <tr>
                <td><br><strong>5.0 Relevant Technical Merits – 10 points</strong></td>
                <td align="right"><br>' . number_format($accredit->avg_award, 2) . '</td>
            </tr>
            <tr><td style="padding-left:20px;">National Recognitions/ Awards/ Publications</td><td style="padding-right:100px;">10</td></tr>
            <tr><td style="padding-left:20px;">Local Recognitions/ Awards/ Publications</td><td style="padding-right:100px;">5</td></tr>
        </table>
        <br>
        <table cellpadding="6" cellspacing="0" width="100%" style="font-size:' . (11 * $fontScale) . 'pt;">
            <tr>
                <td width="80%" align="right"><strong>TOTAL</strong></td>
                <td width="10%" align="center">100</td>
                <td width="10%" align="center">' . number_format($accredit->avg_total, 2) . '</td>
            </tr>
        </table>

        <p style="font-size:' . (10 * $fontScale) . 'pt;"><em>Note: Standard Passing Score is 75 points.</em></p>

        <br><br>
        <table border="1" cellpadding="6" cellspacing="0" width="100%" style="font-size:' . (11 * $fontScale) . 'pt;">
            <tr>
                <td width="50%" align="center">
                    Signature<br><br>
                    Printed Name: <u>ANGEL L. MAGUEN</u><br>
                    Designation: Chairperson<br>Date:
                </td>
                <td width="50%" align="center">
                    Signature<br><br>
                    Printed Name: <u>PEPITA S. PICPICAN</u><br>
                    Designation: Member<br>Date:
                </td>
            </tr>
            <tr>
                <td width="50%" align="center">
                    Signature<br><br>
                    Printed Name: <u>MARIA ROWENA C. MADARANG</u><br>
                    Designation: Member<br>Date:
                </td>
                <td width="50%" align="center">
                    Signature<br><br>
                    Printed Name: <u>ALICIA A. BALACUA</u><br>
                    Designation: Member<br>Date:
                </td>
            </tr>
        </table>

        <br><br>
        <table border="1" cellpadding="6" cellspacing="0" width="100%" style="font-size:' . (11 * $fontScale) . 'pt;">
            <tr>
                <td width="100%" align="center">
                    Signature<br><br>
                    Printed Name: <u>NANCY A. BANTOG</u><br>
                    Designation: Regional Director<br>Date:
                </td>
            </tr>
        </table>
        ';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('accreditation_form_' . $speakerName . '.pdf', 'I');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AccreditationAverage $accreditationAverage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccreditationAverage $accreditationAverage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccreditationAverage $accreditationAverage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccreditationAverage $accreditationAverage)
    {
        //
    }

}
