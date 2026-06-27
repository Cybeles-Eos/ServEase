<?php

namespace App\Http\Controllers;

use App\Models\CustomerRequest;
use App\Models\CustomerRequestApplication;
use App\Services\CustomerRequestEmailService;
use App\Services\CustomerRequestStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class CustomerRequestController extends Controller
{
    public function marketplace(CustomerRequestStatusService $statusService)
    {
        $user = auth()->user();

        if (!$user || (! $user->isProvider() && ! $user->isAdmin())) {
            abort(403);
        }

        if ($user->isProvider() && $user->provider?->application_status !== 'accepted') {
            abort(403);
        }

        $statusService->autoCompleteAcceptedRequests();

        $requests = CustomerRequest::with([
                'customer.user',
                'applications.provider.user',
                'acceptedProvider.user',
            ])
            ->where('status', '!=', 'completed')
            ->orderByRaw("
                CASE status
                    WHEN 'open' THEN 1
                    WHEN 'accepted' THEN 2
                    ELSE 4
                END
            ")
            ->latest()
            ->paginate(9);

        $provider = $user->isProvider() ? $user->provider : null;

        return view('front.pages.custom-pages.customer-requests', compact('requests', 'provider'));
    }

    public function customerIndex(Request $request, CustomerRequestStatusService $statusService)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer) {
            abort(403, 'Customer account not found.');
        }

        $statusService->autoCompleteAcceptedRequests();

        $selectedStatus = $request->query('status', '');
        $allowedStatuses = ['open', 'accepted', 'completed'];

        if ($selectedStatus !== '' && !in_array($selectedStatus, $allowedStatuses, true)) {
            $selectedStatus = '';
        }

        $baseRequestQuery = CustomerRequest::where('customer_id', $customer->id);

        $requestStats = [
            'total' => (clone $baseRequestQuery)->count(),
            'open' => (clone $baseRequestQuery)->where('status', 'open')->count(),
            'accepted' => (clone $baseRequestQuery)->where('status', 'accepted')->count(),
            'completed' => (clone $baseRequestQuery)->where('status', 'completed')->count(),
        ];

        $requests = CustomerRequest::with([
                'applications.provider.user',
                'acceptedProvider.user',
            ])
            ->where('customer_id', $customer->id)
            ->when($selectedStatus !== '', fn ($query) => $query->where('status', $selectedStatus))
            ->orderByRaw("
                CASE status
                    WHEN 'accepted' THEN 1
                    WHEN 'open' THEN 2
                    WHEN 'completed' THEN 3
                    ELSE 4
                END
            ")
            ->latest()
            ->get();

        $contactName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));
        $contactAddress = trim(implode(', ', array_filter([
            $customer->street_address ?? null,
            $customer->barangay ?? null,
            $customer->city ?? null,
        ])));

        return view('admin.customer-requests.index', [
            'requests' => $requests,
            'contactName' => $contactName,
            'contactEmail' => $customer->user->email ?? auth()->user()->email,
            'contactPhone' => $customer->phone_number ?? '',
            'contactAddress' => $contactAddress,
            'selectedStatus' => $selectedStatus,
            'requestStats' => $requestStats,
        ]);
    }

    public function store(Request $request)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer) {
            abort(403, 'Customer account not found.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:2000'],
            'fixed_price' => ['required', 'numeric', 'min:100', 'max:10000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5048'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_address' => ['required', 'string', 'max:1000'],
        ]);

        $customerRequest = CustomerRequest::create([
            'customer_id' => $customer->id,
            'title' => $validated['title'],
            'service_type' => $validated['service_type'],
            'description' => $validated['description'],
            'fixed_price' => $validated['fixed_price'],
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'contact_address' => $validated['contact_address'],
            'status' => 'open',
        ]);

        if ($request->hasFile('image')) {
            $customerRequest->update([
                'image_path' => $this->uploadFile($request->file('image'), 'customer_requests'),
            ]);
        }

        return redirect()->route('customer.requests.index')->with('flash_message', [
            'title' => 'Customer Request Created',
            'message' => 'Providers can now apply to your request.',
            'type' => 'success',
        ]);
    }

    public function apply(Request $request, CustomerRequest $customerRequest)
    {
        $provider = auth()->user()->provider ?? null;

        if (!$provider || $provider->application_status !== 'accepted') {
            abort(403, 'Provider account not found.');
        }

        if ($customerRequest->status !== 'open') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Request Closed',
                'message' => 'This customer request is no longer open for applications.',
                'type' => 'warning',
            ]);
        }

        $validated = $request->validate([
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $alreadyApplied = CustomerRequestApplication::where('customer_request_id', $customerRequest->id)
            ->where('provider_id', $provider->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Already Applied',
                'message' => 'You already applied to this customer request.',
                'type' => 'info',
            ]);
        }

        CustomerRequestApplication::create([
            'customer_request_id' => $customerRequest->id,
            'provider_id' => $provider->id,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        return redirect()->back()->with('flash_message', [
            'title' => 'Application Sent',
            'message' => 'Your application was sent to the customer.',
            'type' => 'success',
        ]);
    }

    public function acceptApplication(CustomerRequest $customerRequest, CustomerRequestApplication $application, CustomerRequestEmailService $emailService)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer || $customerRequest->customer_id !== $customer->id) {
            abort(403);
        }

        if ($customerRequest->status !== 'open' || $customerRequest->accepted_application_id) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'This request already has an accepted provider.',
                'type' => 'warning',
            ]);
        }

        if ($application->customer_request_id !== $customerRequest->id || $application->status !== 'pending') {
            abort(404);
        }

        DB::transaction(function () use ($customerRequest, $application) {
            $application->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            CustomerRequestApplication::where('customer_request_id', $customerRequest->id)
                ->where('id', '!=', $application->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'updated_at' => now(),
                ]);

            $customerRequest->update([
                'status' => 'accepted',
                'accepted_provider_id' => $application->provider_id,
                'accepted_application_id' => $application->id,
                'accepted_at' => now(),
            ]);
        });

        $customerRequest->refresh();
        $emailService->sendAcceptedProvider($customerRequest);

        return redirect()->back()->with('flash_message', [
            'title' => 'Provider Accepted',
            'message' => 'The provider was notified by email.',
            'type' => 'success',
        ]);
    }

    public function complete(CustomerRequest $customerRequest)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer || $customerRequest->customer_id !== $customer->id) {
            abort(403);
        }

        if ($customerRequest->status !== 'accepted') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only accepted customer requests can be completed.',
                'type' => 'warning',
            ]);
        }

        $customerRequest->update([
            'status' => 'completed',
            'completed_at' => now(),
            'completion_source' => 'manual',
        ]);

        return redirect()->back()->with('flash_message', [
            'title' => 'Request Completed',
            'message' => 'The customer request has been marked as completed.',
            'type' => 'success',
        ]);
    }

    public function providerWork(CustomerRequestStatusService $statusService)
    {
        $provider = auth()->user()->provider ?? null;

        if (!$provider || $provider->application_status !== 'accepted') {
            abort(403, 'Provider account not found.');
        }

        $statusService->autoCompleteAcceptedRequests();

        $applications = CustomerRequestApplication::with([
                'customerRequest.customer.user',
                'customerRequest.acceptedProvider.user',
            ])
            ->where('provider_id', $provider->id)
            ->latest()
            ->get();

        $completedRequests = CustomerRequest::where('accepted_provider_id', $provider->id)
            ->where('status', 'completed');

        return view('admin.provider-customer-requests.index', [
            'applications' => $applications,
            'completedRequestCount' => (clone $completedRequests)->count(),
            'completedRequestIncome' => (clone $completedRequests)->sum('fixed_price'),
            'appliedRequestCount' => $applications->count(),
            'pendingApplicationCount' => $applications->where('status', 'pending')->count(),
        ]);
    }

    private function uploadFile($file, string $path): string
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = substr(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), 0, 30)
            . '-' . time()
            . '.' . $extension;
        $fileName = preg_replace("/[^a-z0-9\_\-\.]/i", '', $fileName);
        $filePath = 'uploads/' . $path;
        $directory = public_path($filePath);

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true);
        }

        $file->move($directory, $fileName);

        return $filePath . '/' . $fileName;
    }
}
