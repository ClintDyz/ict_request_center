<?php

namespace App\Http\Controllers;

use App\Models\IctEquipment;
use Illuminate\Http\Request;

class IctEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $ict_equipment = IctEquipment::all();
        return view('ict_equipment.index', compact('ict_equipment'));
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
// IDRequestController.php

public function store(Request $request)
{
    $request->validate([
        'item_description' => 'required|string|max:255',
        'quantity' => 'required|integer',
    ]);

    IctEquipment::create([
        'item_description' => $request->item_description,
        'quantity' => $request->quantity,
    ]);

    return redirect()->back()->with('success', 'ICT Equipment created successfully.');
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IctEquipment  $ictEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(IctEquipment $ictEquipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IctEquipment  $ictEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(IctEquipment $ictEquipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IctEquipment  $ictEquipment
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $request->validate([
            'item_description' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        $ict_equipment = IctEquipment::findOrFail($id);
        $ict_equipment->update([
            'item_description' => $request->item_description,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'ICT Equipment updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IctEquipment  $ictEquipment
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        $ict_equipment = IctEquipment::findOrFail($id);
        $ict_equipment->delete();

        return redirect()->back()->with('success', 'ICT Equipment deleted successfully.');
    }
}
