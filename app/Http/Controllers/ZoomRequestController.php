<?php

namespace App\Http\Controllers;

use App\Models\ZoomRequest;
use App\Models\Position;
use App\Models\DivisionUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomRequestController extends Controller
{
    // All Zoom Requests (Pending only)
    public function index()
    {
        $zoom_request = ZoomRequest::with(['position', 'divisionUnit'])
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $position = Position::all();
        $division_units = DivisionUnit::all();

        // Logged-in user
        $user = Auth::user();

        return view('zoom_request.index', compact(
            'zoom_request',
            'position',
            'division_units',
            'user'
        ));
    }

    // Approved Zoom Requests
    public function approved()
    {
        $zoom_request = ZoomRequest::with(['position', 'divisionUnit'])
            ->where('status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->get();
        $position = Position::all();
        $division_units = DivisionUnit::all();

        return view('zoom_request.approved', compact('zoom_request', 'position', 'division_units'));
    }

    // Declined Zoom Requests
    public function declined()
    {
        $zoom_request = ZoomRequest::with(['position', 'divisionUnit'])
            ->where('status', 'Declined')
            ->orderBy('created_at', 'desc')
            ->get();
        $position = Position::all();
        $division_units = DivisionUnit::all();

        return view('zoom_request.declined', compact('zoom_request', 'position', 'division_units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'f_name' => 'required|string|max:100',
            'l_name' => 'required|string|max:100',
            'm_name' => 'nullable|string|max:100',
            'topic' => 'required|string|max:1000',
            'no_of_participants' => 'required|integer',
            'id_position' => 'nullable|exists:position,id',
            'id_division_unit' => 'nullable|exists:division_unit,id',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date',
            'end_time' => 'required',
            'status' => 'nullable|in:Pending,Approved,Declined',
        ]);

        $validated['status'] = $validated['status'] ?? 'Pending';

        ZoomRequest::create($validated);

        return redirect()->back()->with('success', 'Zoom Request created successfully!');
    }

    public function update(Request $request, ZoomRequest $zoomRequest)
    {
        $validated = $request->validate([
            'f_name' => 'required|string|max:100',
            'l_name' => 'required|string|max:100',
            'm_name' => 'nullable|string|max:100',
            'topic' => 'required|string|max:1000',
            'no_of_participants' => 'required|integer',
            'id_position' => 'nullable|exists:position,id',
            'id_division_unit' => 'nullable|exists:division_unit,id',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date',
            'end_time' => 'required',
        ]);

        $zoomRequest->update($validated);

        return redirect()->back()->with('success', 'Zoom Request updated successfully!');
    }

    public function destroy(ZoomRequest $zoomRequest)
    {
        $zoomRequest->delete();
        return redirect()->back()->with('success', 'Zoom Request deleted successfully!');
    }

    public function updateStatus(Request $request, ZoomRequest $zoomRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Approved,Declined',
        ]);

        $zoomRequest->update($validated);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}
