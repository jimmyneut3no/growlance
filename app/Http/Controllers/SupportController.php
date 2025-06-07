<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = auth()->user()->supportTickets()
            ->withCount('replies')
            ->latest()
            ->paginate(10);
$categories = [];
$popularArticles = [];
        return view('support.index', compact('tickets', 'categories','popularArticles'));
    }

    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'category' => ['required', 'string', 'in:general,technical,account,withdrawal'],
            'priority' => ['required', 'string', 'in:low,medium,high'],
        ]);

        $ticket = auth()->user()->supportTickets()->create([
            'subject' => $request->subject,
            'message' => $request->message,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => 'open',
        ]);

        return redirect()->route('support.show', $ticket)
            ->with('success', 'Support ticket created successfully');
    }

    public function show(SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $ticket->load('replies.user');
        
        // Mark ticket as read
        auth()->user()->update(['last_ticket_read_at' => now()]);

        return view('support.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        if ($ticket->status === 'closed') {
            return back()->with('error', 'Cannot reply to a closed ticket');
        }

        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $ticket->replies()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'is_staff_reply' => false,
        ]);

        if ($ticket->status === 'in_progress') {
            $ticket->update(['status' => 'open']);
        }

        return back()->with('success', 'Reply added successfully');
    }

    public function close(SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $ticket->markAsClosed();

        return back()->with('success', 'Ticket closed successfully');
    }

    public function reopen(SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $ticket->reopen();

        return back()->with('success', 'Ticket reopened successfully');
    }

    public function categories()
    {
        $categories = [
            'general' => 'General Questions',
            'technical' => 'Technical Support',
            'account' => 'Account Issues',
            'withdrawal' => 'Withdrawal Support',
        ];

        return view('support.categories', compact('categories'));
    }
} 