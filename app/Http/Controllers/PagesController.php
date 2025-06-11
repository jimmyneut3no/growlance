<?php

namespace App\Http\Controllers;
use App\Models\StakingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormMail;

class PagesController extends Controller
{
    public function home(Request $request){
         $stakingPlans = StakingPlan::where('is_active', true)->get();
        return view('home', compact('stakingPlans'));
    }
    public function contact(Request $request){
        // $StakingPlan = StakingPlan::all();
        return view('pages.contact');
    }
    public function stakingPlans(Request $request){
         $stakingPlans = StakingPlan::where('is_active', true)->get();
        return view('staking-plans', compact('stakingPlans'));
    }

    public function referral()
    {
        return view('pages.referral');
    }

    public function sendContact(Request $request)
    {
        try {
            Log::info('Contact form submission started', [
                'email' => $request->input('email'),
                'name' => $request->input('first-name') . ' ' . $request->input('last-name')
            ]);

            $request->validate([
                'first-name' => 'required|string|max:255',
                'last-name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string',
            ]);

            Log::info('Form validation passed');

            $data = [
                'firstName' => $request->input('first-name'),
                'lastName' => $request->input('last-name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'message' => $request->input('message'),
            ];

            Log::info('Preparing to send emails', ['data' => $data]);

            // Send notification to admin
            Mail::to('info@growlance.io')
                ->send(new ContactFormMail($data));

            // Send confirmation to the sender
            Mail::to($data['email'])
                ->send(new ContactFormMail($data, true));

            Log::info('Emails sent successfully');

            return response()->json(['message' => 'Thank you for your message. We will get back to you soon!']);
        } catch (\Exception $e) {
            Log::error('Contact form error', [
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