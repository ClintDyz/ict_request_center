<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use DB;
class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all(); // Fetch all positions
        return view('positions.index', compact('positions')); // Pass to view
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate(['position' => 'required']);

        // Get division input from the request
        $position = $request->input('position');

        // Insert the division into the database
        DB::table('positions')->insert([
            'position' => $position,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Position added successfully');
    }
    public function edit($id)
    {
        // Find position by ID or fail
        $positions = Position::findOrFail($id);
        return view('positions.edit', compact('positions')); // Pass to edit view
    }

    public function update(Request $request, $id)
    {
        // Validate the updated data
        $request->validate(['position' => 'required']);

        // Find position by ID and update
        $position = Position::findOrFail($id);
        $position->update($request->only('position')); // Only update 'name' field

        // Redirect back with success message
        return redirect()->route('positions.index')->with('success', 'Position updated successfully');
    }

    public function destroy($id)
    {
        // Find position by ID
        $position = Position::find($id);

        // Check if position exists, then delete
        if ($position) {
            $position->delete();
        }

        // Redirect to the index with success message
        return redirect()->route('positions.index')->with('success', 'Position deleted successfully');
    }
}
