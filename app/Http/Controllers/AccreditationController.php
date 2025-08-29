<?php

namespace App\Http\Controllers;

use App\Services\AccreditationPDFService;
use App\Models\RequestResourceSpeaker;
use App\Models\Rstbl;
use App\Models\Accreditation;
use App\Models\Expertis;
use App\Models\AccreditationAverage;   // ✅ add this
use Illuminate\Support\Facades\Schema;  // Add this import
use Illuminate\Support\Facades\Log;     // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use TCPDF;

class AccreditationController extends Controller
{
        public function index()
        {
            $requests = RequestResourceSpeaker::with('speaker')->get();

            // Load speakers with both office and expertis relationships
            $speakers = Rstbl::with(['office', 'expertises'])->get();

            // Load accreditations with speaker relationship
            $trainers = Accreditation::with('speaker')->get();

            return view('accreditation.index', compact('trainers', 'requests', 'speakers'));
        }


    public function create(Request $request)
    {

            // dd($request->all());

        $validated = $request->validate([
            'rstbl_id' => 'required|exists:rstbl,id',
            'field_of_expertise' => 'required|string|max:255',
            'education' => 'nullable|numeric',
            'work' => 'nullable|numeric',
            'seminar' => 'nullable|numeric',
            'experience' => 'nullable|numeric',
            'award' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'status' => 'required|string|max:255',

        ]);

            $validated['created_by'] = Auth::id(); // ✅ Assign outside validation

        Accreditation::create($validated);

        return redirect()->back()->with('success', 'Accreditation created successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accreditation = Accreditation::findOrFail($id);
        $requests = RequestResourceSpeaker::with('speaker')->get();
        $speakers = Rstbl::all();

        return view('accreditation.update', compact('accreditation', 'requests', 'speakers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'rstbl_id' => 'required|exists:rstbl,id',
            'field_of_expertise' => 'required|string|max:255',
            'training_title_rs' => 'nullable|string|max:255',
            'education' => 'nullable|numeric',
            'work' => 'nullable|string|max:255',
            'seminar' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'award' => 'nullable|string|max:255',
            'total' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',

        ]);
            $validated['updated_by'] = auth()->id(); // ✅ Add here instead

        $accreditation = Accreditation::findOrFail($id);
        $accreditation->update($validated);

        return redirect()->route('accreditation.index')->with('success', 'Accreditation updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accreditation = Accreditation::findOrFail($id);
        $accreditation->delete();

        return redirect()->back()->with('success', 'Accreditation deleted successfully.');
    }

        public function print(RequestResourceSpeaker $trainer)
    {

     $trainer -> load (['speaker', 'accreditation']);

     if (!$trainer) {
        return redirect()->back()->with('error', 'Not Found');

     }
        return $this->accreditationPDFService->generatePDF($trainer);
    }


    public function printPDF($trainerId)
    {
        $trainer = DB::table('accreditations as a')
            ->leftJoin('rstbl as r', 'a.rstbl_id', '=', 'r.id') // Join the correct table
            ->select(
                'a.id',
                DB::raw("CONCAT(r.given_name, ' ', r.last_name) AS applicant_name"),
                'r.expertise',
                'a.education',
                'a.work',
                'a.seminar',
                'a.experience',
                'a.award',
                'a.total'
            )
            ->where('a.id', $trainerId)
            ->first();
   $trainer = Accreditation::with(['speaker.expertises'])
        ->where('id', $trainerId)
        ->first();

    if (!$trainer) {
        return redirect()->back()->with('error', 'Trainer not found.');
    }

    // Gather data
    $applicantName = strtoupper($trainer->speaker->given_name . ' ' . $trainer->speaker->last_name);
    $expertiseList = optional($trainer->speaker->expertises)->pluck('expertis')->implode(', ');

    if (!$trainer) {
        return redirect()->back()->with('error', 'Trainer not found.');
    }

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 8, 'CRITERIA FOR ACCREDITATION OF TRAINERS/', 0, 1, 'C');
    $pdf->Cell(0, 8, 'RESOURCE SPEAKERS/SUBJECT MATTER', 0, 1, 'C');
    $pdf->Cell(0, 8, 'SPECIALISTS', 0, 1, 'C');
    $pdf->Ln(8);

    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(35, 6, 'Name of Applicant:', 0, 0, 'L');
    // $pdf->Cell(0, 6, strtoupper($trainer->applicant_name), 0, 1, 'L');
    $pdf->Cell(0, 6, $applicantName, 0, 1, 'L');
    $pdf->Cell(35, 6, 'Field of Expertise:', 0, 0, 'L');
    $pdf->MultiCell(0, 6, strtoupper($expertiseList), 0, 'L');
    // $pdf->MultiCell(0, 6, strtoupper($trainer->expertisespeaker->expertises->pluck('expertis')->implode(', ')), 0, 'L');
    $pdf->Ln(8);
    $criteria = [
        [
            'title' => '1.0    Relevant Educational Qualifications – 30 points',
            'max_points' => 30,
            'actual_points' => number_format($trainer->education ?? 0, 2),
            'items' => [
                ['Technical Vocational Course', '15'],
                ['Bachelor\'s Degree', '20'],
                ['Master\'s Degree', '25'],
                ['Doctorate Degree', '30']
            ]
        ],
        [
            'title' => '2.0    Relevant Work Experience – 30 points',
            'subtitle' => 'As Industry Practitioner Technical Specialist',
            'max_points' => 30,
            'actual_points' => number_format($trainer->work ?? 0, 2),
            'items' => [
                ['At least two (2) years', '20'],
                ['Three (3) to five (5) years', '25'],
                ['More than five (5) years', '30']
            ]
        ],
        [
            'title' => '3.0    Relevant Trainings/Seminars Attended – 20 points',
            'max_points' => 20,
            'actual_points' => number_format($trainer->seminar ?? 0, 2),
            'items' => [
                ['40 – 80 hours', '10'],
                ['81 – 120 hours', '15'],
                ['121 hours and above', '20']
            ]
        ],
        [
            'title' => '4.0    Experience As Trainer/ Resource Person – 10 points',
            'max_points' => 10,
            'actual_points' => number_format($trainer->experience ?? 0, 2),
            'items' => [
                ['Conducted technology training lecture for at least 30', '10'],
                ['hours or recognized as trainer by relevant institutions', ''],
                ['on specific subject matter', '5']
            ]
        ],
        [
            'title' => '5.0    Relevant Technical Merits – 10 points',
            'max_points' => 10,
            'actual_points' => number_format($trainer->award ?? 0, 2),
            'items' => [
                ['National Recognitions/ Awards/ Publications', '10'],
                ['Local Recognitions/ Awards/ Publications', '5']
            ]
        ]
    ];

    foreach ($criteria as $section) {
        $this->addCriteriaSection($pdf, $section);
    }

    // Total
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(60, 8, 'TOTAL', 0, 0, 'L');
    $pdf->Cell(80, 8, '100 points', 0, 0, 'R');
    $pdf->Cell(40, 8, number_format($trainer->total ?? 0, 2), 0, 1, 'R');

    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(0, 5, '    Note: Standard Passing Score is 75 points.', 0, 1, 'L');
    $pdf->Ln(5);

    $this->addSignatureSection($pdf);

    $filename = 'accreditation_form_' . $trainer->id . '.pdf';
    return $pdf->Output($filename, 'I');
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



    public function approve(Request $request)
    {
        try {
            // Log the incoming request
            Log::info('Approve method called', $request->all());

            $ids = $request->input('ids', []);

            if (!is_array($ids) || empty($ids)) {
                return response()->json(['message' => 'No rows selected'], 422);
            }

            return DB::transaction(function () use ($ids) {

                // Step 1: Check if records exist
                $records = DB::table('accreditations')
                    ->whereIn('id', $ids)
                    ->get();

                if ($records->isEmpty()) {
                    return response()->json(['message' => 'No matching records found'], 404);
                }

                Log::info('Found records', ['count' => $records->count()]);

                // Step 2: Update status to 1
                $updated = DB::table('accreditations')
                    ->whereIn('id', $ids)
                    ->update(['status' => 1]);

                Log::info('Updated status', ['updated_count' => $updated]);

                // Step 3: Group by rstbl_id and calculate averages
                $averages = DB::table('accreditations')
                    ->whereIn('id', $ids)
                    ->select('rstbl_id')
                    ->selectRaw('
                        ROUND(AVG(education), 2) as avg_education,
                        ROUND(AVG(work), 2) as avg_work,
                        ROUND(AVG(seminar), 2) as avg_seminar,
                        ROUND(AVG(experience), 2) as avg_experience,
                        ROUND(AVG(award), 2) as avg_award,
                        ROUND(AVG(total), 2) as avg_total,
                        COUNT(*) as record_count
                    ')
                    ->groupBy('rstbl_id')
                    ->get();

                Log::info('Calculated averages', ['averages' => $averages]);

                // Step 4: Try to create accreditation_averages table if it doesn't exist
                $this->ensureAveragesTableExists();

                // Step 5: Save averages (with duplicate prevention)
                $savedCount = 0;
                foreach ($averages as $avg) {
                    try {
                        // Check if record already exists
                        $exists = DB::table('accreditation_averages')
                            ->where('rstbl_id', $avg->rstbl_id)
                            ->exists();

                        if (!$exists) {
                            DB::table('accreditation_averages')->insert([
                                'rstbl_id' => $avg->rstbl_id,
                                'field_of_expertise' => $avg->rstbl_id,
                                'avg_education' => $avg->avg_education,
                                'avg_work' => $avg->avg_work,
                                'avg_seminar' => $avg->avg_seminar,
                                'avg_experience' => $avg->avg_experience,
                                'avg_award' => $avg->avg_award,
                                'avg_total' => $avg->avg_total,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            $savedCount++;
                        } else {
                            Log::info("Skipped rstbl_id {$avg->rstbl_id} - already exists");
                        }
                    } catch (\Exception $e) {
                        Log::error("Error saving average for rstbl_id {$avg->rstbl_id}: " . $e->getMessage());
                    }
                }

                // Step 6: Calculate overall averages for response
                $overallAvg = [
                    'education' => round($averages->avg('avg_education'), 2),
                    'work' => round($averages->avg('avg_work'), 2),
                    'seminar' => round($averages->avg('avg_seminar'), 2),
                    'experience' => round($averages->avg('avg_experience'), 2),
                    'award' => round($averages->avg('avg_award'), 2),
                    'total' => round($averages->avg('avg_total'), 2),
                ];

                return response()->json([
                    'success' => true,
                    'message' => "Successfully processed {$updated} records and saved {$savedCount} averages.",
                    'data' => [
                        'updated_count' => $updated,
                        'unique_speakers' => $savedCount,
                        'overall_averages' => $overallAvg,
                        'speaker_details' => $averages->map(function($avg) {
                            return [
                                'rstbl_id' => $avg->rstbl_id,
                                'averages' => [
                                    'education' => $avg->avg_education,
                                    'work' => $avg->avg_work,
                                    'seminar' => $avg->avg_seminar,
                                    'experience' => $avg->avg_experience,
                                    'award' => $avg->avg_award,
                                    'total' => $avg->avg_total,
                                ],
                                'record_count' => $avg->record_count
                            ];
                        })
                    ]
                ]);
            });

        } catch (\Exception $e) {
            Log::error('Error in approve method', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                'debug_info' => config('app.debug') ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ], 500);
        }
    }

    private function ensureAveragesTableExists()
    {
        try {
            if (!Schema::hasTable('accreditation_averages')) {
                Schema::create('accreditation_averages', function ($table) {
                    $table->id();
                    $table->unsignedBigInteger('rstbl_id');
                    $table->decimal('avg_education', 8, 2)->default(0);
                    $table->decimal('avg_work', 8, 2)->default(0);
                    $table->decimal('avg_seminar', 8, 2)->default(0);
                    $table->decimal('avg_experience', 8, 2)->default(0);
                    $table->decimal('avg_award', 8, 2)->default(0);
                    $table->decimal('avg_total', 8, 2)->default(0);
                    $table->timestamps();
                });
                Log::info('Created accreditation_averages table');
            }
        } catch (\Exception $e) {
            Log::error('Error creating table: ' . $e->getMessage());
        }
    }

}
