<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rstbl; // Model for rstbl
use App\Models\RsEducational; // Model for education
use App\Models\RsWorkExperience; // Model for work experience
use App\Models\RsTraining; // Model for training
use App\Models\RsExperienceTrainer; // Model for experience as trainer
use App\Models\RsReferencesTraining; // Model for references
use App\Models\RsPublication; // Model for publications
use App\Models\Office; // Model for office details
use Illuminate\Support\Facades\Log;


class RstblController extends Controller
{
    public function index()
    {
        $speakers = Rstbl::all();
        return view('resource_speaker.index', compact('speakers'));
    }

    public function create()
    {
        // dd($request->all());

        return view('resource_speaker.create');
    }

    public function store(Request $request)
    {

   // Use a transaction to ensure atomicity
   DB::transaction(function () use ($request) {
    // Create Personal Info (Rstbl)

        // dd($request->all());
// Check if email already exists
$existingRecord = Rstbl::where('email', $request->email)->first();


if ($existingRecord) {
    return redirect()->back()->with('error', 'The email address is already in use.');
}

    $rstbl = Rstbl::create([
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
        'home_building_no' => $request->home_building_no,
        'home_barangay' => $request->home_barangay,
        'home_municipality' => $request->home_municipality,
        'home_province' => $request->home_province,
        'home_zip_code' => $request->home_zip_code,
        'home_tel_no' => $request->home_tel_no,
        'home_cell_no' => $request->home_cell_no,
        'home_fax_no' => $request->home_fax_no,
    ]);

    // Create Office Info
    $rstbl->office()->create([
        'office_organization' => $request->office_organization,
        'position' => $request->position,
        'address' => $request->office_address,
        'building_no' => $request->office_building_no,
        'barangay' => $request->barangay,
        'municipality' => $request->municipality,
        'province' => $request->province,
        'zip_code' => $request->zip_code,
        'tel_no' => $request->tel_no,
        'cell_no' => $request->cell_no,
        'fax_no' => $request->fax_no,
    ]);

    $rstbl->educationalBackground()->create([
        'level' => $request->level,
        'school' => $request->school,
        'from_year' => $request->from_year,
        'to_year' => $request->to_year,
        'year_graduated' => $request->year_graduated,
        'awards' => $request->awards,
    ]);

    // Create Work Experience
    $rstbl->workExperiences()->create([
        'name_company' => $request->name_company,
        'date_started' => $request->date_started,
        'date_ended' => $request->date_ended,
        'division' => $request->division,
        'position' => $request->position,
    ]);


// Create References Training
$rstbl->referencesTrainings()->create([
    'title' => $request->title,
    'date_venue' => $request->date_venue,
    'no_hours' => $request->no_hours,
]);


    // Create Trainer Experience
    $rstbl->experienceTrainer()->create([
        'title' => $request->trainer_title,
        'date_venue' => $request->trainer_date_venue,
        'no_hours' => $request->trainer_no_hours,
    ]);

    // Create References
    $rstbl->referencesTrainings()->create([
        'name_agency' => $request->name_agency,
        'address' => $request->address,
        'contact_person' => $request->contact_person,
        'position' => $request->position,
        'tel_no' => $request->tel_no,
        'cell_no' => $request->cell_no,
        'fax_no' => $request->fax_no,
    ]);


    // Create Publications
    $rstbl->publications()->create([
        'title' => $request->publication_title,
        'nature' => $request->nature,
        'date_venue' => $request->date_venue,
    ]);
});

// Redirect back with success message
// return redirect()->route('resource_speaker.index')->with('success', 'Resource Speaker added successfully!');
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
                    'home_building_no' => $request->home_building_no,
                    'home_barangay' => $request->home_barangay,
                    'home_municipality' => $request->home_municipality,
                    'home_province' => $request->home_province,
                    'home_zip_code' => $request->home_zip_code,
                    'home_tel_no' => $request->home_tel_no,
                    'home_cell_no' => $request->home_cell_no,
                    'home_fax_no' => $request->home_fax_no,
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

                // Update or create Educational Background
                $rstbl->educationalBackground()->updateOrCreate(
                    ['rs_id' => $rstbl->id],
                    [
                        'level' => $request->level,
                        'school' => $request->school,
                        'from_year' => $request->from_year, // Extract the year
                        'to_year' => $request->to_year, // Optional field
                        'year_graduated' => $request->year_graduated,
                        'awards' => $request->awards,
                    ]
                );

                // Update or create Work Experience
                $rstbl->workExperiences()->updateOrCreate(
                    ['rs_id' => $rstbl->id],
                    [
                        'name_company' => $request->name_company,
                        'date_started' => $request->date_started,
                        'date_ended' => $request->date_ended,
                        'division' => $request->division,
                        'position' => $request->position,
                    ]
                );

                // Update or create Trainer Experience
                $rstbl->experienceTrainer()->updateOrCreate(
                    ['rs_id' => $rstbl->id],
                    [
                        'title' => $request->trainer_title,
                        'date_venue' => $request->trainer_date_venue,
                        'no_hours' => $request->trainer_no_hours,
                    ]
                );

                // Update or create References
                $rstbl->referencesTrainings()->updateOrCreate(
                    ['rs_id' => $rstbl->id],
                    [
                        'name_agency' => $request->name_agency,
                        'address' => $request->address,
                        'contact_person' => $request->contact_person,
                        'position' => $request->position,
                        'tel_no' => $request->tel_no,
                        'cell_no' => $request->cell_no,
                        'fax_no' => $request->fax_no,
                    ]
                );

                // Update or create Publications
                $rstbl->publications()->updateOrCreate(
                    ['rs_id' => $rstbl->id],
                    [
                        'title' => $request->publication_title,
                        'nature' => $request->nature,
                        'date_venue' => $request->date_venue,
                    ]
                );
            });

            // Redirect back with success message
            return redirect()->route('resource_speaker.index')->with('edit', 'med_form');

        }

        public function destroy($id)
{
    try {
        // Find the record by ID
        $rstbl = Rstbl::findOrFail($id);

        // Delete the record
        $rstbl->delete();

        // Redirect with success message
        // return redirect()->route('resource_speaker.index')->with('success', 'Resource Speaker deleted successfully!');
        return redirect()->route('resource_speaker.index')->with('delete', 'med_form');

    } catch (\Exception $e) {
        // Handle errors (e.g., record not found)
        return redirect()->route('resource_speaker.index')->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

}
