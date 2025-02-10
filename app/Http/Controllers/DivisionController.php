<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::all();
        return view('divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('divisions.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate(['division' => 'required']);

        // Get division input from the request
        $division = $request->input('division');

        // Insert the division into the database
        DB::table('divisions')->insert([
            'division' => $division,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Division added successfully');
    }

    public function edit($id)
    {
        $division = Division::findOrFail($id);
        return view('divisions.edit', compact('division'));
    }


    public function update(Request $request, $id)
    {
        $request->validate(['division' => 'required']);

        $division = Division::findOrFail($id); // findOrFail for better error handling
        $division->update($request->only('division')); // Only update 'division' field

        return redirect()->route('divisions.index')->with('success', 'Division updated successfully');
    }

    public function destroy($id)
    {
        $division = Division::find($id);

        // Check if division exists
        if ($division) {
            $division->delete();
        }

        // Redirect back to the index route
        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully');
    }


}
