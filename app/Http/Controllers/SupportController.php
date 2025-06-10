<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SupportContactMail;

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

    public function contact()
    {
        return view('support.contact');
    }

    public function sendContact(Request $request)
    {
        try {
            Log::info('Support contact form submission started', [
                'user_id' => auth()->id(),
                'subject' => $request->input('subject')
            ]);

            $request->validate([
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            Log::info('Form validation passed');

            $data = [
                'user' => auth()->user(),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
            ];

            Log::info('Preparing to send emails', ['data' => $data]);

            // Send notification to admin
            Mail::to('info@growlance.io')
                ->send(new SupportContactMail($data));

            // Send confirmation to the user
            Mail::to($data['user']->email)
                ->send(new SupportContactMail($data, true));

            Log::info('Emails sent successfully');

            return response()->json(['message' => 'Thank you for your message. Our support team will get back to you soon!']);
        } catch (\Exception $e) {
            Log::error('Support contact form error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Sorry, there was an error sending your message. Please try again later.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
} 