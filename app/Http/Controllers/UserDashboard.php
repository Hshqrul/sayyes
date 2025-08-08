<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserDashboard extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', auth()->user()->id)->select('id')->first();
        
        if ($events == null) {
            return redirect()->route('events.create');
        }
        
        $attendCount = Rsvp::where('event_id', $events->id)->where('attendence', true)->count();
        $absentCount = RSVP::where('event_id', $events->id)->where('attendence', false)->count();
        $totalGuests = Rsvp::where('event_id', $events->id)->sum('no_of_pax');

        return Inertia::render('UserDashboard', [
            'stats' => [
                'attend' => $attendCount ?? 0,
                'absent' => $absentCount ?? 0,
                'total' => $totalGuests ?? 0,
            ],
        ]);
    }
}
