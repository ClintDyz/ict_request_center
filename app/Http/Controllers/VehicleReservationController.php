<?php

namespace App\Http\Controllers;

use App\Models\VehicleReservation;
use App\Models\Position;
use App\Models\DivisionUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleReservationController extends Controller
{
    // Show all reservations
    public function index()
    {
        $reservations = VehicleReservation::orderByDesc('created_at')->get();
        $position = Position::orderBy('position')->get();
        $division_units = DivisionUnit::orderBy('division_unit')->get();

        return view('vehicle_reservations.index', compact('reservations', 'position', 'division_units'));
    }

    // Store new reservation
    public function store(Request $request)
    {
        $request->validate([
            'requestors' => 'required|array|min:1',
            'requestors.*.l_name' => 'required|string|max:100',
            'requestors.*.f_name' => 'required|string|max:100',
            'requestors.*.m_name' => 'nullable|string|max:100',
            'requestors.*.id_position' => 'required|integer',
            'requestors.*.id_division_unit' => 'required|integer',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'nullable',
            'return_date' => 'nullable|date',
            'return_time' => 'nullable',
            'vehicle_name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:50',
            'driver_name' => 'required|string|max:255',
            'purpose' => 'required|string',
            'status' => 'required|in:Pending,Approved,Declined',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Get first requestor data
        $firstRequestor = $request->requestors[0];

        // Prepare data for saving
        $data = [
            'requestors' => $request->requestors, // Store all requestors as JSON
            'l_name' => $firstRequestor['l_name'],
            'f_name' => $firstRequestor['f_name'],
            'm_name' => $firstRequestor['m_name'] ?? null,
            'id_position' => $firstRequestor['id_position'],
            'id_division_unit' => $firstRequestor['id_division_unit'],
            'destination' => $request->destination,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'return_date' => $request->return_date,
            'return_time' => $request->return_time,
            'vehicle_name' => $request->vehicle_name,
            'plate_number' => $request->plate_number,
            'driver_name' => $request->driver_name,
            'purpose' => $request->purpose,
            'status' => $request->status,
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('vehicle_reservations', $filename, 'public');
            $data['attachment'] = $path;
        }

        VehicleReservation::create($data);

        return back()->with('success', '✅ Vehicle reservation submitted successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'requestors' => 'required|array|min:1',
            'requestors.*.l_name' => 'required|string|max:100',
            'requestors.*.f_name' => 'required|string|max:100',
            'requestors.*.m_name' => 'nullable|string|max:100',
            'requestors.*.id_position' => 'required|integer',
            'requestors.*.id_division_unit' => 'required|integer',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'nullable',
            'return_date' => 'nullable|date',
            'return_time' => 'nullable',
            'vehicle_name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:50',
            'driver_name' => 'required|string|max:255',
            'purpose' => 'required|string',
            'status' => 'required|in:Pending,Approved,Declined',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $reservation = VehicleReservation::findOrFail($id);

        // Get first requestor
        $firstRequestor = $request->requestors[0];

        $data = [
            'requestors' => $request->requestors, // Store all requestors
            'l_name' => $firstRequestor['l_name'],
            'f_name' => $firstRequestor['f_name'],
            'm_name' => $firstRequestor['m_name'] ?? null,
            'id_position' => $firstRequestor['id_position'],
            'id_division_unit' => $firstRequestor['id_division_unit'],
            'destination' => $request->destination,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'return_date' => $request->return_date,
            'return_time' => $request->return_time,
            'vehicle_name' => $request->vehicle_name,
            'plate_number' => $request->plate_number,
            'driver_name' => $request->driver_name,
            'purpose' => $request->purpose,
            'status' => $request->status,
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($reservation->attachment && Storage::disk('public')->exists($reservation->attachment)) {
                Storage::disk('public')->delete($reservation->attachment);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('vehicle_reservations', $filename, 'public');
            $data['attachment'] = $path;
        }

        $reservation->update($data);
        return back()->with('success', '✅ Reservation updated successfully!');
    }

    // Update reservation status (Approved/Declined)
    public function updateStatus($id, $status)
    {
        $reservation = VehicleReservation::findOrFail($id);
        $reservation->update(['status' => $status]);
        return back()->with('success', "✅ Reservation {$status} successfully!");
    }

    // Delete reservation
    public function destroy($id)
    {
        $reservation = VehicleReservation::findOrFail($id);

        // Delete file if exists
        if ($reservation->attachment && Storage::disk('public')->exists($reservation->attachment)) {
            Storage::disk('public')->delete($reservation->attachment);
        }

        $reservation->delete();
        return back()->with('success', '🗑️ Reservation deleted successfully!');
    }

}
