<?php

namespace App\Helpers;

use TCPDF;

class PdfHelper extends TCPDF
{
    public function Header()
    {
        // Set header colors and styling
        $this->SetFillColor(102, 126, 234);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('helvetica', 'B', 16);

        // Header background
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        // Logo/Icon (optional - you can add an image here)
        // $this->Image('path/to/logo.png', 15, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Title
        $this->SetXY(15, 8);
        $this->Cell(0, 10, 'Zoom Request Report', 0, false, 'L', 0, '', 0, false, 'M', 'M');

        // Date
        $this->SetFont('helvetica', '', 10);
        $this->SetXY(15, 18);
        $this->Cell(0, 5, 'Generated: ' . date('F d, Y h:i A'), 0, false, 'L', 0, '', 0, false, 'M', 'M');

        // Reset text color
        $this->SetTextColor(0, 0, 0);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->SetTextColor(100, 100, 100);

        // Line
        $this->SetDrawColor(200, 200, 200);
        $this->Line(15, $this->GetY(), $this->getPageWidth() - 15, $this->GetY());

        $this->SetY(-12);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        // ICT Management System
        $this->SetY(-12);
        $this->Cell(0, 10, 'ICT Management System', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}
