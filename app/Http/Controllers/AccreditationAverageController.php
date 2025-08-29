<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AccreditationPDFService;
use App\Models\RequestResourceSpeaker;
use App\Models\Rstbl;
use App\Models\Accreditation;
use App\Models\Expertis;
use App\Models\AccreditationAverage;   // ✅ add this
use Illuminate\Support\Facades\Schema;  // Add this import
use Illuminate\Support\Facades\Log;     // Add this import
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use TCPDF;

class AccreditationAverageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
        {

                    $accredited = AccreditationAverage::with(['speaker.expertises'])->get();

                    return view('accreditation_average.index', compact('accredited'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\AccreditationAverage  $accreditationAverage
     * @return \Illuminate\Http\Response
     */
    public function show(AccreditationAverage $accreditationAverage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccreditationAverage  $accreditationAverage
     * @return \Illuminate\Http\Response
     */
    public function edit(AccreditationAverage $accreditationAverage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccreditationAverage  $accreditationAverage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccreditationAverage $accreditationAverage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccreditationAverage  $accreditationAverage
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccreditationAverage $accreditationAverage)
    {
        //
    }
}
