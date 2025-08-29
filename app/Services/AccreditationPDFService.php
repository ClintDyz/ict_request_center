<?php

namespace App\Services;

use App\Models\RequestResourceSpeaker;
use App\Models\Rstbl;
use App\Models\Accreditation;
use Illuminate\Http\Request;


class AccreditationPDF implements AccreditationPDFServiceInterface

{

public function generatePDF(RequestResourceSpeaker $trainer)
    {


     $trainer -> load (['speaker', 'accreditation']);
     
        if (!$trainer) {
            return redirect()->back()->with('error', 'Trainer not found');
        }

        // Create PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Laravel Application');
        $pdf->SetAuthor('Your Organization');
        $pdf->SetTitle('Criteria for Accreditation');
        $pdf->SetSubject('Accreditation Form');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 25);

        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'CRITERIA FOR ACCREDITATION OF TRAINERS/', 0, 1, 'C');
        $pdf->Cell(0, 8, 'RESOURCE SPEAKERS/SUBJECT MATTER', 0, 1, 'C');
        $pdf->Cell(0, 8, 'SPECIALISTS', 0, 1, 'C');
        $pdf->Ln(8);

        // Applicant Info
        $pdf->SetFont('helvetica', '', 10);
        $applicantName = $trainer->speaker ? trim(($trainer->speaker->given_name ?? '') . ' ' . ($trainer->speaker->last_name ?? '')) : '';
        $expertise = $trainer->speaker->expertise ?? '';

        $pdf->Cell(35, 6, 'Name of Applicant:', 0, 0, 'L');
        $pdf->Cell(0, 6, strtoupper($applicantName), 0, 1, 'L');

        $pdf->Cell(35, 6, 'Field of Expertise:', 0, 0, 'L');
        $pdf->MultiCell(0, 6, strtoupper($expertise), 0, 'L');
        $pdf->Ln(8);

        // Criteria Sections
        $pdf->SetFont('helvetica', '', 9);

        $this->addCriteriaSection($pdf, [
            'title' => '1.0    Relevant Educational Qualifications – 30 points',
            'max_points' => '30.00',
            'actual_points' => number_format($trainer->education ?? 0, 2),
            'items' => [
                ['Technical Vocational Course', '15'],
                ['Bachelor\'s Degree', '20'],
                ['Master\'s Degree', '25'],
                ['Doctorate Degree', '30']
            ]
        ]);


        $this->addCriteriaSection($pdf, [
            'title' => '2.0    Relevant Work Experience – 30 points',
            'subtitle' => 'As Industry Practitioner Technical Specialist',
            'max_points' => '30.00',
            'actual_points' => number_format($trainer->work ?? 0, 2),
            'items' => [
                ['At least two (2) years', '20'],
                ['Three (3) to five (5) years', '25'],
                ['More than five (5) years', '30']
            ]
        ]);

        $this->addCriteriaSection($pdf, [
            'title' => '3.0    Relevant Trainings/Seminars Attended – 20 points',
            'max_points' => '20.00',
            'actual_points' => number_format($trainer->seminar ?? 0, 2),
            'items' => [
                ['40 – 80 hours', '10'],
                ['81 – 120 hours', '15'],
                ['121 hours and above', '20']
            ]
        ]);

        $this->addCriteriaSection($pdf, [
            'title' => '4.0    Experience As Trainer/ Resource Person – 10 points',
            'max_points' => '10.00',
            'actual_points' => number_format($trainer->experience ?? 0, 2),
            'items' => [
                ['Conducted technology training lecture for at least 30', '10'],
                ['hours or recognized as trainer by relevant institutions', ''],
                ['on specific subject matter', '5']
            ]
        ]);

        $this->addCriteriaSection($pdf, [
            'title' => '5.0    Relevant Technical Merits – 10 points',
            'max_points' => '10.00',
            'actual_points' => number_format($trainer->award ?? 0, 2),
            'items' => [
                ['National Recognitions/ Awards/ Publications', '10'],
                ['Local Recognitions/ Awards/ Publications', '5']
            ]
        ]);

        // Total
        $pdf->SetFont('helvetica', 'B', 10);
        $totalScore = $trainer->total ?? 0;
        $pdf->Cell(60, 8, 'TOTAL', 0, 0, 'L');
        $pdf->Cell(80, 8, '100 points', 0, 0, 'R');
        $pdf->Cell(40, 8, number_format($totalScore, 2), 0, 1, 'R');

        // Note
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(0, 5, '    Note: Standard Passing Score is 75 points.', 0, 1, 'L');
        $pdf->Ln(5);

        // Signature section
        $this->addSignatureSection($pdf);

        $filename = 'accreditation_form_' . ($trainer->id ?? 'unknown') . '.pdf';
        return $pdf->Output($filename, 'I'); // 'I' = inline view
    }

    private function addCriteriaSection($pdf, $criteria)
    {
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(140, 6, $criteria['title'], 0, 0, 'L');
        $pdf->Cell(40, 6, $criteria['actual_points'], 0, 1, 'R');

        if (!empty($criteria['subtitle'])) {
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(180, 5, '    ' . $criteria['subtitle'], 0, 1, 'L');
        }

        $pdf->SetFont('helvetica', '', 8);
        foreach ($criteria['items'] as $item) {
            if (!empty($item[0])) {
                $pdf->Cell(140, 5, '        ' . $item[0], 0, 0, 'L');
                $pdf->Cell(40, 5, $item[1], 0, 1, 'R');
            }
        }

        $pdf->Ln(3);
    }

    private function addSignatureSection($pdf)
    {
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Ln(5);

        // First row: Rated by
        $pdf->Cell(60, 6, '', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Rated by:', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Rated by:', 1, 1, 'C');

        $pdf->Cell(60, 6, 'Signature', 1, 0, 'L');
        $pdf->Cell(60, 6, '', 1, 0, 'C');
        $pdf->Cell(60, 6, '', 1, 1, 'C');

        $pdf->Cell(60, 6, 'Printed Name', 1, 0, 'L');
        $pdf->Cell(60, 6, 'ANGEL L. MAGUEN', 1, 0, 'C');
        $pdf->Cell(60, 6, 'PEPITA S. PICPICAN', 1, 1, 'C');

        $pdf->Cell(60, 6, 'Designation', 1, 0, 'L');
        $pdf->Cell(60, 6, 'Chairperson', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Member', 1, 1, 'C');

        $pdf->Cell(60, 6, 'Date', 1, 0, 'L');
        $pdf->Cell(60, 6, '', 1, 0, 'C');
        $pdf->Cell(60, 6, '', 1, 1, 'C');

        // Second: Noted by
        $pdf->Cell(60, 6, '', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Noted by:', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Noted by:', 1, 1, 'C');

        $pdf->Cell(60, 6, 'Signature', 1, 0, 'L');
        $pdf->Cell(60, 6, '', 1, 0, 'C');
        $pdf->Cell(60, 6, '', 1, 1, 'C');

        $pdf->Cell(60, 6, 'Printed Name', 1, 0, 'L');
        $pdf->Cell(60, 6, 'MARIA ROWENA C. MADARANG', 1, 0, 'C');
        $pdf->Cell(60, 6, 'ALICIA A. BALACUA', 1, 1, 'C');

        $pdf->Cell(60, 6, 'Designation', 1, 0, 'L');
        $pdf->Cell(60, 6, 'Member', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Member', 1, 1, 'C');

        $pdf->Cell(60, 6, 'Date', 1, 0, 'L');
        $pdf->Cell(60, 6, '', 1, 0, 'C');
        $pdf->Cell(60, 6, '', 1, 1, 'C');

        // Approved by
        $pdf->Cell(120, 6, '', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Approved by:', 1, 1, 'C');

        $pdf->Cell(120, 6, 'Signature', 1, 0, 'L');
        $pdf->Cell(60, 6, '', 1, 1, 'C');

        $pdf->Cell(120, 6, 'Printed Name', 1, 0, 'L');
        $pdf->Cell(60, 6, 'NANCY A. BANTOG', 1, 1, 'C');

        $pdf->Cell(120, 6, 'Designation', 1, 0, 'L');
        $pdf->Cell(60, 6, 'Regional Director', 1, 1, 'C');

        $pdf->Cell(120, 6, 'Date', 1, 0, 'L');
        $pdf->Cell(60, 6, '', 1, 1, 'C');
    }
}

// Alternative: If you want to create this as a separate service class
class AccreditationPDFService
{
    public function generate($trainer)
    {
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Laravel Application');
        $pdf->SetTitle('Accreditation Form');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set margins
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 25);

        // Add a page
        $pdf->AddPage();

        // Build the PDF content (same as above)
        $this->buildPDFContent($pdf, $trainer);

        return $pdf;
    }

    private function buildPDFContent($pdf, $trainer)
    {
        // Title
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'CRITERIA FOR ACCREDITATION OF TRAINERS/', 0, 1, 'C');
        $pdf->Cell(0, 8, 'RESOURCE SPEAKERS/SUBJECT MATTER', 0, 1, 'C');
        $pdf->Cell(0, 8, 'SPECIALISTS', 0, 1, 'C');
        $pdf->Ln(8);

        // Applicant Information
        $pdf->SetFont('helvetica', '', 10);
        $applicantName = trim(($trainer->speaker->given_name ?? '') . ' ' . ($trainer->speaker->last_name ?? ''));
        $pdf->Cell(35, 6, 'Name of Applicant:', 0, 0, 'L');
        $pdf->Cell(0, 6, strtoupper($applicantName), 0, 1, 'L');
        $pdf->Cell(35, 6, 'Field of Expertise:', 0, 0, 'L');
        $pdf->MultiCell(0, 6, strtoupper($trainer->speaker->expertise ?? ''), 0, 'L');
        $pdf->Ln(8);

        // Add all sections here...
        // (Use the same logic as in the controller method)
    }
}
