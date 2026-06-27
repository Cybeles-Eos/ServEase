<?php

namespace App\Http\Controllers;

use App\Models\CustomerRequest;
use App\Models\CustomerRequestApplication;
use App\Services\CustomerRequestEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class CustomerRequestController extends Controller
{
    public function marketplace(Request $request)
    {
        $user = auth()->user();

        if (!$user || (! $user->isProvider() && ! $user->isAdmin())) {
            abort(403);
        }

        if ($user->isProvider() && $user->provider?->application_status !== 'accepted') {
            abort(403);
        }

        $search = trim((string) $request->query('q', ''));
        $selectedServiceType = trim((string) $request->query('service_type', ''));
        $sort = $request->query('sort', 'newest');

        if (!in_array($sort, ['newest', 'oldest', 'budget_high', 'budget_low'], true)) {
            $sort = 'newest';
        }

        $serviceTypes = CustomerRequest::where('status', 'open')
            ->where('is_published', true)
            ->whereNotNull('service_type')
            ->where('service_type', '!=', '')
            ->select('service_type')
            ->distinct()
            ->orderBy('service_type')
            ->pluck('service_type');

        $requests = CustomerRequest::with([
                'customer.user',
                'applications.provider.user',
                'acceptedProvider.user',
            ])
            ->where('status', 'open')
            ->where('is_published', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('service_type', 'like', '%' . $search . '%')
                        ->orWhere('contact_name', 'like', '%' . $search . '%')
                        ->orWhere('contact_address', 'like', '%' . $search . '%');
                });
            })
            ->when($selectedServiceType !== '', fn ($query) => $query->where('service_type', $selectedServiceType))
            ->orderByRaw("
                CASE status
                    WHEN 'open' THEN 1
                    WHEN 'accepted' THEN 2
                    ELSE 4
                END
            ")
            ->when($sort === 'newest', fn ($query) => $query->latest())
            ->when($sort === 'oldest', fn ($query) => $query->oldest())
            ->when($sort === 'budget_high', fn ($query) => $query->orderByDesc('fixed_price')->latest())
            ->when($sort === 'budget_low', fn ($query) => $query->orderBy('fixed_price')->latest())
            ->paginate(9);

        $provider = $user->isProvider() ? $user->provider : null;

        return view('front.pages.custom-pages.customer-requests', [
            'requests' => $requests,
            'provider' => $provider,
            'serviceTypes' => $serviceTypes,
            'search' => $search,
            'selectedServiceType' => $selectedServiceType,
            'sort' => $sort,
        ]);
    }

    public function customerIndex(Request $request)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer) {
            abort(403, 'Customer account not found.');
        }

        $selectedStatus = $request->query('status', '');
        $allowedStatuses = ['open', 'accepted', 'completed', 'cancelled'];

        if ($selectedStatus !== '' && !in_array($selectedStatus, $allowedStatuses, true)) {
            $selectedStatus = '';
        }

        $baseRequestQuery = CustomerRequest::where('customer_id', $customer->id);

        $requestStats = [
            'total' => (clone $baseRequestQuery)->count(),
            'open' => (clone $baseRequestQuery)->where('status', 'open')->count(),
            'accepted' => (clone $baseRequestQuery)->where('status', 'accepted')->count(),
            'completed' => (clone $baseRequestQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $baseRequestQuery)->where('status', 'cancelled')->count(),
        ];

        $requests = CustomerRequest::with([
                'applications.provider' => fn ($query) => $query->with('user')
                    ->withCount([
                        'acceptedCustomerRequests as completed_customer_requests_count' => fn ($query) => $query->where('status', 'completed'),
                    ]),
                'acceptedProvider' => fn ($query) => $query->with('user')
                    ->withCount([
                        'acceptedCustomerRequests as completed_customer_requests_count' => fn ($query) => $query->where('status', 'completed'),
                    ]),
            ])
            ->where('customer_id', $customer->id)
            ->when($selectedStatus !== '', fn ($query) => $query->where('status', $selectedStatus))
            ->orderByRaw("
                CASE status
                    WHEN 'accepted' THEN 1
                    WHEN 'open' THEN 2
                    WHEN 'completed' THEN 3
                    WHEN 'cancelled' THEN 4
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
            'fixed_price' => ['required', 'numeric', 'min:100', 'max:100000'],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'preferred_time' => ['nullable', 'date_format:H:i'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
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
            'preferred_date' => $validated['preferred_date'] ?? null,
            'preferred_time' => $validated['preferred_time'] ?? null,
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'contact_address' => $validated['contact_address'],
            'status' => 'open',
            'is_published' => true,
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

    public function update(Request $request, CustomerRequest $customerRequest)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer || $customerRequest->customer_id !== $customer->id) {
            abort(403);
        }

        if ($customerRequest->status !== 'open') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only open customer requests can be edited.',
                'type' => 'warning',
            ]);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:2000'],
            'fixed_price' => ['required', 'numeric', 'min:100', 'max:100000'],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'preferred_time' => ['nullable', 'date_format:H:i'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_image' => ['nullable', 'boolean'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_address' => ['required', 'string', 'max:1000'],
        ]);

        $customerRequest->update([
            'title' => $validated['title'],
            'service_type' => $validated['service_type'],
            'description' => $validated['description'],
            'fixed_price' => $validated['fixed_price'],
            'preferred_date' => $validated['preferred_date'] ?? null,
            'preferred_time' => $validated['preferred_time'] ?? null,
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'contact_address' => $validated['contact_address'],
        ]);

        if ($request->boolean('remove_image') && $customerRequest->image_path && File::exists(public_path($customerRequest->image_path))) {
            File::delete(public_path($customerRequest->image_path));
            $customerRequest->update([
                'image_path' => null,
            ]);
        }

        if ($request->hasFile('image')) {
            if ($customerRequest->image_path && File::exists(public_path($customerRequest->image_path))) {
                File::delete(public_path($customerRequest->image_path));
            }

            $customerRequest->update([
                'image_path' => $this->uploadFile($request->file('image'), 'customer_requests'),
            ]);
        }

        return redirect()->route('customer.requests.index')->with('flash_message', [
            'title' => 'Customer Request Updated',
            'message' => 'Your request details have been updated.',
            'type' => 'success',
        ]);
    }

    public function apply(Request $request, CustomerRequest $customerRequest)
    {
        $provider = auth()->user()->provider ?? null;

        if (!$provider || $provider->application_status !== 'accepted') {
            abort(403, 'Provider account not found.');
        }

        if ($customerRequest->status !== 'open' || !$customerRequest->is_published) {
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
            'customer_seen_at' => null,
            'provider_seen_at' => now(),
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
                'provider_seen_at' => null,
                'customer_seen_at' => now(),
            ]);

            CustomerRequestApplication::where('customer_request_id', $customerRequest->id)
                ->where('id', '!=', $application->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'provider_seen_at' => null,
                    'customer_seen_at' => now(),
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

    public function cancel(CustomerRequest $customerRequest, CustomerRequestEmailService $emailService)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer || $customerRequest->customer_id !== $customer->id) {
            abort(403);
        }

        if (!in_array($customerRequest->status, ['open', 'accepted'], true)) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only open or accepted customer requests can be cancelled.',
                'type' => 'warning',
            ]);
        }

        $shouldEmailAcceptedProvider = $customerRequest->status === 'accepted' && $customerRequest->accepted_provider_id;

        DB::transaction(function () use ($customerRequest) {
            CustomerRequestApplication::where('customer_request_id', $customerRequest->id)
                ->whereIn('status', ['pending', 'accepted'])
                ->update([
                    'status' => 'cancelled',
                    'provider_seen_at' => null,
                    'customer_seen_at' => now(),
                    'updated_at' => now(),
                ]);

            $customerRequest->update([
                'status' => 'cancelled',
                'is_published' => false,
            ]);
        });

        if ($shouldEmailAcceptedProvider) {
            $customerRequest->refresh();
            $emailService->sendCancelledProvider($customerRequest);
        }

        return redirect()->back()->with('flash_message', [
            'title' => 'Request Cancelled',
            'message' => 'The customer request has been cancelled.',
            'type' => 'success',
        ]);
    }

    public function destroy(CustomerRequest $customerRequest)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer || $customerRequest->customer_id !== $customer->id) {
            abort(403);
        }

        if ($customerRequest->status !== 'open') {
            return redirect()->back()->with('flash_message', [
                'title' => 'Invalid Action',
                'message' => 'Only open customer requests can be deleted. Accepted requests should be cancelled from the provider details modal.',
                'type' => 'warning',
            ]);
        }

        if ($customerRequest->image_path && File::exists(public_path($customerRequest->image_path))) {
            File::delete(public_path($customerRequest->image_path));
        }

        $customerRequest->delete();

        return redirect()->back()->with('flash_message', [
            'title' => 'Request Deleted',
            'message' => 'The customer request has been removed from your dashboard.',
            'type' => 'success',
        ]);
    }

    public function togglePublish(CustomerRequest $customerRequest)
    {
        $customer = auth()->user()->customer ?? null;

        if (!$customer || $customerRequest->customer_id !== $customer->id) {
            abort(403);
        }

        $customerRequest->update([
            'is_published' => !$customerRequest->is_published,
        ]);

        return redirect()->back()->with('flash_message', [
            'title' => $customerRequest->is_published ? 'Request Published' : 'Request Hidden',
            'message' => $customerRequest->is_published
                ? 'Providers can now see this customer request.'
                : 'This customer request is hidden from the provider marketplace.',
            'type' => 'success',
        ]);
    }

    public function providerWork()
    {
        $provider = auth()->user()->provider ?? null;

        if (!$provider || $provider->application_status !== 'accepted') {
            abort(403, 'Provider account not found.');
        }

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
