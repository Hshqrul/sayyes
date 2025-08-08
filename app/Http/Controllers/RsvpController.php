<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Inertia::render('rsvp/FormRsvp');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('rsvp/FormRsvp');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:rsvps,name',
            'attendence' => 'required|boolean',
            'no_of_pax' => 'nullable|integer',
            'notes' => 'required|string|max:500',
            'event_id' => 'required|exists:events,id',
        ]);

        Rsvp::create($data);

        return redirect()->route('rsvp.success', [
            'name' => $data['name'],
            'event' => $data['event_id'],
        ])->with('message', 'Your response has been successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rsvp $rsvp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rsvp $rsvp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rsvp $rsvp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rsvp $rsvp)
    {
        //
    }
}
