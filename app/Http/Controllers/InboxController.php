<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Inbox;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InboxController extends Controller
{
    public function index()
    {
        $inboxes = Inbox::with('user:id,name,email')->orderby('created_at', 'desc')
            ->get()
            ->map(function ($mail) {
                return [
                    'id' => $mail->id,
                    'subject' => $mail->subject,
                    'text' => $mail->text,
                    'read' => $mail->read,
                    'labels' => $mail->labels,
                    'created_at' => $mail->created_at->toISOString(), // ISO for JS
                    'user' => [
                        'name' => $mail->user->name ?? null,
                        'email' => $mail->user->email ?? null,
                    ],
                ];
            });

        return Inertia::render('mail/InboxPage', [
            'mails' => $inboxes,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'text' => 'required|string',
            'labels' => 'array',
            'labels.*' => 'string|max:50',
        ], [
            'subject.required' => 'Please enter a subject.',
            'text.required' => 'Please enter a message.',
            'labels.*.required' => 'Please enter at least one label.',
        ]);

        Inbox::create($validatedData);

        session()->flash('toast', [
            'type' => 'success',
            'title' => 'Message submitted successfully.',
            'description' => 'Your message has been submitted successfully.'
        ]);

        return back();
    }

    public function show(Inbox $message)
    {
        return response()->json($message);
    }

    public function update(Request $request, Inbox $message)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email',
            'subject' => 'string|max:255',
            'text' => 'string',
            'sent_at' => 'date',
            'read' => 'boolean',
            'labels' => 'array',
            'labels.*' => 'string|max:50',
        ]);

        $message->update($validated);

        return response()->json($message);
    }

    public function destroy(Inbox $message)
    {
        $message->delete();

        return response()->noContent();
    }

    public function markAsRead($id)
    {
        $mail = Inbox::findOrFail($id);
        $mail->update(['read' => true]);

        session()->flash('toast', [
            'type' => 'success',
            'title' => 'Message marked as read.',
            'description' => 'The message has been marked as read.'
        ]);

        return back();
    }
}
