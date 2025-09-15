<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rstbl; // Add this at the top
use App\Models\Accreditation; // Assuming you have an Accreditation model
use App\Models\AccreditationAverage; // Assuming you have an Accreditation model


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $resourceSpeakerCount = Rstbl::count();
        $maleCount = Rstbl::where('gender', 'Male')->count();
        $femaleCount = Rstbl::where('gender', 'Female')->count();

        // Get counts based on accreditation status
        $toBeAccreditedCount = Accreditation::where('status', 0)->count();

        // Count 'Accredited' from the 'accreditations' table where status is 1 (or accredited)
        $accreditedCount = AccreditationAverage::count();

        // Pass the new counts to the view
        return view('home', compact(
            'resourceSpeakerCount',
            'maleCount',
            'femaleCount',
            'toBeAccreditedCount',
            'accreditedCount'
        ));
    }

}
