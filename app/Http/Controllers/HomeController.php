<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rstbl;
use App\Models\Accreditation;
use App\Models\AccreditationAverage;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Total speakers
        $resourceSpeakerCount = Rstbl::count();

        // Gender counts
        $maleCount = Rstbl::where('gender', 'Male')->count();
        $femaleCount = Rstbl::where('gender', 'Female')->count();

        // Pull only non-null date_of_birth values to avoid parsing errors
        $dobCollection = Rstbl::whereNotNull('date_of_birth')
            ->pluck('date_of_birth'); // Collection of strings

        // Map to ages safely (skip invalid dates)
        $ages = $dobCollection->map(function ($dob) {
            try {
                // If dob is blank or invalid, Carbon::parse will throw
                if (empty($dob)) {
                    return null;
                }
                return Carbon::parse($dob)->age;
            } catch (\Exception $e) {
                // Skip invalid values
                return null;
            }
        })->filter() // remove null / falsy values
          ->values(); // reset keys

        // Age brackets (use classic closures for compatibility)
        $age_18_25   = $ages->filter(function ($age) { return $age >= 18 && $age <= 25; })->count();
        $age_26_35   = $ages->filter(function ($age) { return $age >= 26 && $age <= 35; })->count();
        $age_36_45   = $ages->filter(function ($age) { return $age >= 36 && $age <= 45; })->count();
        $age_46_60   = $ages->filter(function ($age) { return $age >= 46 && $age <= 60; })->count();
        $age_60_plus = $ages->filter(function ($age) { return $age >= 61; })->count();

        // Accreditation status stored on Rstbl (enum field)
        $pendingCount    = Rstbl::where('status', 'Pending')->count();
        $approvedCount   = Rstbl::where('status', 'Approved')->count();
        $accreditedCount = Rstbl::where('status', 'Accredited')->count();

        return view('home', compact(
            'resourceSpeakerCount',
            'maleCount',
            'femaleCount',
            'pendingCount',
            'approvedCount',
            'accreditedCount',
            // ages
            'age_18_25',
            'age_26_35',
            'age_36_45',
            'age_46_60',
            'age_60_plus'
        ));
    }
}
