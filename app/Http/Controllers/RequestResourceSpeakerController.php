<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestResourceSpeaker; // Changed from Province to Unit
use App\Models\Rstbl;
use App\Models\Accreditation;
use App\Models\Division;
use DB;

class RequestResourceSpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    // Eager load speaker and speaker.accreditation
        $requests = RequestResourceSpeaker::with([
            'speaker.accreditation'  // Include accreditation data
        ])->get();
        $speakers = Rstbl::with('office')->get(); // ✅ include related office data
        $divisions = Division::orderBy('division')->pluck('division', 'id');


        return view('training.index', compact('requests', 'speakers', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    $speakers = Rstbl::with('office')->get();
    return view('training.create', compact('speakers'));
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rstbl_id'         => 'required|exists:rstbl,id',
            'gender'           => 'required|string|max:20',
            'agency'           => 'required|string|max:191',
            'division'         => 'required|string|max:191',
            'training_directory' => 'nullable|string|max:191',
            'training_title'   => 'required|string|max:191',
            'venue'            => 'required|string|max:191',
            'date'             => 'required|date',
            'no_hours'         => 'nullable|integer',
            'no_participants'  => 'nullable|integer',
            'file'             => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,png'
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('uploads', 'public');
        }

        RequestResourceSpeaker::create($validated);

        return redirect()->route('training.index')->with('success', 'Request submitted successfully.');
    }


    // Accred
            public function add(Request $request)
        {
            $validated = $request->validate([
                'rstbl_id' => 'required|exists:rstbl,id',
                'field_of_expertise' => 'nullable|string|max:255',
                'education' => 'nullable|string|max:255',
                'work' => 'nullable|string|max:255',
                'seminar' => 'nullable|string|max:255',
                'experience' => 'nullable|string|max:255',
                'award' => 'nullable|string|max:255',
                'total' => 'nullable|string|max:255',
            ]);

            Accreditation::create($validated);

            return redirect()->route('training.index')->with('success', 'Accreditation submitted successfully!');
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

            $request = RequestResourceSpeaker::findOrFail($id);

            $speakers = DB::table('rstbl')
                ->leftJoin('office', 'rstbl.id', '=', 'office.rs_id')
                ->select(
                    'rstbl.id',
                    'rstbl.given_name',
                    'rstbl.last_name',
                    'rstbl.gender',
                    'office.office_organization as agency'
                )
            ->get();
            $divisions = Division::orderBy('division')->pluck('division', 'id'); // key => value


            return view('training.update', compact('request', 'speakers', 'divisions'));
        }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    $validated = $request->validate([
        'rstbl_id'         => 'required|exists:rstbl,id',
        'gender'           => 'required|string|max:20',
        'agency'           => 'required|string|max:191',
        'division'         => 'required|string|max:191',
        'training_title'   => 'required|string|max:191',
        'venue'            => 'required|string|max:191',
        'date'             => 'required|date',
        'no_hours'         => 'nullable|integer',
        'no_participants'  => 'nullable|integer',
        'file'             => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,png'
    ]);

    $requestResourceSpeaker = RequestResourceSpeaker::findOrFail($id);

    if ($request->hasFile('file')) {
        $validated['file'] = $request->file('file')->store('uploads', 'public');
    }

    $requestResourceSpeaker->update($validated);

    return redirect()->route('training.index')->with('success', 'Request updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request = RequestResourceSpeaker::findOrFail($id);

        $request->delete();

        return redirect()->back()->with('success', 'Accreditation deleted successfully.');
    }
}
