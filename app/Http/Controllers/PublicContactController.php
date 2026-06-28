<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquirySubmitted;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PublicContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return redirect(route('home') . '#contact')
                ->with('contact_success', 'Thank you. Your message has been received.');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'inquiry_type' => ['required', 'in:general,reservation,concern,feedback,maintenance'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'phone.regex' => 'Enter a valid contact number.',
            'inquiry_type.in' => 'Choose a valid inquiry type.',
            'message.min' => 'Please include at least 10 characters so we can understand your inquiry.',
        ]);

        if ($validator->fails()) {
            return redirect(route('home') . '#contact')
                ->withErrors($validator, 'contact')
                ->withInput();
        }

        $data = $validator->validated();

        ContactInquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'inquiry_type' => $data['inquiry_type'],
            'message' => $data['message'],
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        if (config('contact.email_enabled')) {
            try {
                Mail::to(config('contact.inquiry_to_email'), config('contact.inquiry_to_name'))
                    ->send(new ContactInquirySubmitted($data, $request->ip()));
            } catch (Throwable $e) {
                Log::warning('Public contact inquiry email failed', [
                    'email' => $data['email'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('Public contact inquiry submitted', [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'inquiry_type' => $data['inquiry_type'],
            'message' => $data['message'],
            'ip' => $request->ip(),
            'submitted_at' => now()->toIso8601String(),
        ]);

        return redirect(route('home') . '#contact')
            ->with('contact_success', 'Thank you. Your message has been sent to the dorm administration.');
    }
}
