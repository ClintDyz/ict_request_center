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
    public function create()
    {
        // dd($request->all());

        return view('resource_speaker.create');
    }

    public function store(Request $request)
    {
        // Validate if email exists before starting the transaction
        if (Rstbl::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'The email address is already in use.');
        }

        $imagePath = null;

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Define custom destination path
            $destinationPath = public_path('uploads/images');

            // Ensure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move the file
            $image->move($destinationPath, $imageName);

            // Save relative path to DB
            $imagePath = 'uploads/images/' . $imageName;
        }


        // Use a transaction to ensure atomicity
        DB::transaction(function () use ($request, $imagePath) {

            // Create Personal Info (Rstbl)
            $rstbl = Rstbl::create([
                'last_name' => $request->last_name,
                'given_name' => $request->given_name,
                'middle_name' => $request->middle_name,
                'ext_name' => $request->ext_name,
                'date_of_birth' => $request->date_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'age' => $request->age,
                'gender' => $request->gender,
                'email' => $request->email,
                'expertise' => $request->expertise,
                'home_address' => $request->home_address,
                'home_building_no' => $request->home_building_no,
                'home_barangay' => $request->home_barangay,
                'home_municipality' => $request->home_municipality,
                'home_province' => $request->home_province,
                'home_zip_code' => $request->home_zip_code,
                'home_tel_no' => $request->home_tel_no,
                'home_cell_no' => $request->home_cell_no,
                'home_fax_no' => $request->home_fax_no,
                'img' => $imagePath, // Save the correct relative path

                    'created_by' => Auth::check() ? Auth::id() : null,

            ]);

            // Create Office Info
            $rstbl->office()->create([
                'office_organization' => $request->office_organization,
                'position' => $request->off_position,
                'address' => $request->off_address,
                'building_no' => $request->off_building_no,
                'barangay' => $request->barangay,
                'municipality' => $request->municipality,
                'province' => $request->province,
                'zip_code' => $request->zip_code,
                'tel_no' => $request->off_tel_no,
                'cell_no' => $request->off_cell_no,
                'fax_no' => $request->off_fax_no,
            ]);

                // Create Expertises
                if (!empty($request->expertis) && is_array($request->expertis)) {
                    foreach ($request->expertis as $index => $expertis) {
                        if (!empty($expertis)) {
                            $rstbl->expertises()->create([
                                'expertis' => $expertis,
                            ]);
                        }
                    }
                }

            // Create Educational Background
            if (!empty($request->level) && is_array($request->level)) {
                foreach ($request->level as $index => $level) {
                    $rstbl->educationalBackground()->create([
                        'level' => $level,
                        'school' => $request->school[$index] ?? null,
                        'from_year' => $request->from_year[$index] ?? null,
                        'to_year' => $request->to_year[$index] ?? null,
                        'year_graduated' => $request->year_graduated[$index] ?? null,
                        'awards' => $request->awards[$index] ?? null,
                    ]);
                }
            }

            // Create Work Experience
            if (!empty($request->work_name_company) && is_array($request->work_name_company)) {
                foreach ($request->work_name_company as $key => $company) {
                    $rstbl->workExperiences()->create([
                        'name_company' => $company,
                        'date_started' => $request->work_date_started[$key] ?? null,
                        'date_ended' => $request->work_date_ended[$key] ?? null,
                        'position' => $request->work_position[$key] ?? null,
                        'address' => $request->work_address[$key] ?? null,
                        'division' => $request->work_division[$key] ?? null,
                    ]);
                }
            }


            // Create Experience Trainer
            if (!empty($request->trainer_title) && is_array($request->trainer_title)) {
                foreach ($request->trainer_title as $key => $title) {
                    $rstbl->experienceTrainer()->create([
                        'rst_title' => $title,
                        'rst_venue' => $request->trainer_venue[$key] ?? null,
                        'rst_date' => $request->trainer_date[$key] ?? null,
                        'rst_no_hours' => $request->trainer_no_hours[$key] ?? null,
                    ]);
                }
            }

            // Create References Training
            if (!empty($request->rst_title) && is_array($request->rst_title)) {
                foreach ($request->rst_title as $key => $title) {
                    $rstbl->experienceTrainer()->create([
                        'rst_title' => $title,
                        'rst_date' => $request->rst_date[$key] ?? null,
                        'rst_venue' => $request->rst_venue[$key] ?? null,
                        'rst_no_hours' => $request->rst_no_hours[$key] ?? null,
                    ]);
                }
            }

            if ($request->has('rt_title')) {
                foreach ($request->rt_title as $index => $rt_title) {
                    $rstbl->trainings()->create([
                        'rt_title' => $rt_title,
                        'rt_date' => $request->rt_date[$index] ?? null,
                        'rt_venue' => $request->rt_venue[$index] ?? null,
                        'rt_no_hours' => $request->rt_no_hours[$index] ?? null,
                    ]);
                }
            }

            // Create Publications (Fixed)
            if (!empty($request->publication_title) && is_array($request->publication_title)) {
                foreach ($request->publication_title as $key => $title) {
                    $rstbl->publications()->create([
                        'p_title' => $title,
                        'p_nature' => $request->p_nature[$key] ?? null,
                        'p_date' => $request->p_date[$key] ?? null,
                        'p_venue' => $request->p_venue[$key] ?? null,
                    ]);
                }
            }

            // Create References
                if (!empty($request->name_agency) && is_array($request->name_agency)) {
                    foreach ($request->name_agency as $index => $agency) {
                        if (!empty($agency)) {
                            $rstbl->referencesTrainings()->create([
                                'name_agency'     => $agency,
                                'address'         => $request->ref_address[$index] ?? null,
                                'contact_person'  => $request->contact_person[$index] ?? null,
                                'position'        => $request->ref_position[$index] ?? null,
                                'tel_no'          => $request->ref_tel_no[$index] ?? null,
                                'cell_no'         => $request->ref_cell_no[$index] ?? null,
                                'fax_no'          => $request->ref_fax_no[$index] ?? null,
                            ]);
                        }
                    }
                }


        });
// After transaction...

// If user is NOT logged in (guest)
if (!Auth::check()) {
    return redirect()->route('resource_speaker.create')
        ->with('success', 'Thank you! Your Resource Speaker application has been submitted.');
}

// If admin/user is logged in
return redirect()->route('resource_speaker.index')->with('create', 'med_form');

    }



        public function edit($id)
{
    $speaker = Rstbl::findOrFail($id);
    return view('resource_speaker.update', compact('speaker'));
}


public function update(Request $request, $id)

{

            // Use a transaction to ensure atomicity
            DB::transaction(function () use ($request, $id) {

                // Find the Rstbl record by ID
                $rstbl = Rstbl::findOrFail($id);

                // Check if email already exists for another user
                $existingRecord = Rstbl::where('email', $request->email)->where('id', '!=', $id)->first();
                if ($existingRecord) {
                    return redirect()->back()->with('error', 'The email address is already in use.');
                }

                // Update the Rstbl record
                $rstbl->update([
                    'last_name' => $request->last_name,
                    'given_name' => $request->given_name,
                    'middle_name' => $request->middle_name,
                    'ext_name' => $request->ext_name,
                    'date_of_birth' => $request->date_of_birth,
                    'place_of_birth' => $request->place_of_birth,
                    'age' => $request->age,
                    'email' => $request->email,
                    'expertise' => $request->expertise,
                    'home_address' => $request->home_address,
                    'building_no' => $request->home_building_no,
                    'home_barangay' => $request->home_barangay,
                    'home_municipality' => $request->home_municipality,
                    'home_province' => $request->home_province,
                    'home_zip_code' => $request->home_zip_code,
                    'home_tel_no' => $request->home_tel_no,
                    'home_cell_no' => $request->home_cell_no,
                    'home_fax_no' => $request->home_fax_no,
                    'updated_by' => auth()->id(),
                ]);

                // Update or create Office Info
                $rstbl->office()->updateOrCreate(
                    ['rs_id' => $rstbl->id], // Assuming `rstbl_id` is the foreign key
                    [
                        'office_organization' => $request->office_organization,
                        'position' => $request->position,
                        'address' => $request->office_address,
                        'building_no' => $request->building_no,
                        'barangay' => $request->barangay,
                        'municipality' => $request->municipality,
                        'province' => $request->province,
                        'zip_code' => $request->zip_code,
                        'tel_no' => $request->tel_no,
                        'cell_no' => $request->cell_no,
                        'fax_no' => $request->fax_no,
                    ]
                );

                    // First delete old expertises (optional: depends on your needs)
                        $rstbl->expertises()->delete();

                        // Then insert the new ones
                        if ($request->has('expertis')) {
                            foreach ($request->expertis as $expertise) {
                                if (!empty($expertise)) {
                                    $rstbl->expertises()->create([
                                        'expertis' => $expertise
                                    ]);
                                }
                            }
                        }


                    // Clear old records
                    $rstbl->educationalBackground()->delete();

                    // Save multiple entries
                    if ($request->has('education')) {
                        foreach ($request->education as $entry) {
                            $rstbl->educationalBackground()->create([
                                'level'           => $entry['level'] ?? null,
                                'school'          => $entry['school'] ?? null,
                                'from_year'       => $entry['from_year'] ?? null,
                                'to_year'         => $entry['to_year'] ?? null,
                                'year_graduated'  => $entry['year_graduated'] ?? null,
                                'awards'          => $entry['awards'] ?? null,
                            ]);
                        }
                    }


                    if ($request->has('work') && is_array($request->work)) {
                        // Optional: Clear existing if needed
                        $rstbl->workExperiences()->delete();

                        foreach ($request->work as $entry) {
                            $rstbl->workExperiences()->create([
                                'name_company'  => $entry['name_company'] ?? null,
                                'date_started'  => $entry['date_started'] ?? null,
                                'date_ended'    => $entry['date_ended'] ?? null,
                                'position'      => $entry['position'] ?? null,
                                'address'       => $entry['address'] ?? null,
                                'division'      => $entry['division'] ?? null,
                            ]);
                        }
                    }

                            // Remove existing experience trainers
                            $rstbl->experienceTrainer()->delete();

                            // Recreate experience trainers from the form input
                            if ($request->has('rst_title')) {
                                foreach ($request->rst_title as $key => $title) {
                                    $rstbl->experienceTrainer()->create([
                                        'rst_title'     => $title,
                                        'rst_date'      => $request->rst_date[$key] ?? null,
                                        'rst_venue'     => $request->rst_venue[$key] ?? null,
                                        'rst_no_hours'  => $request->rst_no_hours[$key] ?? null,
                                    ]);
                                }
                            }

                             // Handle Experience as Trainer
                                    $rstbl->trainings()->delete(); // Clear old ones

                                    if ($request->has('rt_title')) {
                                        foreach ($request->rt_title as $index => $rt_title) {
                                            $rstbl->trainings()->create([
                                                'rt_title' => $rt_title,
                                                'rt_date' => $request->rt_date[$index] ?? null,
                                                'rt_venue' => $request->rt_venue[$index] ?? null,
                                                'rt_no_hours' => $request->rt_no_hours[$index] ?? null,
                                            ]);
                                        }
                                    }


                // Update or create References
                // $rstbl->referencesTrainings()->updateOrCreate(
                //     ['rs_id' => $rstbl->id],
                //     [
                //         'name_agency' => $request->name_agency,
                //         'address' => $request->address,
                //         'contact_person' => $request->contact_person,
                //         'position' => $request->position,
                //         'tel_no' => $request->tel_no,
                //         'cell_no' => $request->cell_no,
                //         'fax_no' => $request->fax_no,
                //     ]
                // );

                // First, remove old ones if updating
                    $rstbl->referencesTrainings()->delete(); // Clear old references

                    if ($request->has('references.name_agency')) {
                        foreach ($request->references['name_agency'] as $index => $name_agency) {
                            $rstbl->referencesTrainings()->create([
                                'name_agency'     => $name_agency,
                                'address'         => $request->references['address'][$index] ?? null,
                                'contact_person'  => $request->references['contact_person'][$index] ?? null,
                                'position'        => $request->references['position'][$index] ?? null,
                                'tel_no'          => $request->references['tel_no'][$index] ?? null,
                                'cell_no'         => $request->references['cell_no'][$index] ?? null,
                                'fax_no'          => $request->references['fax_no'][$index] ?? null,
                            ]);
                        }
                    }


                    // Update or create Publications
                    if ($request->has('p_title')) {
                        foreach ($request->p_title as $key => $title) {
                            $rstbl->publications()->updateOrCreate(
                                ['rs_id' => $rstbl->id, 'id' => $key], // Use $key to identify the publication
                                [
                                    'p_title' => $title,
                                    'p_nature' => $request->p_nature[$key] ?? null,
                                    'p_date' => $request->p_date[$key] ?? null,
                                    'p_venue' => $request->p_venue[$key] ?? null,

                                ]
                            );
                        }
                    }

            });

            // Redirect back with success message
            return redirect()->route('resource_speaker.index')->with('edit', 'med_form');

        }

        public function show($id)
        {
            $speaker = Rstbl::with([
                'educationalBackground',
                'workExperiences',
                'experienceTrainer',
                'publications',
                'referencesTrainings',
                'office',
            ])->findOrFail($id);

            return view('resource_speaker.view', compact('speaker'));
        }

        public function destroy($id)
        {

                // Find the record by ID
                $rstbl = Rstbl::findOrFail($id);
    $rstbl->expertises()->delete();

                // Delete the record
                $rstbl->delete();

        return redirect()->back()->with('success', 'Accreditation deleted successfully.');
        }

    public function printPDF($id)
    {
        try {
            // Get speaker data from database - load only existing relationships
            $speaker = Rstbl::with([
                'office',
                'expertises',
                'workExperiences',
                'experienceTrainer', // <-- Corrected
                'publications',
                'referencesTrainings'
            ])->findOrFail($id);

            // Create custom TCPDF class
            $pdf = new class extends TCPDF {
                // Page header
                public function Header()
                {
                        // ✅ Add your logo image
                        $image_file = public_path('img/Dostcar.jpg'); // path to your image
                        if (file_exists($image_file)) {
                            // x, y, width (height auto-calculated)
                            $this->Image($image_file, 15, 10, 20); // adjust position & size
                        }
                    // Header text
                    $this->SetFont('helvetica', 'B', 10);
                    $this->SetXY(40, 10);
                    $this->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
                    $this->SetXY(40, 15);
                    $this->Cell(0, 5, 'Department of Science and Technology', 0, 1, 'C');
                    $this->SetXY(40, 20);
                    $this->Cell(0, 5, 'Cordillera Administrative Region', 0, 1, 'C');

                    // Page number
                    $this->SetFont('helvetica', '', 8);
                    $this->SetXY(170, 10);
                    $this->Cell(0, 5, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 1, 'R');
                }

                // Page footer
                public function Footer()
                {
                    // Position at 15 mm from bottom
                    $this->SetY(-15);
                    $this->SetFont('helvetica', 'I', 8);
                    $this->Cell(0, 10, 'Generated on ' . date('Y-m-d H:i:s'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                }
            };

            // Set document information
            $pdf->SetCreator('DOST Cordillera');
            $pdf->SetAuthor('Department of Science and Technology');
            $pdf->SetTitle('Application Form - ' . $speaker->last_name . ', ' . $speaker->given_name);
            $pdf->SetSubject('Technical Personnel/Trainer/Subject Matter Specialist');

            // Set default header data
            $pdf->SetHeaderData('', 0, '', '');

            // Set header and footer fonts
            $pdf->setHeaderFont(Array('helvetica', '', 10));
            $pdf->setFooterFont(Array('helvetica', '', 8));

            // Set default monospaced font
            $pdf->SetDefaultMonospacedFont('courier');

            // Set margins
            $pdf->SetMargins(15, 35, 15);
            $pdf->SetHeaderMargin(5);
            $pdf->SetFooterMargin(10);

            // Set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 25);

            // Set image scale factor
            $pdf->setImageScale(1.25);

            // Add a page
            $pdf->AddPage();

            // Generate form content with speaker data
            $this->generateFormContent($pdf, $speaker);

            // Generate filename
            $filename = 'Application_Form_' . $speaker->last_name . '_' . $speaker->given_name . '_' . date('Y-m-d') . '.pdf';

            // Output PDF for inline display
            return response($pdf->Output($filename, 'S'), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $filename . '"');

        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Generate form content with speaker data
     */
    private function generateFormContent($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 12);
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
        $pdf->Cell(15, 8, '', 0, 0, 'L');
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
        $pdf->Cell(100, 8, $speaker->office->office_organization ?? 'N/A', 'B', 0, 'L');
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(20, 8, 'Position:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(75, 8, $speaker->office->position ?? 'N/A', 'B', 1, 'L');
        $pdf->Ln(3);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Office Address:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetX(20);
        $pdf->Cell(25, 8, 'Building No.:', 0, 0, 'L');
        $pdf->Cell(65, 8, $speaker->office->building_no ?? '', 'B', 0, 'L');
        $pdf->Cell(30, 8, 'Street/Barangay:', 0, 0, 'L');
        $pdf->Cell(60, 8, $speaker->office->barangay ?? '', 'B', 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(30, 8, 'Municipality/City:', 0, 0, 'L');
        $pdf->Cell(65, 8, $speaker->office->municipality ?? '', 'B', 0, 'L');
        $pdf->Cell(20, 8, 'Province:', 0, 0, 'L');
        $pdf->Cell(60, 8, $speaker->office->province ?? '', 'B', 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(20, 8, 'Zip Code:', 0, 0, 'L');
        $pdf->Cell(65, 8, $speaker->office->zip_code ?? '', 'B', 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(35, 8, 'Contact Number:', 0, 0, 'L');
        $pdf->Cell(15, 8, 'Tel. No.:', 0, 0, 'L');
        $pdf->Cell(50, 8, $speaker->office->tel_no ?? '', 'B', 0, 'L');
        $pdf->Cell(25, 8, 'Cellphone No.:', 0, 0, 'L');
        $pdf->Cell(50, 8, $speaker->office->cell_no ?? '', 'B', 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(35, 8, '', 0, 0, 'L');
        $pdf->Cell(15, 8, 'Fax No.:', 0, 0, 'L');
        $pdf->Cell(50, 8, $speaker->office->fax_no ?? '', 'B', 1, 'L');
        $pdf->Ln(3);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Home/Residence Address:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetX(20);
        $pdf->Cell(25, 8, 'Building No.:', 0, 0, 'L');
        $pdf->Cell(65, 8, $speaker->home_building_no ?? '', 'B', 0, 'L');
        $pdf->Cell(30, 8, 'Street/Barangay:', 0, 0, 'L');
        $pdf->Cell(60, 8, $speaker->home_barangay ?? '', 'B', 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(30, 8, 'Municipality/City:', 0, 0, 'L');
        $pdf->Cell(65, 8, $speaker->home_municipality ?? '', 'B', 0, 'L');
        $pdf->Cell(20, 8, 'Province:', 0, 0, 'L');
        $pdf->Cell(60, 8, $speaker->home_province ?? '', 'B', 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(20, 8, 'Zip Code:', 0, 0, 'L');
        $pdf->Cell(65, 8, $speaker->home_zip_code ?? '', 'B', 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(35, 8, 'Contact Number:', 0, 0, 'L');
        $pdf->Cell(15, 8, 'Tel. No.:', 0, 0, 'L');
        $pdf->Cell(50, 8, $speaker->home_tel_no ?? '', 'B', 0, 'L');
        $pdf->Cell(25, 8, 'Cellphone No.:', 0, 0, 'L');
        $pdf->Cell(50, 8, $speaker->home_cell_no ?? '', 'B', 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(35, 8, '', 0, 0, 'L');
        $pdf->Cell(15, 8, 'Fax No.:', 0, 0, 'L');
        $pdf->Cell(50, 8, $speaker->home_fax_no ?? '', 'B', 1, 'L');
        $pdf->Ln(5);

        $this->generateExpertSection($pdf, $speaker);
        $this->generateEducationalTable($pdf, $speaker);
        $this->generateWorkExperienceSection($pdf, $speaker);
        $this->generateTrainingSection($pdf, $speaker);
        $this->generateExperienceTrainerSection($pdf, $speaker);
        $this->generatePublicationsSection($pdf, $speaker);
        $this->generateReferencesSection($pdf, $speaker);
    }

    private function generateExpertSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(70, 8, 'Field/s of Specialization/Expertise:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);

        // Get expertises and format them
        $expertiseList = $speaker->expertises && $speaker->expertises->count() > 0
            ? $speaker->expertises->pluck('expertis')->implode(', ')
            : 'N/A';

        $pdf->MultiCell(100, 8, $expertiseList, 'B', 'L', false, 1);
        $pdf->Ln(5);
    }

    private function generateEducationalTable($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(70, 8, 'Field/s of Specialization/Expertise:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $expertiseList = $speaker->expertises ? $speaker->expertises->pluck('expertis')->implode(', ') : 'N/A';
        $pdf->MultiCell(100, 8, $expertiseList, 'B', 'L', false, 1);
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Educational Background:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 8);

        // Calculate available page width (A4 = 210mm, margins = 15mm each)
        $pageWidth = $pdf->getPageWidth() - 30; // 180mm
        $borderWidth = 0.5; // Border width in mm
        $totalBorders = 7 * $borderWidth; // 6 columns + outer border
        $availableWidth = $pageWidth - $totalBorders;

        // Define column widths proportionally
        $columnWidths = [
            'level' => max(30, min(40, $availableWidth * 0.20)),
            'from_year' => max(20, min(25, $availableWidth * 0.15)),
            'to_year' => max(20, min(25, $availableWidth * 0.15)),
            'school' => max(40, min(50, $availableWidth * 0.30)),
            'year_graduated' => max(20, min(30, $availableWidth * 0.15)),
            'awards' => max(20, min(25, $availableWidth * 0.15)),
        ];

        // Scale if total width exceeds page width
        $totalTableWidth = array_sum($columnWidths) + $totalBorders;
        if ($totalTableWidth > $pageWidth) {
            $scaleFactor = $pageWidth / $totalTableWidth;
            foreach ($columnWidths as $key => $width) {
                $columnWidths[$key] = max(10, $width * $scaleFactor);
            }
        }

        // Table headers
        $pdf->Cell($columnWidths['level'], 8, 'Level/Degree', 1, 0, 'C');
        $pdf->Cell($columnWidths['from_year'], 8, 'From Year', 1, 0, 'C');
        $pdf->Cell($columnWidths['to_year'], 8, 'To Year', 1, 0, 'C');
        $pdf->Cell($columnWidths['school'], 8, 'School/Institution', 1, 0, 'C');
        $pdf->Cell($columnWidths['year_graduated'], 8, 'Year Graduated', 1, 0, 'C');
        $pdf->Cell($columnWidths['awards'], 8, 'Awards', 1, 1, 'C');

        // Fetch educational data
        $educationalData = DB::table('rs_educational')->where('rs_id', $speaker->id)->get();

        foreach ($educationalData as $education) {
            $maxHeight = 8;
            $cellHeights = [
                'level' => $pdf->getStringHeight($columnWidths['level'], $education->level ?? '', true, true, 1),
                'from_year' => $pdf->getStringHeight($columnWidths['from_year'], $education->from_year ?? '', true, true, 1),
                'to_year' => $pdf->getStringHeight($columnWidths['to_year'], $education->to_year ?? '', true, true, 1),
                'school' => $pdf->getStringHeight($columnWidths['school'], $education->school ?? '', true, true, 1),
                'year_graduated' => $pdf->getStringHeight($columnWidths['year_graduated'], $education->year_graduated ?? '', true, true, 1),
                'awards' => $pdf->getStringHeight($columnWidths['awards'], $education->awards ?? '', true, true, 1),
            ];
            $maxHeight = max($maxHeight, ...array_values($cellHeights));

            if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                $pdf->AddPage();
            }

            $pdf->MultiCell($columnWidths['level'], $maxHeight, $education->level ?? '', 1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['from_year'], $maxHeight, $education->from_year ?? '', 1, 'C', false, 0);
            $pdf->MultiCell($columnWidths['to_year'], $maxHeight, $education->to_year ?? '', 1, 'C', false, 0);
            $pdf->MultiCell($columnWidths['school'], $maxHeight, $education->school ?? '', 1, 'L', false, 0);
            $pdf->MultiCell($columnWidths['year_graduated'], $maxHeight, $education->year_graduated ?? '', 1, 'C', false, 0);
            $pdf->MultiCell($columnWidths['awards'], $maxHeight, $education->awards ?? '', 1, 'L', false, 1);
        }

        if (!$educationalData->isEmpty()) {
            $pdf->Ln(5);
        }
    }

    private function generateWorkExperienceSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Work Experience:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 8);

        $pageWidth = $pdf->getPageWidth() - 30;
        $borderWidth = 0.5;
        $totalBorders = 6 * $borderWidth;
        $availableWidth = $pageWidth - $totalBorders;

        $columnWidths = [
            'date_started' => max(25, min(30, $availableWidth * 0.15)),
            'date_ended' => max(25, min(30, $availableWidth * 0.15)),
            'name_company' => max(50, min(60, $availableWidth * 0.35)),
            'position' => max(40, min(50, $availableWidth * 0.25)),
            'division' => max(30, min(40, $availableWidth * 0.20)),
        ];

        $totalTableWidth = array_sum($columnWidths) + $totalBorders;
        if ($totalTableWidth > $pageWidth) {
            $scaleFactor = $pageWidth / $totalTableWidth;
            foreach ($columnWidths as $key => $width) {
                $columnWidths[$key] = max(10, $width * $scaleFactor);
            }
        }

        $pdf->Cell($columnWidths['date_started'], 8, 'Start Date', 1, 0, 'C');
        $pdf->Cell($columnWidths['date_ended'], 8, 'End Date', 1, 0, 'C');
        $pdf->Cell($columnWidths['name_company'], 8, 'Company/Organization', 1, 0, 'C');
        $pdf->Cell($columnWidths['position'], 8, 'Position', 1, 0, 'C');
        $pdf->Cell($columnWidths['division'], 8, 'Division/Department', 1, 1, 'C');

        $workData = $speaker->workExperiences ?? [];

        if (empty($workData)) {
            for ($i = 0; $i < 5; $i++) {
                $pdf->Cell($columnWidths['date_started'], 8, '', 1, 0, 'C');
                $pdf->Cell($columnWidths['date_ended'], 8, '', 1, 0, 'C');
                $pdf->Cell($columnWidths['name_company'], 8, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['position'], 8, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['division'], 8, '', 1, 1, 'L');
            }
        } else {
            foreach ($workData as $work) {
                $maxHeight = 8;
                $cellHeights = [
                    'date_started' => $pdf->getStringHeight($columnWidths['date_started'], $work->date_started ?? '', true, true, 1),
                    'date_ended' => $pdf->getStringHeight($columnWidths['date_ended'], $work->date_ended ?? '', true, true, 1),
                    'name_company' => $pdf->getStringHeight($columnWidths['name_company'], $work->name_company ?? '', true, true, 1),
                    'position' => $pdf->getStringHeight($columnWidths['position'], $work->position ?? '', true, true, 1),
                    'division' => $pdf->getStringHeight($columnWidths['division'], $work->division ?? '', true, true, 1),
                ];
                $maxHeight = max($maxHeight, ...array_values($cellHeights));

                if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                    $pdf->AddPage();
                }

                $pdf->MultiCell($columnWidths['date_started'], $maxHeight, $work->date_started ?? '', 1, 'C', false, 0);
                $pdf->MultiCell($columnWidths['date_ended'], $maxHeight, $work->date_ended ?? '', 1, 'C', false, 0);
                $pdf->MultiCell($columnWidths['name_company'], $maxHeight, $work->name_company ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['position'], $maxHeight, $work->position ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['division'], $maxHeight, $work->division ?? '', 1, 'L', false, 1);
            }
        }
        $pdf->Ln(5);
    }

    private function generateTrainingSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Training/Seminar Experience:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 8);

        $pageWidth = $pdf->getPageWidth() - 30;
        $borderWidth = 0.5;
        $totalBorders = 5 * $borderWidth;
        $availableWidth = $pageWidth - $totalBorders;

        $columnWidths = [
            'rt_title' => max(80, min(90, $availableWidth * 0.50)),
            'rt_venue' => max(40, min(50, $availableWidth * 0.25)),
            'rt_date' => max(30, min(35, $availableWidth * 0.15)),
            'rt_no_hours' => max(20, min(25, $availableWidth * 0.10)),
        ];

        $totalTableWidth = array_sum($columnWidths) + $totalBorders;
        if ($totalTableWidth > $pageWidth) {
            $scaleFactor = $pageWidth / $totalTableWidth;
            foreach ($columnWidths as $key => $width) {
                $columnWidths[$key] = max(10, $width * $scaleFactor);
            }
        }

        $pdf->Cell($columnWidths['rt_title'], 8, 'Training Title', 1, 0, 'C');
        $pdf->Cell($columnWidths['rt_venue'], 8, 'Venue', 1, 0, 'C');
        $pdf->Cell($columnWidths['rt_date'], 8, 'Date', 1, 0, 'C');
        $pdf->Cell($columnWidths['rt_no_hours'], 8, 'Hours', 1, 1, 'C');

        $trainingData = $speaker->trainings ?? [];

        if (empty($trainingData)) {
            for ($i = 0; $i < 5; $i++) {
                $pdf->Cell($columnWidths['rt_title'], 8, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['rt_venue'], 8, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['rt_date'], 8, '', 1, 0, 'C');
                $pdf->Cell($columnWidths['rt_no_hours'], 8, '', 1, 1, 'C');
            }
        } else {
            foreach ($trainingData as $training) {
                $maxHeight = 8;
                $cellHeights = [
                    'rt_title' => $pdf->getStringHeight($columnWidths['rt_title'], $training->rt_title ?? '', true, true, 1),
                    'rt_venue' => $pdf->getStringHeight($columnWidths['rt_venue'], $training->rt_venue ?? '', true, true, 1),
                    'rt_date' => $pdf->getStringHeight($columnWidths['rt_date'], $training->rt_date ?? '', true, true, 1),
                    'rt_no_hours' => $pdf->getStringHeight($columnWidths['rt_no_hours'], $training->rt_no_hours ?? '', true, true, 1),
                ];
                $maxHeight = max($maxHeight, ...array_values($cellHeights));

                if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                    $pdf->AddPage();
                }

                $pdf->MultiCell($columnWidths['rt_title'], $maxHeight, $training->rt_title ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['rt_venue'], $maxHeight, $training->rt_venue ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['rt_date'], $maxHeight, $training->rt_date ?? '', 1, 'C', false, 0);
                $pdf->MultiCell($columnWidths['rt_no_hours'], $maxHeight, $training->rt_no_hours ?? '', 1, 'C', false, 1);
            }
        }
        $pdf->Ln(5);
    }

    private function generateExperienceTrainerSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Training Experience as Trainer:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 8);

        $pageWidth = $pdf->getPageWidth() - 30;
        $borderWidth = 0.5;
        $totalBorders = 5 * $borderWidth;
        $availableWidth = $pageWidth - $totalBorders;

        $columnWidths = [
            'rst_title' => max(80, min(90, $availableWidth * 0.50)),
            'rst_venue' => max(40, min(50, $availableWidth * 0.25)),
            'rst_date' => max(30, min(35, $availableWidth * 0.15)),
            'rst_no_hours' => max(20, min(25, $availableWidth * 0.10)),
        ];

        $totalTableWidth = array_sum($columnWidths) + $totalBorders;
        if ($totalTableWidth > $pageWidth) {
            $scaleFactor = $pageWidth / $totalTableWidth;
            foreach ($columnWidths as $key => $width) {
                $columnWidths[$key] = max(10, $width * $scaleFactor);
            }
        }

        $pdf->Cell($columnWidths['rst_title'], 8, 'Training Title', 1, 0, 'C');
        $pdf->Cell($columnWidths['rst_venue'], 8, 'Venue', 1, 0, 'C');
        $pdf->Cell($columnWidths['rst_date'], 8, 'Date', 1, 0, 'C');
        $pdf->Cell($columnWidths['rst_no_hours'], 8, 'Hours', 1, 1, 'C');

        $experienceData = $speaker->experienceTrainer ?? [];

        if (empty($experienceData)) {
            for ($i = 0; $i < 5; $i++) {
                $pdf->Cell($columnWidths['rst_title'], 8, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['rst_venue'], 8, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['rst_date'], 8, '', 1, 0, 'C');
                $pdf->Cell($columnWidths['rst_no_hours'], 8, '', 1, 1, 'C');
            }
        } else {
            foreach ($experienceData as $experience) {
                $maxHeight = 8;
                $cellHeights = [
                    'rst_title' => $pdf->getStringHeight($columnWidths['rst_title'], $experience->rst_title ?? '', true, true, 1),
                    'rst_venue' => $pdf->getStringHeight($columnWidths['rst_venue'], $experience->rst_venue ?? '', true, true, 1),
                    'rst_date' => $pdf->getStringHeight($columnWidths['rst_date'], $experience->rst_date ?? '', true, true, 1),
                    'rst_no_hours' => $pdf->getStringHeight($columnWidths['rst_no_hours'], $experience->rst_no_hours ?? '', true, true, 1),
                ];
                $maxHeight = max($maxHeight, ...array_values($cellHeights));

                if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                    $pdf->AddPage();
                }

                $pdf->MultiCell($columnWidths['rst_title'], $maxHeight, $experience->rst_title ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['rst_venue'], $maxHeight, $experience->rst_venue ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['rst_date'], $maxHeight, $experience->rst_date ?? '', 1, 'C', false, 0);
                $pdf->MultiCell($columnWidths['rst_no_hours'], $maxHeight, $experience->rst_no_hours ?? '', 1, 'C', false, 1);
            }
        }
        $pdf->Ln(5);
    }

    private function generatePublicationsSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Publications:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 8);

        $pageWidth = $pdf->getPageWidth() - 30;
        $borderWidth = 0.5;
        $totalBorders = 4 * $borderWidth;
        $availableWidth = $pageWidth - $totalBorders;

        $columnWidths = [
            'p_title' => max(100, min(110, $availableWidth * 0.60)),
            'p_date' => max(40, min(45, $availableWidth * 0.25)),
            'p_venue' => max(30, min(35, $availableWidth * 0.15)),
        ];

        $totalTableWidth = array_sum($columnWidths) + $totalBorders;
        if ($totalTableWidth > $pageWidth) {
            $scaleFactor = $pageWidth / $totalTableWidth;
            foreach ($columnWidths as $key => $width) {
                $columnWidths[$key] = max(10, $width * $scaleFactor);
            }
        }

        $pdf->Cell($columnWidths['p_title'], 8, 'Publication Title', 1, 0, 'C');
        $pdf->Cell($columnWidths['p_date'], 8, 'Date Published', 1, 0, 'C');
        $pdf->Cell($columnWidths['p_venue'], 8, 'Venue', 1, 1, 'C');

        $publicationData = $speaker->publications ?? [];

        if (empty($publicationData)) {
            for ($i = 0; $i < 5; $i++) {
                $pdf->Cell($columnWidths['p_title'], 8, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['p_date'], 8, '', 1, 0, 'C');
                $pdf->Cell($columnWidths['p_venue'], 8, '', 1, 1, 'L');
            }
        } else {
            foreach ($publicationData as $publication) {
                $maxHeight = 8;
                $cellHeights = [
                    'p_title' => $pdf->getStringHeight($columnWidths['p_title'], $publication->p_title ?? '', true, true, 1),
                    'p_date' => $pdf->getStringHeight($columnWidths['p_date'], $publication->p_date ?? '', true, true, 1),
                    'p_venue' => $pdf->getStringHeight($columnWidths['p_venue'], $publication->p_venue ?? '', true, true, 1),
                ];
                $maxHeight = max($maxHeight, ...array_values($cellHeights));

                if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                    $pdf->AddPage();
                }

                $pdf->MultiCell($columnWidths['p_title'], $maxHeight, $publication->p_title ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['p_date'], $maxHeight, $publication->p_date ?? '', 1, 'C', false, 0);
                $pdf->MultiCell($columnWidths['p_venue'], $maxHeight, $publication->p_venue ?? '', 1, 'L', false, 1);
            }
        }
        $pdf->Ln(5);
    }

    private function generateReferencesSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'References for Training:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 8);

        $pageWidth = $pdf->getPageWidth() - 30;
        $borderWidth = 0.5;
        $totalBorders = 7 * $borderWidth;
        $availableWidth = $pageWidth - $totalBorders;

        $columnWidths = [
            'name_agency' => max(50, min(60, $availableWidth * 0.30)),
            'address' => max(40, min(50, $availableWidth * 0.25)),
            'contact_person' => max(25, min(30, $availableWidth * 0.15)),
            'position' => max(25, min(30, $availableWidth * 0.15)),
            'tel_no' => max(20, min(25, $availableWidth * 0.10)),
            'cell_no' => max(20, min(25, $availableWidth * 0.10)),
        ];

        $totalTableWidth = array_sum($columnWidths) + $totalBorders;
        if ($totalTableWidth > $pageWidth) {
            $scaleFactor = $pageWidth / $totalTableWidth;
            foreach ($columnWidths as $key => $width) {
                $columnWidths[$key] = max(10, $width * $scaleFactor);
            }
        }

        $pdf->Cell($columnWidths['name_agency'], 8, 'Name/Agency', 1, 0, 'C');
        $pdf->Cell($columnWidths['address'], 8, 'Address', 1, 0, 'C');
        $pdf->Cell($columnWidths['contact_person'], 8, 'Contact Person', 1, 0, 'C');
        $pdf->Cell($columnWidths['position'], 8, 'Position', 1, 0, 'C');
        $pdf->Cell($columnWidths['tel_no'], 8, 'Tel No.', 1, 0, 'C');
        $pdf->Cell($columnWidths['cell_no'], 8, 'Cell No.', 1, 1, 'C');

        $referenceData = $speaker->referencesTrainings ?? [];

        if (empty($referenceData)) {
            for ($i = 0; $i < 3; $i++) {
                $pdf->Cell($columnWidths['name_agency'], 10, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['address'], 10, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['contact_person'], 10, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['position'], 10, '', 1, 0, 'L');
                $pdf->Cell($columnWidths['tel_no'], 10, '', 1, 0, 'C');
                $pdf->Cell($columnWidths['cell_no'], 10, '', 1, 1, 'C');
            }
        } else {
            foreach ($referenceData as $reference) {
                $maxHeight = 10;
                $cellHeights = [
                    'name_agency' => $pdf->getStringHeight($columnWidths['name_agency'], $reference->name_agency ?? '', true, true, 1),
                    'address' => $pdf->getStringHeight($columnWidths['address'], $reference->address ?? '', true, true, 1),
                    'contact_person' => $pdf->getStringHeight($columnWidths['contact_person'], $reference->contact_person ?? '', true, true, 1),
                    'position' => $pdf->getStringHeight($columnWidths['position'], $reference->position ?? '', true, true, 1),
                    'tel_no' => $pdf->getStringHeight($columnWidths['tel_no'], $reference->tel_no ?? '', true, true, 1),
                    'cell_no' => $pdf->getStringHeight($columnWidths['cell_no'], $reference->cell_no ?? '', true, true, 1),
                ];
                $maxHeight = max($maxHeight, ...array_values($cellHeights));

                if ($pdf->GetY() + $maxHeight > $pdf->getPageHeight() - 25) {
                    $pdf->AddPage();
                }

                $pdf->MultiCell($columnWidths['name_agency'], $maxHeight, $reference->name_agency ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['address'], $maxHeight, $reference->address ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['contact_person'], $maxHeight, $reference->contact_person ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['position'], $maxHeight, $reference->position ?? '', 1, 'L', false, 0);
                $pdf->MultiCell($columnWidths['tel_no'], $maxHeight, $reference->tel_no ?? '', 1, 'C', false, 0);
                $pdf->MultiCell($columnWidths['cell_no'], $maxHeight, $reference->cell_no ?? '', 1, 'C', false, 1);
            }
        }
        $pdf->Ln(5);
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
