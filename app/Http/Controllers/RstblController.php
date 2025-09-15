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
    public function index()
    {
        // $speakers = Rstbl::all();
        // $expertis = Expertis::with('expertis')->get();
        $speakers = Rstbl::with('expertises')->get();

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
                'building_no' => $request->home_building_no,
                'home_barangay' => $request->home_barangay,
                'home_municipality' => $request->home_municipality,
                'home_province' => $request->home_province,
                'home_zip_code' => $request->home_zip_code,
                'home_tel_no' => $request->home_tel_no,
                'home_cell_no' => $request->home_cell_no,
                'home_fax_no' => $request->home_fax_no,
                'created_by' =>  Auth::id(),
                'img' => $imagePath, // Save the correct relative path

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

        // Redirect back with success message
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
        // Set font
        $pdf->SetFont('helvetica', '', 10);

        // Title
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'APPLICATION FORM FOR THE ACCREDITATION OF', 0, 1, 'C');
        $pdf->Cell(0, 10, 'TECHNICAL PERSONNEL/TRAINER/SUBJECT MATTER SPECIALIST', 0, 1, 'C');
        $pdf->Ln(5);

        // Personal Information Section
        // $pdf->SetFont('helvetica', 'B', 10);
        // $pdf->Cell(0, 8, 'Name:', 0, 1, 'L');

        // Name with data
        $pdf->SetFont('helvetica', '', 10);
        // $y = $pdf->GetY();

        // Fill in the actual name data
        // $pdf->SetY($y);
        $pdf->Cell(15, 8, 'Name:', 0, 0, 'L');
        $pdf->Cell(45, 8, $speaker->last_name ?? '', 'B', 0, 'L');
        $pdf->Cell(45, 8, $speaker->given_name ?? '', 'B', 0, 'L');
        $pdf->Cell(40, 8, $speaker->middle_name ?? '', 'B', 0, 'L');
        $pdf->Cell(35, 8, $speaker->ext_name ?? '', 'B', 1, 'L');

        // Name labels
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(15, 8, '', 0, 0, 'L');
        $pdf->Cell(45, 5, 'Last Name', 0, 0, 'L');
        $pdf->Cell(45, 5, 'Given Name', 0, 0, 'L');
        $pdf->Cell(40, 5, 'Middle Name', 0, 0, 'L');
        $pdf->Cell(35, 5, 'Name Ext\'n (e.g., III, Sr)', 0, 1, 'L');

        $pdf->Ln(5);

        // Date of Birth and Place of Birth
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

        // Gender and Email
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(40, 8, 'Office/Organization::', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(100, 8, $speaker->office->office_organization ?? 'N/A', 'B', 0, 'L');

        $pdf->Ln(5);
        $pdf->Ln(5);


        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(20, 8, 'Position:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(75, 8, $speaker->office->position ?? 'N/A', 'B', 1, 'L');

        $pdf->Ln(5);

         $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(40, 8, 'Office/Organization::', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(100, 8, $speaker->office->office_organization ?? 'N/A', 'B', 0, 'L');

    $pdf->Ln(5);
    $pdf->Ln(5);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(20, 8, 'Position:', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(75, 8, $speaker->office->position ?? 'N/A', 'B', 1, 'L');

    $pdf->Ln(3);
        // This is the correct, inline code you have added
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

        // Home/Residence Address
        // $this->generateAddressSection($pdf, 'Home/Residence Address:', $speaker, 'home_');

        $pdf->Ln(3);
                // Home/Residence Address
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

        // Expert Information
        $this->generateExpertSection($pdf, $speaker);

        // Rearranged section calls
        $this->generateEducationalTable($pdf, $speaker);

        // Add new page to ensure sections start on a fresh page if needed
        // $pdf->AddPage();

        $this->generateWorkExperienceSection($pdf, $speaker);
        $this->generateTrainingSection($pdf, $speaker);
        $this->generateExperienceTrainerSection($pdf, $speaker);
        $this->generatePublicationsSection($pdf, $speaker);
        $this->generateReferencesSection($pdf, $speaker);
    }

    /**
 * Generate office address section with data
 */
    /**
     * Generate address section with data
     */
/**
 * Generate educational background table
 */
private function generateEducationalTable($pdf, $speaker)
{
    // Expertise
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(70, 8, 'Field/s of Specialization/Expertise:', 0, 0, 'L');

    $pdf->SetFont('helvetica', '', 10);
    $expertiseList = $speaker->expertises ? $speaker->expertises->pluck('expertis')->implode(', ') : 'N/A';
    $pdf->Cell(100, 8, $expertiseList, 'B', 1, 'L');
    $pdf->Ln(10);

    // Section title
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 8, 'Educational Background:', 0, 1, 'L');

    // Set font for table content
    $pdf->SetFont('helvetica', '', 8);

    // Table headers
    $pdf->Cell(30, 8, 'Level/Degree', 1, 0, 'C');
    $pdf->Cell(25, 8, 'From Year', 1, 0, 'C');
    $pdf->Cell(25, 8, 'To Year', 1, 0, 'C');
    $pdf->Cell(50, 8, 'School/Institution', 1, 0, 'C');
    $pdf->Cell(30, 8, 'Year Graduated', 1, 0, 'C');
    $pdf->Cell(25, 8, 'Awards', 1, 1, 'C');

    // Fetch educational data directly from the DB by rs_id
    $educationalData = DB::table('rs_educational')
        ->where('rs_id', $speaker->id)
        ->get();

    // Display data
    foreach ($educationalData as $education) {
        $pdf->Cell(30, 10, $education->level ?? '', 1, 0, 'L');
        $pdf->Cell(25, 10, $education->from_year ?? '', 1, 0, 'C');
        $pdf->Cell(25, 10, $education->to_year ?? '', 1, 0, 'C');
        $pdf->Cell(50, 10, $education->school ?? '', 1, 0, 'L');
        $pdf->Cell(30, 10, $education->year_graduated ?? '', 1, 0, 'C');
        $pdf->Cell(25, 10, $education->awards ?? '', 1, 1, 'L');
    }

    // Check if any educational data was printed and add a line break to prevent the next table from starting too far down
    if (!$educationalData->isEmpty()) {
        $pdf->Ln(5);
    }
}

    /**
     * Generate work experience section
     */
    private function generateWorkExperienceSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Work Experience:', 0, 1, 'L');

        // Create table
        $pdf->SetFont('helvetica', '', 8);

        // Table headers
        $pdf->Cell(25, 8, 'Start Date', 1, 0, 'C');
        $pdf->Cell(25, 8, 'End Date', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Company/Organization', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Position', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Division/Department', 1, 1, 'C');

        // Get work experience data from related table (if relationship exists)
        $workData = [];
        if (method_exists($speaker, 'workExperiences') && $speaker->workExperiences) {
            $workData = $speaker->workExperiences;
        }

        if (empty($workData)) {
            // Add empty rows for manual filling
            for ($i = 0; $i < 5; $i++) {
                $pdf->Cell(25, 8, '', 1, 0, 'C');
                $pdf->Cell(25, 8, '', 1, 0, 'C');
                $pdf->Cell(50, 8, '', 1, 0, 'L');
                $pdf->Cell(40, 8, '', 1, 0, 'L');
                $pdf->Cell(40, 8, '', 1, 1, 'L');
            }
        } else {
            foreach ($workData as $work) {
                $pdf->Cell(25, 8, $work->date_started ?? '', 1, 0, 'C');
                $pdf->Cell(25, 8, $work->date_ended ?? '', 1, 0, 'C');
                $pdf->Cell(50, 8, $work->name_company ?? '', 1, 0, 'L');
                $pdf->Cell(40, 8, $work->position ?? '', 1, 0, 'L');
                $pdf->Cell(40, 8, $work->division ?? '', 1, 1, 'L');
            }
        }

        $pdf->Ln(5);
    }

    /**
     * Generate training section
     */
    private function generateTrainingSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Training/Seminar Experience:', 0, 1, 'L');

        // Create table
        $pdf->SetFont('helvetica', '', 8);

        // Table headers - REMOVED the Remarks column
            $pdf->Cell(80, 8, 'Training Title', 1, 0, 'C');
            $pdf->Cell(40, 8, 'Venue', 1, 0, 'C');
            $pdf->Cell(30, 8, 'Date', 1, 0, 'C');
            $pdf->Cell(30, 8, 'Hours', 1, 1, 'C');

        // Get training data from related table (if relationship exists)
        $trainingData = [];
        if (method_exists($speaker, 'trainings') && $speaker->trainings) {
            $trainingData = $speaker->trainings;
        }

        if (empty($trainingData)) {
            // Add empty rows for manual filling - REMOVED the empty Remarks cell
            for ($i = 0; $i < 5; $i++) {
                $pdf->Cell(80, 8, '', 1, 0, 'L');
                $pdf->Cell(40, 8, '', 1, 0, 'L');
                $pdf->Cell(30, 8, '', 1, 0, 'C');
                $pdf->Cell(30, 8, '', 1, 1, 'C'); // Changed from 0 to 1 to end the row
            }
        } else {
            foreach ($trainingData as $training) {
                // Data rows - REMOVED the Remarks cell
                $pdf->Cell(80, 8, $training->rt_title ?? '', 1, 0, 'L');
                $pdf->Cell(40, 8, $training->rt_venue ?? '', 1, 0, 'L');
                $pdf->Cell(30, 8, $training->rt_date ?? '', 1, 0, 'C');
                $pdf->Cell(30, 8, $training->rt_no_hours ?? '', 1, 1, 'C'); // Changed from 0 to 1 to end the row
            }
        }

        $pdf->Ln(5);
    }

    /**
     * Generate experience trainer section
     */
private function generateExperienceTrainerSection($pdf, $speaker)
{
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 8, 'Training Experience as Trainer:', 0, 1, 'L');

    // Create table
    $pdf->SetFont('helvetica', '', 8);

    // Table headers - REMOVED the Remarks column
        $pdf->Cell(80, 8, 'Training Title', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Venue', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Date', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Hours', 1, 1, 'C');
    // Get experience trainer data from related table (if relationship exists)
    $experienceData = [];
    // Corrected the method name to 'experienceTrainer' to match the model's function
    if (method_exists($speaker, 'experienceTrainer') && $speaker->experienceTrainer) {
        $experienceData = $speaker->experienceTrainer;
    }

    if (empty($experienceData)) {
        // Add empty rows for manual filling - REMOVED the empty Remarks cell
        for ($i = 0; $i < 5; $i++) {
                $pdf->Cell(80, 8, '', 1, 0, 'L');
                $pdf->Cell(40, 8, '', 1, 0, 'L');
                $pdf->Cell(30, 8, '', 1, 0, 'C');
                $pdf->Cell(30, 8, '', 1, 1, 'C'); // Changed from 0 to 1 to end the row
        }
    } else {
        foreach ($experienceData as $experience) {
            // Data rows - REMOVED the Remarks cell
            $pdf->Cell(80, 8, $experience->rst_title ?? '', 1, 0, 'L');
            $pdf->Cell(40, 8, $experience->rst_venue ?? '', 1, 0, 'L');
            $pdf->Cell(30, 8, $experience->rst_date ?? '', 1, 0, 'C');
            $pdf->Cell(30, 8, $experience->rst_no_hours ?? '', 1, 1, 'C'); // Changed from 0 to 1 to end the row
        }
    }

    $pdf->Ln(5);
}
    /**
     * Generate publications section
     */
    private function generatePublicationsSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Publications:', 0, 1, 'L');

        // Create table
        $pdf->SetFont('helvetica', '', 8);

        // Table headers - REMOVED the Publisher column
        $pdf->Cell(100, 8, 'Publication Title', 1, 0, 'C'); // Increased width
        $pdf->Cell(40, 8, 'Date Published', 1, 0, 'C');    // Increased width
        $pdf->Cell(40, 8, 'Venue', 1, 1, 'C');            // Increased width

        // Get publications data from related table (if relationship exists)
        $publicationData = [];
        if (method_exists($speaker, 'publications') && $speaker->publications) {
            $publicationData = $speaker->publications;
        }

        if (empty($publicationData)) {
            // Add empty rows for manual filling - REMOVED the empty Publisher cell
            for ($i = 0; $i < 5; $i++) {
                $pdf->Cell(100, 8, '', 1, 0, 'L');
                $pdf->Cell(40, 8, '', 1, 0, 'C');
                $pdf->Cell(40, 8, '', 1, 1, 'L'); // Changed from 0 to 1 to end the row
            }
        } else {
            foreach ($publicationData as $publication) {
                // Data rows - REMOVED the Publisher cell
                $pdf->Cell(100, 8, $publication->p_title ?? '', 1, 0, 'L');
                $pdf->Cell(40, 8, $publication->p_date ?? '', 1, 0, 'C');
                $pdf->Cell(40, 8, $publication->p_venue ?? '', 1, 1, 'L'); // Changed from 0 to 1 to end the row
            }
        }

        $pdf->Ln(5);
    }

    /**
     * Generate references section
     */
    private function generateReferencesSection($pdf, $speaker)
    {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'References for Training:', 0, 1, 'L');

        // Create table
        $pdf->SetFont('helvetica', '', 8);

        // Table headers
        $pdf->Cell(50, 8, 'Name/Agency', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Address', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Contact Person', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Position', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Tel No.', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Cell No.', 1, 1, 'C');

        // Get references data from related table (if relationship exists)
        $referenceData = [];
        if (method_exists($speaker, 'referencesTrainings') && $speaker->referencesTrainings) {
            $referenceData = $speaker->referencesTrainings;
        }

        if (empty($referenceData)) {
            // Add empty rows for manual filling
            for ($i = 0; $i < 3; $i++) {
                $pdf->Cell(50, 10, '', 1, 0, 'L');
                $pdf->Cell(40, 10, '', 1, 0, 'L');
                $pdf->Cell(25, 10, '', 1, 0, 'L');
                $pdf->Cell(25, 10, '', 1, 0, 'L');
                $pdf->Cell(20, 10, '', 1, 0, 'C');
                $pdf->Cell(20, 10, '', 1, 1, 'C');
            }
        } else {
            foreach ($referenceData as $reference) {
                $pdf->Cell(50, 10, $reference->name_agency ?? '', 1, 0, 'L');
                $pdf->Cell(40, 10, $reference->address ?? '', 1, 0, 'L');
                $pdf->Cell(25, 10, $reference->contact_person ?? '', 1, 0, 'L');
                $pdf->Cell(25, 10, $reference->position ?? '', 1, 0, 'L');
                $pdf->Cell(20, 10, $reference->tel_no ?? '', 1, 0, 'C');
                $pdf->Cell(20, 10, $reference->cell_no ?? '', 1, 1, 'C');
            }
        }

        $pdf->Ln(5);
    }

    /**
     * Generate expert information section
     */
    private function generateExpertSection($pdf, $speaker)
    {
        // $pdf->SetFont('helvetica', 'B', 10);
        // $pdf->Cell(0, 8, 'E-mail Address:', 0, 1, 'L');

        // Get expert data from related table (if relationship exists)
        $expertData = [];
        if (method_exists($speaker, 'expertis') && $speaker->expertis) {
            $expertData = $speaker->expertis;
        }

        if (empty($expertData)) {
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(30, 8, 'E-mail Address::', 0, 0, 'L');
            $pdf->Cell(100, 8, $speaker->email ?? '', 'B', 1, 'L');
            $pdf->Ln(3);
        } else {
            foreach ($expertData as $expert) {
                $pdf->SetFont('helvetica', '', 10);
                $pdf->Cell(30, 8, 'Expert Field:', 0, 0, 'L');
                $pdf->Cell(100, 8, $expert->expertis ?? '', 'B', 1, 'L');
                $pdf->Ln(3);
            }
        }
    }
}
