<?php

namespace App\Http\Controllers;

use App\Models\DivisionUnit;
use Illuminate\Http\Request;
use App\Models\ZoomRequest;
use App\Models\VehicleReservation;
use App\Models\IDRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DivisionUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = DivisionUnit::all();
        return view('division_unit.index', compact('units'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $request->validate([
            'division_unit' => 'required|string|max:255',
        ]);

        DivisionUnit::create(['division_unit' => $request->division_unit]);

        return redirect()->back()->with('success', 'Unit created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DivisionUnit  $divisionUnit
     * @return \Illuminate\Http\Response
     */
 public function show()
{
    $today = Carbon::today()->toDateString();

    // ====== Meetings for Today (include spanning meetings) ======
    $todayMeetings = ZoomRequest::where(function ($q) use ($today) {
            $q->whereDate('start_date', $today)
              ->orWhereDate('end_date', $today)
              ->orWhere(function ($q2) use ($today) {
                  $q2->whereDate('start_date', '<', $today)
                     ->whereDate('end_date', '>', $today);
              });
        })
        ->orderBy('start_time')
        ->paginate(10);

    // ====== ZOOM REPORT ======
    $zoom_totalRequests = ZoomRequest::count();
    $zoom_latestRequest = ZoomRequest::latest('created_at')->first();

    $zoom_mostActiveDivision = ZoomRequest::join('division_unit', 'zoom_request.id_division_unit', '=', 'division_unit.id')
        ->select('division_unit.division_unit as division_name', DB::raw('COUNT(*) as count'))
        ->groupBy('division_unit.division_unit')
        ->orderByDesc('count')
        ->first();

    $zoom_monthly = ZoomRequest::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->get();


    $zoom_pending = ZoomRequest::where('status', 'Pending')->count();
    $zoom_approved = ZoomRequest::where('status', 'Approved')->count();
    $zoom_declined = ZoomRequest::where('status', 'Declined')->count();

    // convert months without arrow functions
    $zoom_months = $zoom_monthly->pluck('month')->map(function ($m) {
        return Carbon::create()->month($m)->format('F');
    })->toArray();
    $zoom_totals = $zoom_monthly->pluck('total')->toArray();

    // ====== ID REPORT ======
    $id_totalRequests = IDRequest::count();
    $id_latestRequest = IDRequest::latest('created_at')->first();

    $id_mostActiveDivision = IDRequest::join('division_unit', 'id_request.id_division_unit', '=', 'division_unit.id')
        ->select('division_unit.division_unit as division_name', DB::raw('COUNT(*) as count'))
        ->groupBy('division_unit.division_unit')
        ->orderByDesc('count')
        ->first();

    // ====== ID REQUESTS FOR TODAY ======
    $todayIdRequests = IDRequest::whereDate('created_at', $today)
        ->orderByDesc('created_at')
        ->paginate(10);

    // ====== VEHICLE RESERVATIONS REPORT ======
    $vehicle_totalReservations = VehicleReservation::count();

    $vehicle_pendingRequests = VehicleReservation::where('status', 'Pending')->count();

    // Vehicles in use today (reservations that span or fall on today)
    $vehicle_inUseToday = VehicleReservation::where(function ($q) use ($today) {
            $q->whereDate('departure_date', '<=', $today)
              ->whereDate('return_date', '>=', $today);
        })
        ->where('status', 'Approved')
        ->count();

    $vehicle_latestReservation = VehicleReservation::latest('created_at')->first();

    // Most used vehicle
    $vehicle_mostUsed = VehicleReservation::select('vehicle_name', DB::raw('COUNT(*) as count'))
        ->groupBy('vehicle_name')
        ->orderByDesc('count')
        ->first();

    // Most active division for vehicle reservations
    $vehicle_mostActiveDivision = VehicleReservation::join('division_unit', 'vehicle_reservations.id_division_unit', '=', 'division_unit.id')
        ->select('division_unit.division_unit as division_name', DB::raw('COUNT(*) as count'))
        ->groupBy('division_unit.division_unit')
        ->orderByDesc('count')
        ->first();

    // Status breakdown
    $vehicle_approved = VehicleReservation::where('status', 'Approved')->count();
    $vehicle_declined = VehicleReservation::where('status', 'Declined')->count();

    // Reservations for Today
    $todayVehicleReservations = VehicleReservation::where(function ($q) use ($today) {
            $q->whereDate('departure_date', $today)
              ->orWhereDate('return_date', $today)
              ->orWhere(function ($q2) use ($today) {
                  $q2->whereDate('departure_date', '<', $today)
                     ->whereDate('return_date', '>', $today);
              });
        })
        ->orderBy('departure_time')
        ->paginate(10);

    // ====== Return view ======
    return view('welcome', compact(
        'todayMeetings',
        'zoom_totalRequests',
        'zoom_latestRequest',
        'zoom_mostActiveDivision',
        'zoom_pending',
        'zoom_approved',
        'zoom_declined',
        'zoom_months',
        'zoom_totals',
        'id_totalRequests',
        'id_latestRequest',
        'id_mostActiveDivision',
        'todayIdRequests',
        // Vehicle Reservation Stats
        'vehicle_totalReservations',
        'vehicle_pendingRequests',
        'vehicle_inUseToday',
        'vehicle_latestReservation',
        'vehicle_mostUsed',
        'vehicle_mostActiveDivision',
        'vehicle_approved',
        'vehicle_declined',
        'todayVehicleReservations'
    ));
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DivisionUnit  $divisionUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(DivisionUnit $divisionUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DivisionUnit  $divisionUnit
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'division_unit' => 'required|string|max:255',
        ]);

        $division_unit = DivisionUnit::findOrFail($id);
        $division_unit->update(['division_unit' => $request->division_unit]);

        return redirect()->back()->with('success', 'Unit updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DivisionUnit  $divisionUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $division_unit = DivisionUnit::findOrFail($id);
        $division_unit->delete();

        return redirect()->back()->with('success', 'Unit deleted successfully.');
    }
}
