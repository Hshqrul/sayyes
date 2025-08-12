<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('rsvps')->where('user_id', auth()->user()->id)->latest()->get();

        return inertia('event/Index', [
            'events' => $events
        ]);
    }

    public function create()
    {
        return inertia('event/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'allowed_pax' => 'nullable|integer|min:1',
        ]);

        try {
            \DB::beginTransaction();
            $validated['slug'] = Str::slug($validated['event_name'], '-');
            $validated['user_id'] = Auth::id();

            Event::create($validated);

            \DB::commit();

            session()->flash('toast', [
                'type' => 'success',
                'title' => 'Event created successfully.',
                // 'description' => 'Yore event ' . $validated['event_name'] . ' has been created.'
            ]);
            return redirect()->route('events.index');
        } catch (\Exception $e) {
            \DB::rollBack();

            session()->flash('toast', [
                'type' => 'error',
                'title' => 'Failed to create event.'
            ]);
            return redirect()->back();
        }
    }

    public function edit(Event $event)
    {
        return Inertia::render('event/Edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        try {
            \DB::beginTransaction();

            $request->validate([
                'event_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'event_date' => 'required|date',
                'allowed_pax' => 'required|integer|min:1',
            ]);

            $update = [
                'event_name' => $request->input('event_name'),
                'description' => $request->input('description'),
                'event_date' => $request->input('event_date'),
                'allowed_pax' => $request->input('allowed_pax'),
            ];

            if ($request->input('event_name') !== $event->event_name) {
                $update['slug'] = Str::slug($request->input('event_name'), '-');
            }

            $event->update($update);

            \DB::commit();

            session()->flash('toast', [
                'type' => 'success',
                'title' => 'Event updated successfully.'
            ]);
            return redirect()->route('events.index');
        } catch (\Exception $e) {
            \DB::rollBack();

            session()->flash('toast', [
                'type' => 'error',
                'title' => 'Failed to update event.',
            ]);
            return back();
        }
    }

    public function show(Event $event)
    {
        // return Inertia::render('event/Show', compact('event'));
    }

    public function destroy(Event $event)
    {
        try {
            \DB::beginTransaction();

            if ($event->rsvps()->exists()) {
                session()->flash('toast', [
                    'type' => 'error',
                    'title' => 'Unable to delete the event. This event has RSVPs.',
                    'description' => 'This event has RSVPs.'
                ]);
                return redirect()->route('events.index');
            }

            $event->delete();

            \DB::commit();

            session()->flash('toast', [
                'type' => 'success',
                'title' => 'Event deleted successfully.',
                'description' => ''
            ]);
            return redirect()->route('events.index');
        } catch (\Exception $e) {
            \DB::rollBack();

            if ($event->rsvps()->exists()) {
                session()->flash('toast', [
                    'type' => 'error',
                    'title' => 'Unable to delete the event. This event has RSVPs.'
                ]);
            } else {
                session()->flash('toast', [
                    'type' => 'error',
                    'title' => $e->getMessage()
                ]);
            }
            return redirect()->back();
        }
    }

    public function toast()
    {
        // session()->flash('toast', [
        //     'type' => 'success',
        //     'text' => 'Test Toast'
        // ]);
        // session()->flash('toast', [
        //     'type' => 'error',
        //     'text' => 'Test Toast'
        // ]);
        // session()->flash('toast', [
        //     'type' => 'warning',
        //     'text' => 'Test Toast'
        // ]);
        session()->flash('toast', [
            'type' => 'message',  // success | error | warning | info
            'title' => 'Test Toast',
            'description' => 'Hello world'
        ]);

        return redirect()->route('events.index');
    }
}
