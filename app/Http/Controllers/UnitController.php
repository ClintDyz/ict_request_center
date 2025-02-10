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
        $unit = Unit::findOrFail($id); // Fetch the unit by ID
        return view('units.edit', compact('unit')); // Update view path to 'units.edit'
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
        // Validate the input
        $request->validate(['unit' => 'required']); // Change 'province' to 'unit'

        // Find the unit and update its name
        $unit = Unit::findOrFail($id);
        $unit->update($request->only('unit')); // Update only the 'unit' field

        return redirect()->route('units.index')->with('success', 'Unit updated successfully'); // Redirect to unit index
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::find($id); // Find the unit by ID

        // Check if unit exists
        if ($unit) {
            $unit->delete(); // Delete the unit
        }

        // Redirect back to the index route
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully');
    }
}
