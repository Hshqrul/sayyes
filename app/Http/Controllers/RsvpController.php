<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $rsvps = $event->rsvps()
            ->select('id', 'name', 'no_of_pax', 'attendence', 'notes', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return inertia('rsvp/Index', [
            'data' => $rsvps,
            'event' => $event,
        ]);
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
            'no_of_pax' => 'required_if:attendence,true|integer',
            'notes' => 'required|string|max:500',
            'event_id' => 'required|exists:events,id',
        ], [
            'name.required' => 'Please enter your name.',
            'name.unique' => 'This name has already been filled, please use a different name.',
            'attendence.required' => 'Please specify your attendance.',
            'notes.required' => 'Please provide some wishes.',
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
        $event = Event::where('id', $rsvp->event_id)->first();
        $eventList = Event::where('user_id', auth()->user()->id)->select('id', 'event_name')->get();
        return Inertia::render('rsvp/Edit', [
            'rsvp' => $rsvp,
            'event' => $event,
            'eventList' => $eventList
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rsvp $rsvp)
    {
        try {
            \DB::beginTransaction();

            $request->validate([
                'name' => 'required|string|unique:rsvps,name,' . $rsvp->id,
                'attendence' => 'required|boolean',
                'no_of_pax' => 'required_if:attendence,true|integer',
                'notes' => 'required|string|max:500',
                'event_id' => 'required|exists:events,id',
            ], [
                'name.required' => 'Please enter your name.',
                'name.unique' => 'This name has already been filled, please use a different name.',
                'attendence.required' => 'Please specify your attendance.',
                'notes.required' => 'Please provide some wishes.',
            ]);

            $update = [
                'name' => $request->input('name'),
                'attendence' => $request->input('attendence'),
                'no_of_pax' => $request->input('no_of_pax'),
                'notes' => $request->input('notes'),
                'event_id' => $request->input('event_id'),
            ];

            $rsvp->update($update);

            \DB::commit();

            session()->flash('message', 'Rsvp successfully updated.');

            return redirect()->route('rsvps.index', [
                'event' => $rsvp->event()->first(),
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();

            session()->flash('error', 'Update failed. Please try again.');

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rsvp $rsvp)
    {
        try {
            \DB::beginTransaction();

            $rsvp->delete();

            \DB::commit();

            session()->flash('message', 'Rsvp successfully deleted.');
            return redirect()->route('rsvps.index');
        } catch (\Exception $e) {
            \DB::rollBack();

            session()->flash('message', $e->getMessage());
            return redirect()->back();
        }
    }
}
