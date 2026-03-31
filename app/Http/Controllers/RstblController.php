<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rstbl; // Model for Speaker
use App\Models\RsEducational; // Model for education
use App\Models\RsWorkExperience; // Model for work experience
use App\Models\RsTraining; // Model for training
use App\Models\RsExperienceTrainer; // Model for experience as trainer
use App\Models\RsReferencesTraining; // Model for references
use App\Models\RsPublication; // Model for publications
use App\Models\Office; // Model for office details
use App\Models\Expertis; // Model for Expertis details
use Illuminate\Support\Facades\Auth;
use TCPDF;
use Illuminate\Support\Facades\Log;
use App\Mail\ApplicationSubmittedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class RstblController extends Controller
{
public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search', '');

    $query = Rstbl::with('expertises')
                  ->where('status', 'Pending');

    // Add search functionality
    if (!empty($search)) {
        $query->where(function($q) use ($search) {
            $q->where('last_name', 'LIKE', "%{$search}%")
              ->orWhere('given_name', 'LIKE', "%{$search}%")
              ->orWhere('middle_name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('home_address', 'LIKE', "%{$search}%")
              ->orWhere('gender', 'LIKE', "%{$search}%");
        });
    }

    $speakers = $query->orderBy('created_at', 'desc')
                      ->paginate($perPage);

    // Append search and per_page to pagination links
    $speakers->appends([
        'search' => $search,
        'per_page' => $perPage
    ]);

    return view('resource_speaker.index', compact('speakers'));
}
public function show($id)
{
    $speaker = Rstbl::with([
        'office',
        'expertises',
        'educationalBackground',
        'workExperiences',
        'experienceTrainer',
        'trainings',
        'publications',
        'referencesTrainings',
    ])->findOrFail($id);

    return view('resource_speaker.view', compact('speaker'));
}

    public function create()
    {
        // dd($request->all());

        return view('resource_speaker.create');
    }

public function store(Request $request)
{
    if (Rstbl::where('email', $request->email)->exists()) {
        return redirect()->back()->with('error', 'The email address is already in use.');
    }

    $imagePath = null;
    if ($request->hasFile('img')) {
        $image = $request->file('img');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('uploads/images');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $image->move($destinationPath, $imageName);
        $imagePath = 'uploads/images/' . $imageName;
    }

    $rstbl = null;

    DB::transaction(function () use ($request, $imagePath, &$rstbl) {

        $rstbl = Rstbl::create([
            'last_name'          => $request->last_name,
            'given_name'         => $request->given_name,
            'middle_name'        => $request->middle_name,
            'ext_name'           => $request->ext_name,
            'date_of_birth'      => $request->date_of_birth,
            'place_of_birth'     => $request->place_of_birth,
            'age'                => $request->age,
            'gender'             => $request->gender,
            'email'              => $request->email,
            'expertise'          => $request->expertise,
            'home_address'       => $request->home_address,
            'home_building_no'   => $request->home_building_no,
            'home_barangay'      => $request->home_barangay,
            'home_municipality'  => $request->home_municipality,
            'home_province'      => $request->home_province,
            'home_zip_code'      => $request->home_zip_code,
            'home_tel_no'        => $request->home_tel_no,
            'home_cell_no'       => $request->home_cell_no,
            'home_fax_no'        => $request->home_fax_no,
            'img'                => $imagePath,
            'created_by'         => Auth::check() ? Auth::id() : null,
        ]);

        // Office — create blade uses barangay, municipality, province, zip_code (no off_ prefix)
        $rstbl->office()->create([
            'office_organization' => $request->office_organization,
            'position'            => $request->off_position,
            'address'             => $request->off_address,
            'building_no'         => $request->off_building_no,
            'barangay'            => $request->barangay,
            'municipality'        => $request->municipality,
            'province'            => $request->province,
            'zip_code'            => $request->zip_code,
            'tel_no'              => $request->off_tel_no,
            'cell_no'             => $request->off_cell_no,
            'fax_no'              => $request->off_fax_no,
        ]);

        // Expertises
        if (!empty($request->expertis) && is_array($request->expertis)) {
            foreach ($request->expertis as $expertis) {
                if (!empty($expertis)) {
                    $rstbl->expertises()->create(['expertis' => $expertis]);
                }
            }
        }

        // Educational Background
        if (!empty($request->level) && is_array($request->level)) {
            foreach ($request->level as $index => $level) {
                if (!empty($level)) {
                    $rstbl->educationalBackground()->create([
                        'level'          => $level,
                        'school'         => $request->school[$index] ?? null,
                        'from_year'      => $request->from_year[$index] ?? null,
                        'to_year'        => $request->to_year[$index] ?? null,
                        'year_graduated' => $request->year_graduated[$index] ?? null,
                        'awards'         => $request->awards[$index] ?? null,
                    ]);
                }
            }
        }

        // Work Experience
        if (!empty($request->work_name_company) && is_array($request->work_name_company)) {
            foreach ($request->work_name_company as $key => $company) {
                if (!empty($company)) {
                    $rstbl->workExperiences()->create([
                        'name_company' => $company,
                        'date_started' => $request->work_date_started[$key] ?? null,
                        'date_ended'   => $request->work_date_ended[$key] ?? null,
                        'position'     => $request->work_position[$key] ?? null,
                        'address'      => $request->work_address[$key] ?? null,
                        'division'     => $request->work_division[$key] ?? null,
                    ]);
                }
            }
        }

        // Trainings / Seminars Attended (section 6) — uses rst_title[] in create blade
        if (!empty($request->rst_title) && is_array($request->rst_title)) {
            foreach ($request->rst_title as $key => $title) {
                if (!empty($title)) {
                    $rstbl->experienceTrainer()->create([
                        'rst_title'    => $title,
                        'rst_date'     => $request->rst_date[$key] ?? null,
                        'rst_venue'    => $request->rst_venue[$key] ?? null,
                        'rst_no_hours' => $request->rst_no_hours[$key] ?? null,
                    ]);
                }
            }
        }

        // Experience as Trainer (section 7) — uses rt_title[] in create blade
        if (!empty($request->rt_title) && is_array($request->rt_title)) {
            foreach ($request->rt_title as $index => $rt_title) {
                if (!empty($rt_title)) {
                    $rstbl->trainings()->create([
                        'rt_title'    => $rt_title,
                        'rt_date'     => $request->rt_date[$index] ?? null,
                        'rt_venue'    => $request->rt_venue[$index] ?? null,
                        'rt_no_hours' => $request->rt_no_hours[$index] ?? null,
                    ]);
                }
            }
        }

        // Publications
        if (!empty($request->publication_title) && is_array($request->publication_title)) {
            foreach ($request->publication_title as $key => $title) {
                if (!empty($title)) {
                    $rstbl->publications()->create([
                        'p_title'  => $title,
                        'p_nature' => $request->p_nature[$key] ?? null,
                        'p_date'   => $request->p_date[$key] ?? null,
                        'p_venue'  => $request->p_venue[$key] ?? null,
                    ]);
                }
            }
        }

        // References
        if (!empty($request->name_agency) && is_array($request->name_agency)) {
            foreach ($request->name_agency as $index => $agency) {
                if (!empty($agency)) {
                    $rstbl->referencesTrainings()->create([
                        'name_agency'    => $agency,
                        'address'        => $request->ref_address[$index] ?? null,
                        'contact_person' => $request->contact_person[$index] ?? null,
                        'position'       => $request->ref_position[$index] ?? null,
                        'tel_no'         => $request->ref_tel_no[$index] ?? null,
                        'cell_no'        => $request->ref_cell_no[$index] ?? null,
                        'fax_no'         => $request->ref_fax_no[$index] ?? null,
                    ]);
                }
            }
        }

    });

    $adminEmails = \App\Models\User::where('emp_type', 0)
        ->whereNotNull('email')
        ->where('email', '!=', '')
        ->pluck('email')
        ->toArray();

    if (!empty($adminEmails)) {
        foreach ($adminEmails as $email) {
            Mail::to($email)->send(new ApplicationSubmittedMail($rstbl));
        }
    }

    if (!Auth::check()) {
        return redirect()->route('resource_speaker.create')
            ->with('success', 'Thank you. Your application has been successfully submitted for processing.');
    }

    return redirect()->route('resource_speaker.index')->with('create', 'med_form');
}

public function edit($id)
{
    $speaker = Rstbl::with([
        'office',
        'expertises',
        'educationalBackground',
        'workExperiences',
        'experienceTrainer',
        'trainings',
        'publications',
        'referencesTrainings',
    ])->findOrFail($id);

    return view('resource_speaker.update', compact('speaker'));
}

public function update(Request $request, $id)
{
    try {
        $existingRecord = Rstbl::where('email', $request->email)->where('id', '!=', $id)->first();
        if ($existingRecord) {
            return redirect()->back()->with('error', 'The email address is already in use.');
        }

        $rstbl = Rstbl::findOrFail($id);

        DB::transaction(function () use ($request, $id, $rstbl) {

            // Handle image upload
            $imagePath = $rstbl->img;
            if (request()->hasFile('img')) {
                $image = request()->file('img');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/images');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $image->move($destinationPath, $imageName);
                $imagePath = 'uploads/images/' . $imageName;
            }

            $rstbl->update([
                'last_name'         => $request->last_name,
                'given_name'        => $request->given_name,
                'middle_name'       => $request->middle_name,
                'ext_name'          => $request->ext_name,
                'date_of_birth'     => $request->date_of_birth,
                'place_of_birth'    => $request->place_of_birth,
                'age'               => $request->age,
                'email'             => $request->email,
                'expertise'         => $request->expertise,
                'home_address'      => $request->home_address,
                'home_building_no'  => $request->home_building_no,
                'home_barangay'     => $request->home_barangay,
                'home_municipality' => $request->home_municipality,
                'home_province'     => $request->home_province,
                'home_zip_code'     => $request->home_zip_code,
                'home_tel_no'       => $request->home_tel_no,
                'home_cell_no'      => $request->home_cell_no,
                'home_fax_no'       => $request->home_fax_no,
                'img'               => $imagePath,
                'updated_by'        => auth()->id(),
            ]);

            // Office — update blade uses off_ prefix for barangay/municipality/province/zip_code
            $rstbl->office()->updateOrCreate(
                ['rs_id' => $rstbl->id],
                [
                    'office_organization' => $request->office_organization,
                    'position'            => $request->off_position,
                    'address'             => $request->off_address,
                    'building_no'         => $request->off_building_no,
                    'barangay'            => $request->off_barangay,
                    'municipality'        => $request->off_municipality,
                    'province'            => $request->off_province,
                    'zip_code'            => $request->off_zip_code,
                    'tel_no'              => $request->off_tel_no,
                    'cell_no'             => $request->off_cell_no,
                    'fax_no'              => $request->off_fax_no,
                ]
            );

            // Expertises
            $rstbl->expertises()->delete();
            if ($request->has('expertis')) {
                foreach ($request->expertis as $expertise) {
                    if (!empty($expertise)) {
                        $rstbl->expertises()->create(['expertis' => $expertise]);
                    }
                }
            }

            // Educational Background
            $rstbl->educationalBackground()->delete();
            $levels        = $request->input('level', []);
            $schools       = $request->input('school', []);
            $fromYears     = $request->input('from_year', []);
            $toYears       = $request->input('to_year', []);
            $yearGraduated = $request->input('year_graduated', []);
            $awards        = $request->input('awards', []);
            $count = max(count($levels), count($schools));
            for ($i = 0; $i < $count; $i++) {
                if (!empty($levels[$i]) || !empty($schools[$i])) {
                    $rstbl->educationalBackground()->create([
                        'level'          => $levels[$i] ?? null,
                        'school'         => $schools[$i] ?? null,
                        'from_year'      => $fromYears[$i] ?? null,
                        'to_year'        => $toYears[$i] ?? null,
                        'year_graduated' => $yearGraduated[$i] ?? null,
                        'awards'         => $awards[$i] ?? null,
                    ]);
                }
            }

            // Work Experience
            $rstbl->workExperiences()->delete();
            $workNames       = $request->input('work_name_company', []);
            $workPositions   = $request->input('work_position', []);
            $workDivisions   = $request->input('work_division', []);
            $workDateStarted = $request->input('work_date_started', []);
            $workDateEnded   = $request->input('work_date_ended', []);
            $workAddresses   = $request->input('work_address', []);
            $workCount = max(count($workNames), count($workPositions));
            for ($i = 0; $i < $workCount; $i++) {
                if (!empty($workNames[$i]) || !empty($workPositions[$i])) {
                    $rstbl->workExperiences()->create([
                        'name_company' => $workNames[$i] ?? null,
                        'position'     => $workPositions[$i] ?? null,
                        'division'     => $workDivisions[$i] ?? null,
                        'date_started' => $workDateStarted[$i] ?? null,
                        'date_ended'   => $workDateEnded[$i] ?? null,
                        'address'      => $workAddresses[$i] ?? null,
                    ]);
                }
            }

            // Trainings / Seminars Attended (section 6) — update blade uses rt_title[]
            $rstbl->trainings()->delete();
            if ($request->has('rt_title')) {
                foreach ($request->rt_title as $index => $rt_title) {
                    if (!empty($rt_title)) {
                        $rstbl->trainings()->create([
                            'rt_title'    => $rt_title,
                            'rt_date'     => $request->rt_date[$index] ?? null,
                            'rt_venue'    => $request->rt_venue[$index] ?? null,
                            'rt_no_hours' => $request->rt_no_hours[$index] ?? null,
                        ]);
                    }
                }
            }

            // Experience as Trainer (section 7) — update blade uses rst_title[]
            $rstbl->experienceTrainer()->delete();
            if ($request->has('rst_title')) {
                foreach ($request->rst_title as $key => $title) {
                    if (!empty($title)) {
                        $rstbl->experienceTrainer()->create([
                            'rst_title'    => $title,
                            'rst_date'     => $request->rst_date[$key] ?? null,
                            'rst_venue'    => $request->rst_venue[$key] ?? null,
                            'rst_no_hours' => $request->rst_no_hours[$key] ?? null,
                        ]);
                    }
                }
            }

            // References
            $rstbl->referencesTrainings()->delete();
            $refAgencies  = $request->input('name_agency', []);
            $refAddresses = $request->input('ref_address', []);
            $refContacts  = $request->input('contact_person', []);
            $refPositions = $request->input('ref_position', []);
            $refTelNos    = $request->input('ref_tel_no', []);
            $refCellNos   = $request->input('ref_cell_no', []);
            $refFaxNos    = $request->input('ref_fax_no', []);
            $refCount = max(count($refAgencies), count($refContacts));
            for ($i = 0; $i < $refCount; $i++) {
                if (!empty($refAgencies[$i])) {
                    $rstbl->referencesTrainings()->create([
                        'name_agency'    => $refAgencies[$i] ?? null,
                        'address'        => $refAddresses[$i] ?? null,
                        'contact_person' => $refContacts[$i] ?? null,
                        'position'       => $refPositions[$i] ?? null,
                        'tel_no'         => $refTelNos[$i] ?? null,
                        'cell_no'        => $refCellNos[$i] ?? null,
                        'fax_no'         => $refFaxNos[$i] ?? null,
                    ]);
                }
            }

            // Publications
            $rstbl->publications()->delete();
            $pubTitles  = $request->input('publication_title', []);
            $pubNatures = $request->input('p_nature', []);
            $pubDates   = $request->input('p_date', []);
            $pubVenues  = $request->input('p_venue', []);
            $pubCount = max(count($pubTitles), count($pubNatures));
            for ($i = 0; $i < $pubCount; $i++) {
                if (!empty($pubTitles[$i])) {
                    $rstbl->publications()->create([
                        'p_title'  => $pubTitles[$i] ?? null,
                        'p_nature' => $pubNatures[$i] ?? null,
                        'p_date'   => $pubDates[$i] ?? null,
                        'p_venue'  => $pubVenues[$i] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('resource_speaker.index')->with('edit', 'med_form');

    } catch (\Exception $e) {
        \Log::error('Update failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update: ' . $e->getMessage());
    }
}
public function printPDF($id)
{
    $scale = floatval(request()->get('scale', 1));

    try {
        $speaker = Rstbl::with([
            'office',
            'expertises',
            'workExperiences',
            'experienceTrainer',
            'trainings',
            'publications',
            'referencesTrainings'
        ])->findOrFail($id);

        $pdf = new class extends TCPDF {
            public function Header()
            {
                $image_file = public_path('img/Dostcar.jpg');
                if (file_exists($image_file)) {
                    $this->Image($image_file, 15, 10, 20);
                }
                $this->SetFont('helvetica', 'B', 10);
                $this->SetXY(40, 10);
                $this->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
                $this->SetXY(40, 15);
                $this->Cell(0, 5, 'Department of Science and Technology', 0, 1, 'C');
                $this->SetXY(40, 20);
                $this->Cell(0, 5, 'Cordillera Administrative Region', 0, 1, 'C');
                $this->SetFont('helvetica', '', 8);
                $this->SetXY(170, 10);
                $this->Cell(0, 5, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 1, 'R');
            }

            public function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('helvetica', 'I', 8);
                $this->Cell(0, 10, 'Generated on ' . date('Y-m-d H:i:s'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            }
        };

        $pdf->SetCreator('DOST Cordillera');
        $pdf->SetAuthor('Department of Science and Technology');
        $pdf->SetTitle('Application Form - ' . $speaker->last_name . ', ' . $speaker->given_name);
        $pdf->SetSubject('Technical Personnel/Trainer/Subject Matter Specialist');
        $pdf->SetHeaderData('', 0, '', '');
        $pdf->setHeaderFont(['helvetica', '', 10]);
        $pdf->setFooterFont(['helvetica', '', 8]);
        $pdf->SetDefaultMonospacedFont('courier');
        $pdf->SetMargins(15, 35, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);
        $pdf->setImageScale(1.25);
        $pdf->SetFontSize(10);
        $pdf->AddPage();

        $this->generateFormContent($pdf, $speaker, $scale);

        $filename = 'Application_Form_' . $speaker->last_name . '_' . $speaker->given_name . '_' . date('Y-m-d') . '.pdf';

        return response($pdf->Output($filename, 'S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');

    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
    }
}

private function generateFormContent($pdf, $speaker, $scale = 1)
{
    $pdf->SetFont('helvetica', 'B', 12 * $scale);
    $pdf->Cell(0, 10, 'APPLICATION FORM FOR THE ACCREDITATION OF', 0, 1, 'C');
    $pdf->Cell(0, 10, 'TECHNICAL PERSONNEL/TRAINER/SUBJECT MATTER SPECIALIST', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(15, 8, 'Name:', 0, 0, 'L');
    $pdf->Cell(45, 8, $speaker->last_name ?? '', 'B', 0, 'L');
    $pdf->Cell(45, 8, $speaker->given_name ?? '', 'B', 0, 'L');
    $pdf->Cell(40, 8, $speaker->middle_name ?? '', 'B', 0, 'L');
    $pdf->Cell(35, 8, $speaker->ext_name ?? '', 'B', 1, 'L');
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(15, 5, '', 0, 0, 'L');
    $pdf->Cell(45, 5, 'Last Name', 0, 0, 'L');
    $pdf->Cell(45, 5, 'Given Name', 0, 0, 'L');
    $pdf->Cell(40, 5, 'Middle Name', 0, 0, 'L');
    $pdf->Cell(35, 5, 'Name Ext\'n (e.g., III, Sr)', 0, 1, 'L');
    $pdf->Ln(5);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(27, 8, 'Date of Birth:', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(35, 8, $speaker->date_of_birth ?? '', 'B', 0, 'L');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(27, 8, 'Place of Birth:', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(35, 8, $speaker->place_of_birth ?? '', 'B', 0, 'L');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(15, 8, 'Age:', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(35, 8, $speaker->age ?? '', 'B', 1, 'L');
    $pdf->Ln(3);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(40, 8, 'Office/Organization:', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(140, 8, $speaker->office->office_organization ?? 'N/A', 'B', 1, 'L');

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(20, 8, 'Position:', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(160, 8, $speaker->office->position ?? 'N/A', 'B', 1, 'L');
    $pdf->Ln(3);

    // Office Address — total usable width per row = 175mm (210 - 15 left - 20 indent)
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 8, 'Office Address:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);

    $pdf->SetX(20);
    $pdf->Cell(25, 8, 'Building No.:', 0, 0, 'L');
    $pdf->Cell(55, 8, $speaker->office->building_no ?? '', 'B', 0, 'L');
    $pdf->Cell(30, 8, 'Street/Barangay:', 0, 0, 'L');
    $pdf->Cell(65, 8, $speaker->office->barangay ?? '', 'B', 1, 'L');

    $pdf->SetX(20);
    $pdf->Cell(30, 8, 'Municipality/City:', 0, 0, 'L');
    $pdf->Cell(55, 8, $speaker->office->municipality ?? '', 'B', 0, 'L');
    $pdf->Cell(20, 8, 'Province:', 0, 0, 'L');
    $pdf->Cell(70, 8, $speaker->office->province ?? '', 'B', 1, 'L');

    $pdf->SetX(20);
    $pdf->Cell(20, 8, 'Zip Code:', 0, 0, 'L');
    $pdf->Cell(155, 8, $speaker->office->zip_code ?? '', 'B', 1, 'L');

    $pdf->SetX(20);
    $pdf->Cell(35, 8, 'Contact Number:', 0, 0, 'L');
    $pdf->Cell(15, 8, 'Tel. No.:', 0, 0, 'L');
    $pdf->Cell(40, 8, $speaker->office->tel_no ?? '', 'B', 0, 'L');
    $pdf->Cell(25, 8, 'Cellphone No.:', 0, 0, 'L');
    $pdf->Cell(60, 8, $speaker->office->cell_no ?? '', 'B', 1, 'L');

    $pdf->SetX(20);
    $pdf->Cell(35, 8, '', 0, 0, 'L');
    $pdf->Cell(15, 8, 'Fax No.:', 0, 0, 'L');
    $pdf->Cell(125, 8, $speaker->office->fax_no ?? '', 'B', 1, 'L');
    $pdf->Ln(3);

    // Home/Residence Address — same width rules
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 8, 'Home/Residence Address:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 10);

    $pdf->SetX(20);
    $pdf->Cell(25, 8, 'Building No.:', 0, 0, 'L');
    $pdf->Cell(55, 8, $speaker->home_building_no ?? '', 'B', 0, 'L');
    $pdf->Cell(30, 8, 'Street/Barangay:', 0, 0, 'L');
    $pdf->Cell(65, 8, $speaker->home_barangay ?? '', 'B', 1, 'L');

    $pdf->SetX(20);
    $pdf->Cell(30, 8, 'Municipality/City:', 0, 0, 'L');
    $pdf->Cell(55, 8, $speaker->home_municipality ?? '', 'B', 0, 'L');
    $pdf->Cell(20, 8, 'Province:', 0, 0, 'L');
    $pdf->Cell(70, 8, $speaker->home_province ?? '', 'B', 1, 'L');

    $pdf->SetX(20);
    $pdf->Cell(20, 8, 'Zip Code:', 0, 0, 'L');
    $pdf->Cell(155, 8, $speaker->home_zip_code ?? '', 'B', 1, 'L');

    $pdf->SetX(20);
    $pdf->Cell(35, 8, 'Contact Number:', 0, 0, 'L');
    $pdf->Cell(15, 8, 'Tel. No.:', 0, 0, 'L');
    $pdf->Cell(40, 8, $speaker->home_tel_no ?? '', 'B', 0, 'L');
    $pdf->Cell(25, 8, 'Cellphone No.:', 0, 0, 'L');
    $pdf->Cell(60, 8, $speaker->home_cell_no ?? '', 'B', 1, 'L');

    $pdf->SetX(20);
    $pdf->Cell(35, 8, '', 0, 0, 'L');
    $pdf->Cell(15, 8, 'Fax No.:', 0, 0, 'L');
    $pdf->Cell(125, 8, $speaker->home_fax_no ?? '', 'B', 1, 'L');
    $pdf->Ln(5);

    $this->generateExpertSection($pdf, $speaker, $scale);
    $this->generateEducationalTable($pdf, $speaker, $scale);
    $this->generateWorkExperienceSection($pdf, $speaker, $scale);
    $this->generateTrainingSection($pdf, $speaker, $scale);
    $this->generateExperienceTrainerSection($pdf, $speaker, $scale);
    $this->generatePublicationsSection($pdf, $speaker, $scale);
    $this->generateReferencesSection($pdf, $speaker, $scale);
}

private function generateExpertSection($pdf, $speaker, $scale = 1)
{
    $pdf->SetFont('helvetica', 'B', 10 * $scale);
    $pdf->Cell(70 * $scale, 8 * $scale, 'E-mail Address:', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10 * $scale);
    $pdf->MultiCell(100 * $scale, 8 * $scale, $speaker->email ?? '', 'B', 'L', false, 1);
    $pdf->Ln(5 * $scale);
}

private function generateEducationalTable($pdf, $speaker, $scale = 1)
{
    $pdf->SetFont('helvetica', 'B', 10 * $scale);
    $pdf->Cell(70 * $scale, 8 * $scale, 'Field/s of Specialization/Expertise:', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10 * $scale);
    $expertiseList = $speaker->expertises ? $speaker->expertises->pluck('expertis')->implode(', ') : 'N/A';
    $pdf->MultiCell(100 * $scale, 8 * $scale, $expertiseList, 'B', 'L', false, 1);
    $pdf->Ln(10 * $scale);

    $pdf->SetFont('helvetica', 'B', 10 * $scale);
    $pdf->Cell(0, 8 * $scale, 'Educational Background:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 8 * $scale);

    $columnWidths = [
        'level'          => 35 * $scale,
        'from_year'      => 25 * $scale,
        'to_year'        => 25 * $scale,
        'school'         => 50 * $scale,
        'year_graduated' => 25 * $scale,
        'awards'         => 25 * $scale,
    ];

    $pdf->Cell($columnWidths['level'],          8 * $scale, 'Level/Degree',     1, 0, 'C');
    $pdf->Cell($columnWidths['from_year'],       8 * $scale, 'From Year',        1, 0, 'C');
    $pdf->Cell($columnWidths['to_year'],         8 * $scale, 'To Year',          1, 0, 'C');
    $pdf->Cell($columnWidths['school'],          8 * $scale, 'School/Institution',1, 0, 'C');
    $pdf->Cell($columnWidths['year_graduated'],  8 * $scale, 'Year Graduated',   1, 0, 'C');
    $pdf->Cell($columnWidths['awards'],          8 * $scale, 'Awards',           1, 1, 'C');

    $educationalData = DB::table('rs_educational')->where('rs_id', $speaker->id)->get();

    foreach ($educationalData as $education) {
        $maxHeight = 8 * $scale;
        $cellHeights = [
            'level'          => $pdf->getStringHeight($columnWidths['level'],         $education->level ?? '',          true, true, 1),
            'from_year'      => $pdf->getStringHeight($columnWidths['from_year'],      $education->from_year ?? '',      true, true, 1),
            'to_year'        => $pdf->getStringHeight($columnWidths['to_year'],        $education->to_year ?? '',        true, true, 1),
            'school'         => $pdf->getStringHeight($columnWidths['school'],         $education->school ?? '',         true, true, 1),
            'year_graduated' => $pdf->getStringHeight($columnWidths['year_graduated'], $education->year_graduated ?? '', true, true, 1),
            'awards'         => $pdf->getStringHeight($columnWidths['awards'],         $education->awards ?? '',         true, true, 1),
        ];
        $maxHeight = max($maxHeight, ...array_values($cellHeights));

        if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
            $pdf->AddPage();
        }

        $pdf->MultiCell($columnWidths['level'],         $maxHeight, $education->level ?? '',          1, 'L', false, 0);
        $pdf->MultiCell($columnWidths['from_year'],      $maxHeight, $education->from_year ?? '',      1, 'C', false, 0);
        $pdf->MultiCell($columnWidths['to_year'],        $maxHeight, $education->to_year ?? '',        1, 'C', false, 0);
        $pdf->MultiCell($columnWidths['school'],         $maxHeight, $education->school ?? '',         1, 'L', false, 0);
        $pdf->MultiCell($columnWidths['year_graduated'], $maxHeight, $education->year_graduated ?? '', 1, 'C', false, 0);
        $pdf->MultiCell($columnWidths['awards'],         $maxHeight, $education->awards ?? '',         1, 'L', false, 1);
    }

    if (!$educationalData->isEmpty()) {
        $pdf->Ln(5 * $scale);
    }
}

private function generateWorkExperienceSection($pdf, $speaker, $scale = 1)
{
    $pdf->SetFont('helvetica', 'B', 10 * $scale);
    $pdf->Cell(0, 8 * $scale, 'Professional Work Experience/s: (use additional sheet if necessary)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 7 * $scale);

    $columnWidths = [
        'duration'     => 25 * $scale,
        'name_company' => 38 * $scale,
        'address'      => 38 * $scale,
        'division'     => 32 * $scale,
        'position'     => 37 * $scale,
    ];

    $startX = $pdf->GetX();
    $startY = $pdf->GetY();
    $headerHeight = 16 * $scale;

    $pdf->MultiCell($columnWidths['duration'],     $headerHeight, "Duration\nDate Started - Date Ended",            1, 'C', false, 0);
    $pdf->SetXY($startX + $columnWidths['duration'], $startY);

    $pdf->MultiCell($columnWidths['name_company'], $headerHeight, "Name of Institution/Company/\nBusiness/Firm",    1, 'C', false, 0);
    $pdf->SetXY($startX + $columnWidths['duration'] + $columnWidths['name_company'], $startY);

    $pdf->MultiCell($columnWidths['address'],      $headerHeight, "Address of Institution/Company/\nBusiness/Firm", 1, 'C', false, 0);
    $pdf->SetXY($startX + $columnWidths['duration'] + $columnWidths['name_company'] + $columnWidths['address'], $startY);

    $pdf->MultiCell($columnWidths['division'],     $headerHeight, "Division/\nSection/Unit",                       1, 'C', false, 0);
    $pdf->SetXY($startX + $columnWidths['duration'] + $columnWidths['name_company'] + $columnWidths['address'] + $columnWidths['division'], $startY);

    $pdf->MultiCell($columnWidths['position'],     $headerHeight, "Position",                                      1, 'C', false, 0);
    $pdf->SetXY($startX, $startY + $headerHeight);

    $workData = $speaker->workExperiences ?? [];

    if (empty($workData)) {
        for ($i = 0; $i < 5; $i++) {
            $pdf->SetX($startX);
            $pdf->Cell($columnWidths['duration'],     12 * $scale, '', 1, 0, 'C');
            $pdf->Cell($columnWidths['name_company'], 12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['address'],      12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['division'],     12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['position'],     12 * $scale, '', 1, 1, 'L');
        }
    } else {
        foreach ($workData as $work) {
            $duration = ($work->date_started ?? '') . ($work->date_ended ? ' - ' . $work->date_ended : '');

            $cellHeights = [
                'duration'     => $pdf->getStringHeight($columnWidths['duration'],     $duration,                false, true, 1),
                'name_company' => $pdf->getStringHeight($columnWidths['name_company'], $work->name_company ?? '', false, true, 1),
                'address'      => $pdf->getStringHeight($columnWidths['address'],      $work->address ?? '',      false, true, 1),
                'division'     => $pdf->getStringHeight($columnWidths['division'],     $work->division ?? '',     false, true, 1),
                'position'     => $pdf->getStringHeight($columnWidths['position'],     $work->position ?? '',     false, true, 1),
            ];
            $maxHeight = max(12 * $scale, ...array_values($cellHeights));

            if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                $pdf->AddPage();
            }

            $pdf->SetX($startX);
            $pdf->MultiCell($columnWidths['duration'],     $maxHeight, $duration,                 1, 'C', false, 0);
            $pdf->MultiCell($columnWidths['name_company'], $maxHeight, $work->name_company ?? '',  1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['address'],      $maxHeight, $work->address ?? '',       1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['division'],     $maxHeight, $work->division ?? '',      1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['position'],     $maxHeight, $work->position ?? '',      1, 'L', false, 1);
        }
    }

    $pdf->Ln(5);
}

// FIX: added $scale = 1 to signature
private function generateTrainingSection($pdf, $speaker, $scale = 1)
{
    $pdf->SetFont('helvetica', 'B', 10 * $scale);
    $pdf->Cell(0, 8 * $scale, 'Relevant Trainings/Seminars Attended: (use additional sheet if necessary)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 8 * $scale);

    $columnWidths = [
        'rt_title'      => 115 * $scale,
        'rt_date_venue' => 35 * $scale,
        'rt_no_hours'   => 30 * $scale,
    ];

    $pdf->Cell($columnWidths['rt_title'],      10 * $scale, 'Title',        1, 0, 'C');
    $pdf->Cell($columnWidths['rt_date_venue'], 10 * $scale, 'Date/Venue',   1, 0, 'C');
    $pdf->Cell($columnWidths['rt_no_hours'],   10 * $scale, 'No. of Hours', 1, 1, 'C');

    $trainingData = $speaker->trainings ?? [];

    if (empty($trainingData)) {
        for ($i = 0; $i < 5; $i++) {
            $pdf->Cell($columnWidths['rt_title'],      12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['rt_date_venue'], 12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['rt_no_hours'],   12 * $scale, '', 1, 1, 'C');
        }
    } else {
        foreach ($trainingData as $training) {
            $dateVenue = ($training->rt_date ?? '') . ($training->rt_venue ? ' / ' . $training->rt_venue : '');
            $cellHeights = [
                'rt_title'      => $pdf->getStringHeight($columnWidths['rt_title'],      $training->rt_title ?? '', true, true, 1),
                'rt_date_venue' => $pdf->getStringHeight($columnWidths['rt_date_venue'], $dateVenue,                true, true, 1),
                'rt_no_hours'   => $pdf->getStringHeight($columnWidths['rt_no_hours'],   $training->rt_no_hours ?? '', true, true, 1),
            ];
            $maxHeight = max(12 * $scale, ...array_values($cellHeights));

            if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                $pdf->AddPage();
            }

            $pdf->MultiCell($columnWidths['rt_title'],      $maxHeight, $training->rt_title ?? '',    1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['rt_date_venue'], $maxHeight, $dateVenue,                   1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['rt_no_hours'],   $maxHeight, $training->rt_no_hours ?? '', 1, 'C', false, 1);
        }
    }
    $pdf->Ln(5 * $scale);
}

private function generateExperienceTrainerSection($pdf, $speaker, $scale = 1)
{
    $pdf->SetFont('helvetica', 'B', 10 * $scale);
    $pdf->Cell(0, 8 * $scale, 'Relevant Experience as Trainer/Resource Person: (use additional sheets if necessary)', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 8 * $scale);

    $columnWidths = [
        'rst_title'      => 115 * $scale,
        'rst_date_venue' => 35 * $scale,
        'rst_no_hours'   => 30 * $scale,
    ];

    $pdf->Cell($columnWidths['rst_title'],      10 * $scale, 'Title',        1, 0, 'C');
    $pdf->Cell($columnWidths['rst_date_venue'], 10 * $scale, 'Date/Venue',   1, 0, 'C');
    $pdf->Cell($columnWidths['rst_no_hours'],   10 * $scale, 'No. of Hours', 1, 1, 'C');

    $experienceData = $speaker->experienceTrainer ?? [];

    if (empty($experienceData)) {
        for ($i = 0; $i < 5; $i++) {
            $pdf->Cell($columnWidths['rst_title'],      12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['rst_date_venue'], 12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['rst_no_hours'],   12 * $scale, '', 1, 1, 'C');
        }
    } else {
        foreach ($experienceData as $experience) {
            $dateVenue = ($experience->rst_date ?? '') . ($experience->rst_venue ? ' / ' . $experience->rst_venue : '');
            $cellHeights = [
                'rst_title'      => $pdf->getStringHeight($columnWidths['rst_title'],      $experience->rst_title ?? '', true, true, 1),
                'rst_date_venue' => $pdf->getStringHeight($columnWidths['rst_date_venue'], $dateVenue,                   true, true, 1),
                'rst_no_hours'   => $pdf->getStringHeight($columnWidths['rst_no_hours'],   $experience->rst_no_hours ?? '', true, true, 1),
            ];
            $maxHeight = max(12 * $scale, ...array_values($cellHeights));

            if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                $pdf->AddPage();
            }

            $pdf->MultiCell($columnWidths['rst_title'],      $maxHeight, $experience->rst_title ?? '',    1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['rst_date_venue'], $maxHeight, $dateVenue,                      1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['rst_no_hours'],   $maxHeight, $experience->rst_no_hours ?? '', 1, 'C', false, 1);
        }
    }
    $pdf->Ln(5 * $scale);
}

private function generatePublicationsSection($pdf, $speaker, $scale = 1)
{
    $pdf->SetFont('helvetica', 'B', 10 * $scale);
    $pdf->Cell(0, 8 * $scale, 'Publications, Recognitions and Awards Received', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 8 * $scale);

    $columnWidths = [
        'p_title'      => 90 * $scale,
        'p_nature'     => 45 * $scale,
        'p_date_venue' => 45 * $scale,
    ];

    $pdf->Cell($columnWidths['p_title'],      10 * $scale, 'Title',      1, 0, 'C');
    $pdf->Cell($columnWidths['p_nature'],     10 * $scale, 'Nature',     1, 0, 'C');
    $pdf->Cell($columnWidths['p_date_venue'], 10 * $scale, 'Date/Venue', 1, 1, 'C');

    $publicationData = $speaker->publications ?? [];

    if (empty($publicationData)) {
        for ($i = 0; $i < 5; $i++) {
            $pdf->Cell($columnWidths['p_title'],      12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['p_nature'],     12 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['p_date_venue'], 12 * $scale, '', 1, 1, 'L');
        }
    } else {
        foreach ($publicationData as $publication) {
            $dateVenue = ($publication->p_date ?? '') . ($publication->p_venue ? ' / ' . $publication->p_venue : '');
            $cellHeights = [
                'p_title'      => $pdf->getStringHeight($columnWidths['p_title'],      $publication->p_title ?? '', true, true, 1),
                'p_nature'     => $pdf->getStringHeight($columnWidths['p_nature'],     $publication->p_nature ?? '', true, true, 1),
                'p_date_venue' => $pdf->getStringHeight($columnWidths['p_date_venue'], $dateVenue,                   true, true, 1),
            ];
            $maxHeight = max(12 * $scale, ...array_values($cellHeights));

            if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                $pdf->AddPage();
            }

            $pdf->MultiCell($columnWidths['p_title'],      $maxHeight, $publication->p_title ?? '', 1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['p_nature'],     $maxHeight, $publication->p_nature ?? '', 1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['p_date_venue'], $maxHeight, $dateVenue,                   1, 'L', false, 1);
        }
    }
    $pdf->Ln(5 * $scale);
}

private function generateReferencesSection($pdf, $speaker, $scale = 1)
{
    $pdf->SetFont('helvetica', 'B', 10 * $scale);
    $pdf->Cell(0, 8 * $scale, 'References for Training:', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 8 * $scale);

    $columnWidths = [
        'name_agency'    => 40 * $scale,
        'address'        => 35 * $scale,
        'contact_person' => 30 * $scale,
        'position'       => 25 * $scale,
        'tel_no'         => 20 * $scale,
        'cell_no'        => 20 * $scale,
    ];

    $pdf->Cell($columnWidths['name_agency'],    8 * $scale, 'Name/Agency',    1, 0, 'C');
    $pdf->Cell($columnWidths['address'],        8 * $scale, 'Address',        1, 0, 'C');
    $pdf->Cell($columnWidths['contact_person'], 8 * $scale, 'Contact Person', 1, 0, 'C');
    $pdf->Cell($columnWidths['position'],       8 * $scale, 'Position',       1, 0, 'C');
    $pdf->Cell($columnWidths['tel_no'],         8 * $scale, 'Tel No.',        1, 0, 'C');
    $pdf->Cell($columnWidths['cell_no'],        8 * $scale, 'Cell No.',       1, 1, 'C');

    $referenceData = $speaker->referencesTrainings ?? [];

    if (empty($referenceData)) {
        for ($i = 0; $i < 3; $i++) {
            $pdf->Cell($columnWidths['name_agency'],    10 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['address'],        10 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['contact_person'], 10 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['position'],       10 * $scale, '', 1, 0, 'L');
            $pdf->Cell($columnWidths['tel_no'],         10 * $scale, '', 1, 0, 'C');
            $pdf->Cell($columnWidths['cell_no'],        10 * $scale, '', 1, 1, 'C');
        }
    } else {
        foreach ($referenceData as $reference) {
            $cellHeights = [
                'name_agency'    => $pdf->getStringHeight($columnWidths['name_agency'],    $reference->name_agency ?? '',    true, true, 1),
                'address'        => $pdf->getStringHeight($columnWidths['address'],        $reference->address ?? '',        true, true, 1),
                'contact_person' => $pdf->getStringHeight($columnWidths['contact_person'], $reference->contact_person ?? '', true, true, 1),
                'position'       => $pdf->getStringHeight($columnWidths['position'],       $reference->position ?? '',       true, true, 1),
                'tel_no'         => $pdf->getStringHeight($columnWidths['tel_no'],         $reference->tel_no ?? '',         true, true, 1),
                'cell_no'        => $pdf->getStringHeight($columnWidths['cell_no'],        $reference->cell_no ?? '',        true, true, 1),
            ];
            $maxHeight = max(10 * $scale, ...array_values($cellHeights));

            if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                $pdf->AddPage();
            }

            $pdf->MultiCell($columnWidths['name_agency'],    $maxHeight, $reference->name_agency ?? '',    1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['address'],        $maxHeight, $reference->address ?? '',        1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['contact_person'], $maxHeight, $reference->contact_person ?? '', 1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['position'],       $maxHeight, $reference->position ?? '',       1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['tel_no'],         $maxHeight, $reference->tel_no ?? '',         1, 'C', false, 0);
            $pdf->MultiCell($columnWidths['cell_no'],        $maxHeight, $reference->cell_no ?? '',        1, 'C', false, 1);
        }
    }
    $pdf->Ln(5 * $scale);
}

    public function updateStatus(Request $request, $id)
    {

        // Validate the status
        $request->validate([
            'status' => 'required|in:Pending,Approved,Accredited'
        ]);

        try {
            // Update using Query Builder
            $updated = DB::table('rstbl')
                ->where('id', $id)
                ->update(['status' => $request->status]);

            if ($updated) {
                return redirect()->back()->with('success', 'Status updated successfully to ' . $request->status);
            } else {
                return redirect()->back()->with('error', 'Failed to update status');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
