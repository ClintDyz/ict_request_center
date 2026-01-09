<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::all();
        return view('provinces.index', compact('provinces'));
    }

    public function create()
    {
        return view('provinces.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate(['province' => 'required']);

        // Get province input from the request
        $province = $request->input('province');

        // Insert the province into the database
        DB::table('provinces')->insert([
            'province' => $province,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Province added successfully');
    }

    public function edit($id)
    {
        $province = Province::findOrFail($id);
        return view('provinces.edit', compact('province'));
    }

    public function update(Request $request, $id)
    {
        // Ensure you validate the input
        $request->validate(['province' => 'required|string|max:255']);

        // Use findOrFail for consistent error handling
        $province = Province::findOrFail($id);

        // Update the record
        $province->update($request->only('province'));

        return redirect()->route('provinces.index')->with('success', 'Province updated successfully');
    }

    public function destroy($id)
    {
        // Use findOrFail for consistent error handling; it automatically deletes if found.
        $province = Province::findOrFail($id);

        $province->delete();

        // Redirect back to the index route
        return redirect()->route('provinces.index')->with('success', 'Province deleted successfully');
    }
}
