<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\AdminNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('front.pages.custom-pages.contact');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'regex:/^09[0-9]{9}$/'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:3000'],
            'g-recaptcha-response' => ['required'],
        ], [
            'email.email' => 'Please enter a valid email address.',
            'phone.regex' => 'Phone number must start with 09 and must be exactly 11 digits.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
        ]);

        $recaptcha = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (! $recaptcha->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.'],
            ]);
        }

        $contact = Contact::create([
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'] ?? null,
        ]);

        AdminNotificationService::newContact($contact);

        return back()->with('flash_message', [
            'type' => 'success',
            'title' => 'Message Sent',
            'message' => 'Your message has been sent successfully.',
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function adminIndex(Request $request)
    {
        $contacts = Contact::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('id', $search)
                        ->orWhere('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.page.admin.contacts.index', compact('contacts'));
    }

    public function adminShow(Contact $contact)
    {
        return view('admin.page.admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
