<?php

namespace App\Http\Controllers;

use App\Models\Unit; // Changed from Province to Unit
use Illuminate\Http\Request;
use DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all(); // Fetch all units
        return view('units.index', compact('units')); // Update view path to 'units.index'
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('units.create'); // Update view path to 'units.create'
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate(['unit' => 'required']); // Change 'province' to 'unit'

        // Get unit input from the request
        $unit = $request->input('unit');

        // Insert the unit into the database
        DB::table('units')->insert([
            'unit' => $unit,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Unit added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validate the input
        $request->validate([
            'unit' => 'required|string|max:255', // Added string and max length for better security
        ]);

        // 2. Find the unit and update its name
        $unit = Unit::findOrFail($id);

        // Use the request data directly; no need for request->only('unit')
        // since 'unit' is the only field you care about here
        $unit->unit = $request->unit;
        $unit->save(); // Save the changes to the database

        // 3. Redirect with success message
        return redirect()->route('units.index')->with('success', 'Unit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

// app/Http/Controllers/UnitController.php

// ...

public function destroy($id)
{
    // Find the record by ID (findOrFail handles 404 if not found)
    $unit = Unit::findOrFail($id);

    // Delete the record
    $unit->delete();

    // Redirect back to the previous page (or 'units.index') with a success message
    return redirect()->back()->with('success', 'Unit deleted successfully.');
}
}
