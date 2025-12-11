<?php

namespace App\Exports;

use App\Models\Rstbl;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResourceSpeakersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $status;

    public function __construct($status = 'all')
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = Rstbl::with(['expertises', 'office']);

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
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
        ];
    }

    public function map($speaker): array
    {
        return [
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
            optional($speaker->office)->office_name,
            $speaker->home_address,
            $speaker->home_municipality,
            $speaker->home_province,
            $speaker->home_cell_no,
            $speaker->status ?? 'Pending',
            $speaker->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
