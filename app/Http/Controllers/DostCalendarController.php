<?php

namespace App\Http\Controllers;

use App\Models\DostCalendar;
use Illuminate\Http\Request;

class DostCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = DostCalendar::orderBy('start_date')->get();
        return view('dost_calendar.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'event_title' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        DostCalendar::create($request->all());

        return redirect()->back()->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'event_title' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        $event = DostCalendar::findOrFail($id);
        $event->update($request->all());

        return redirect()->back()->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $event = DostCalendar::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully!');
    }
}
