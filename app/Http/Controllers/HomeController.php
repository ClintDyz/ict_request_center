<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rstbl; // Add this at the top

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

        return view('home', compact('resourceSpeakerCount','maleCount', 'femaleCount'));
    }
}
