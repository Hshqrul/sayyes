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
        $events = Event::where('user_id', Auth::id())->latest()->get();

        return Inertia::render('event/Index', [
            'events' => $events
        ]);
    }

    public function create()
    {
        return Inertia::render('event/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'allowed_pax' => 'nullable|integer|min:1',
        ]);

        $validated['slug'] = Str::slug($validated['event_name'], '-');
        $validated['user_id'] = Auth::id();

        Event::create($validated);

        return redirect()->route('events.index')->with('message', 'Event created.');
    }

    public function edit(Event $event)
    {
        return Inertia::render('event/Edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
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

        return redirect()->route('events.index')->with('message', 'Event updated.');
    }

    public function show(Event $event)
    {
        return Inertia::render('event/Show', compact('event'));
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('message', 'Event deleted.');
    }
}
