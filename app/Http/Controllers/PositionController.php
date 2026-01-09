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

  // app/Http/Controllers/PositionController.php

// ...

// app/Http/Controllers/PositionController.php

    public function update(Request $request, $id)
    {
        // 1. Validation check
        $request->validate(['position' => 'required|string|max:255']); // Ensure 'position' is used here

        // 2. Find and update the model
        $position = Position::findOrFail($id);

        // Ensure 'position' is the key being updated
        $position->update($request->only('position'));

        return redirect()->route('positions.index')->with('success', 'Position updated successfully');
    }

        public function destroy($id)
        {
            // Use findOrFail for consistent error handling and automatic check.
            $position = Position::findOrFail($id);
            $position->delete();

            // Redirect to the index with success message
            return redirect()->route('positions.index')->with('success', 'Position deleted successfully');
        }
}
