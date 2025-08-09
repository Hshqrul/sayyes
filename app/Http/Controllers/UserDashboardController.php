<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $events = Event::with('rsvps')
            ->where('user_id', $user->id)
            ->get();

        $stats = $events->map(function ($event) {
            return [
                'event_name' => $event->event_name,
                'event_slug' => $event->slug,
                'attend' => $event->rsvps->where('attendence', true)->count(),
                'absent' => $event->rsvps->where('attendence', false)->count(),
                'total' => $event->rsvps->sum('no_of_pax'),
            ];
        });

        return Inertia::render('UserDashboard', [
            'stats' => $stats,
        ]);
    }
}
