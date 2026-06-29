<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\AdminNotification;
use App\Models\BookingRequest;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\PlatformSetting;
use App\Models\DailyOtpUsage;
use App\Services\BookingStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Provider;
use App\Services\AdminNotificationService;
use App\Services\AuditLogService;
use App\Services\OtpService;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (! auth()->user()->isAdmin()) {
            return redirect('/')->with('flash_message', [
                'title' => 'Account Not Found!',
                'message' => 'Please Login Your Account To Continue.',
                'type' => 'error'
            ]);
        }

        $selectedYear = (int) $request->get('year', now()->year);
        $selectedMonth = $request->get('month');

        $selectedMonth = $selectedMonth !== null && $selectedMonth !== ''
            ? (int) $selectedMonth
            : null;
        $providerRankingMode = $request->get('provider_ranking') === 'ratings' ? 'ratings' : 'bookings';
        /*
        |--------------------------------------------------------------------------
        | Header Cards
        |--------------------------------------------------------------------------
        */
        $totalUsers = User::query()
            ->where('is_active', 1)
            ->whereIn('role', ['provider', 'customer'])
            ->count();

        $totalProviders = User::query()
            ->where('is_active', 1)
            ->where('role', 'provider')
            ->whereHas('provider', function ($query) {
                $query->where('application_status', 'accepted');
            })
            ->count();

        $totalCustomers = User::query()
            ->where('is_active', 1)
            ->where('role', 'customer')
            ->count();

        $totalServices = Service::query()
            ->visibleToCustomers()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Booking / Earnings Analytics
        |--------------------------------------------------------------------------
        */
        $activeProviderBookingsQuery = $this->activeProviderBookingsQuery();
        $earningsSql = $this->bookingEarningsSql();

        $totalBookings = (clone $activeProviderBookingsQuery)
            ->count('booking_requests.id');

        $completedBookings = (clone $activeProviderBookingsQuery)
            ->where('booking_requests.status', 'COMPLETED')
            ->count('booking_requests.id');

        $pendingBookings = (clone $activeProviderBookingsQuery)
            ->where('booking_requests.status', 'PENDING')
            ->count('booking_requests.id');

        $totalEarnings = (clone $activeProviderBookingsQuery)
            ->where('booking_requests.status', 'COMPLETED')
            ->sum(DB::raw($earningsSql));

        /*
        |--------------------------------------------------------------------------
        | Chart Data
        |--------------------------------------------------------------------------
        | If month is empty: Jan-Dec.
        | If month has value: daily data for selected month.
        */
        $chartLabels = [];
        $analyticsBookings = [];
        $analyticsEarnings = [];

        if ($selectedMonth) {
            $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
            $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();

            $dailyStats = $this->activeProviderBookingsQuery()
                ->whereBetween('booking_infos.date', [$startDate->toDateString(), $endDate->toDateString()])
                ->selectRaw('
                    DAY(booking_infos.date) as day,
                    COUNT(booking_requests.id) as bookings_count,
                    SUM(
                        CASE
                            WHEN booking_requests.status = "COMPLETED"
                            THEN ' . $earningsSql . '
                            ELSE 0
                        END
                    ) as earnings_total
                ')
                ->groupBy(DB::raw('DAY(booking_infos.date)'))
                ->get()
                ->keyBy('day');

            foreach (CarbonPeriod::create($startDate, $endDate) as $date) {
                $day = (int) $date->format('d');

                $chartLabels[] = $date->format('M d');
                $analyticsBookings[] = (int) ($dailyStats[$day]->bookings_count ?? 0);
                $analyticsEarnings[] = (float) ($dailyStats[$day]->earnings_total ?? 0);
            }
        } else {
            $monthlyStats = $this->activeProviderBookingsQuery()
                ->whereYear('booking_infos.date', $selectedYear)
                ->selectRaw('
                    MONTH(booking_infos.date) as month,
                    COUNT(booking_requests.id) as bookings_count,
                    SUM(
                        CASE
                            WHEN booking_requests.status = "COMPLETED"
                            THEN ' . $earningsSql . '
                            ELSE 0
                        END
                    ) as earnings_total
                ')
                ->groupBy(DB::raw('MONTH(booking_infos.date)'))
                ->get()
                ->keyBy('month');

            for ($month = 1; $month <= 12; $month++) {
                $chartLabels[] = Carbon::create()->month($month)->format('M');
                $analyticsBookings[] = (int) ($monthlyStats[$month]->bookings_count ?? 0);
                $analyticsEarnings[] = (float) ($monthlyStats[$month]->earnings_total ?? 0);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Recent Services
        |--------------------------------------------------------------------------
        */
        $recentServices = Service::with(['provider', 'serviceCategory'])
            ->latest()
            ->paginate(4, ['*'], 'services_page')
            ->withQueryString();

        $serviceIds = $recentServices->getCollection()->pluck('id')->filter()->values();

        $serviceStats = DB::table('booking_infos')
            ->join('booking_requests', 'booking_requests.booking_info_id', '=', 'booking_infos.id')
            ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
            ->join('tbl_providers', 'tbl_providers.id', '=', 'tbl_services.provider_id')
            ->join('users', 'users.id', '=', 'tbl_providers.user_id')
            ->whereIn('booking_infos.service_id', $serviceIds)
            ->where('users.is_active', 1)
            ->where('tbl_providers.application_status', 'accepted')
            ->selectRaw('
                booking_infos.service_id,
                COUNT(booking_requests.id) as bookings_count,
                SUM(
                    CASE
                        WHEN booking_requests.status = "COMPLETED"
                        THEN ' . $earningsSql . '
                        ELSE 0
                    END
                ) as earnings_total
            ')
            ->groupBy('booking_infos.service_id')
            ->get()
            ->keyBy('service_id');

        $recentServices->getCollection()->transform(function ($service) use ($serviceStats) {
            $stats = $serviceStats[$service->id] ?? null;

            $service->dashboard_bookings_count = (int) ($stats->bookings_count ?? 0);
            $service->dashboard_earnings_total = (float) ($stats->earnings_total ?? 0);

            return $service;
        });

        /*
        |--------------------------------------------------------------------------
        | Recent Users
        |--------------------------------------------------------------------------
        */
        $recentUsers = User::with(['provider', 'customer'])
            ->whereIn('role', ['provider', 'customer'])
            ->latest()
            ->paginate(4, ['*'], 'users_page')
            ->withQueryString();


        $providerBookingStats = DB::table('booking_requests')
            ->select('provider_id', DB::raw('COUNT(*) as total_bookings'))
            ->groupBy('provider_id');

        $providerRatingStats = DB::table('service_ratings')
            ->select(
                'provider_id',
                DB::raw('AVG(rating) as average_rating'),
                DB::raw('COUNT(*) as ratings_count')
            )
            ->groupBy('provider_id');

        $topProvidersQuery = Provider::query()
            ->with('user')
            ->where('application_status', 'accepted')
            ->whereHas('user', function ($query) {
                $query->where('role', 'provider')
                    ->where('is_active', 1);
            })
            ->leftJoinSub($providerBookingStats, 'provider_booking_stats', function ($join) {
                $join->on('provider_booking_stats.provider_id', '=', 'tbl_providers.id');
            })
            ->leftJoinSub($providerRatingStats, 'provider_rating_stats', function ($join) {
                $join->on('provider_rating_stats.provider_id', '=', 'tbl_providers.id');
            })
            ->select('tbl_providers.*')
            ->selectRaw('COALESCE(provider_booking_stats.total_bookings, 0) as total_bookings')
            ->selectRaw('COALESCE(provider_rating_stats.average_rating, 0) as average_rating')
            ->selectRaw('COALESCE(provider_rating_stats.ratings_count, 0) as ratings_count');

        if ($providerRankingMode === 'ratings') {
            $topProvidersQuery
                ->orderByDesc('average_rating')
                ->orderByDesc('ratings_count')
                ->orderByDesc('total_bookings');
        } else {
            $topProvidersQuery
                ->orderByDesc('total_bookings')
                ->orderByDesc('average_rating');
        }

        $topProviders = $topProvidersQuery
            ->latest('tbl_providers.created_at')
            ->limit(10)
            ->get();

        return view('admin.page.admin.index', compact(
            'totalUsers',
            'totalProviders',
            'totalCustomers',
            'totalServices',
            'totalBookings',
            'completedBookings',
            'pendingBookings',
            'totalEarnings',
            'selectedYear',
            'selectedMonth',
            'chartLabels',
            'analyticsBookings',
            'analyticsEarnings',
            'recentServices',
            'recentUsers',
            'providerRankingMode',
            'topProviders',
        ));
    }

    private function activeProviderBookingsQuery()
    {
        return DB::table('booking_requests')
            ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
            ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
            ->join('tbl_providers', 'tbl_providers.id', '=', 'tbl_services.provider_id')
            ->join('users', 'users.id', '=', 'tbl_providers.user_id')
            ->where('users.is_active', 1)
            ->where('tbl_providers.application_status', 'accepted')
            ->whereNull('tbl_services.deleted_at');
    }

    private function bookingEarningsSql(): string
    {
        return '
            CASE
                WHEN tbl_services.pricing_type = "per_hour"
                    AND booking_requests.completed_total IS NOT NULL
                THEN booking_requests.completed_total
                WHEN tbl_services.pricing_type = "per_hour"
                    AND (
                        booking_requests.completed_hours IS NOT NULL
                        OR booking_requests.completed_minutes IS NOT NULL
                    )
                THEN (
                    (
                        (COALESCE(booking_requests.completed_hours, 0) * 60)
                        + COALESCE(booking_requests.completed_minutes, 0)
                    ) / 60
                ) * COALESCE(tbl_services.price, 0)
                ELSE COALESCE(tbl_services.price, 0)
            END
        ';
    }

    public function ongoingBookings(Request $request)
    {
        if (! auth()->user()->isAdmin()) {
            return redirect('/')->with('flash_message', [
                'title' => 'Account Not Found!',
                'message' => 'Please Login Your Account To Continue.',
                'type' => 'error'
            ]);
        }

        app(BookingStatusService::class)->updateAllDueBookings();

        $allowedStatuses = ['PENDING', 'ACCEPTED', 'ONGOING', 'COMPLETED', 'DECLINED', 'CANCELLED'];
        $status = strtoupper((string) $request->get('status', ''));
        $search = trim((string) $request->get('search', ''));

        $baseQuery = BookingRequest::query()
            ->with([
                'provider.user',
                'bookingInfo.customer',
                'bookingInfo.service.provider.user',
                'bookingInfo.service.serviceCategory',
            ]);

        $totalBookings = (clone $baseQuery)->count();
        $ongoingBookings = (clone $baseQuery)->where('status', 'ONGOING')->count();
        $completedBookings = (clone $baseQuery)->where('status', 'COMPLETED')->count();
        $cancelledBookings = (clone $baseQuery)->where('status', 'CANCELLED')->count();

        $bookings = $baseQuery
            ->when(in_array($status, $allowedStatuses, true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('id', $search)
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('bookingInfo', function ($bookingQuery) use ($search) {
                            $bookingQuery->where('fname', 'like', "%{$search}%")
                                ->orWhere('lname', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('number', 'like', "%{$search}%")
                                ->orWhere('address', 'like', "%{$search}%");
                        })
                        ->orWhereHas('provider', function ($providerQuery) use ($search) {
                            $providerQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('phone_number', 'like', "%{$search}%")
                                ->orWhereHas('user', function ($userQuery) use ($search) {
                                    $userQuery->where('email', 'like', "%{$search}%");
                                });
                        })
                        ->orWhereHas('bookingInfo.service', function ($serviceQuery) use ($search) {
                            $serviceQuery->where('title', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.page.admin.bookings.index', compact(
            'allowedStatuses',
            'bookings',
            'cancelledBookings',
            'completedBookings',
            'ongoingBookings',
            'search',
            'status',
            'totalBookings',
        ));
    }

    public function auditLogs(Request $request)
    {
        if (! auth()->user()->isAdmin()) {
            return redirect('/')->with('flash_message', [
                'title' => 'Account Not Found!',
                'message' => 'Please Login Your Account To Continue.',
                'type' => 'error'
            ]);
        }

        $module = (string) $request->get('module', '');
        $event = (string) $request->get('event', '');
        $dateFrom = (string) $request->get('date_from', '');
        $dateTo = (string) $request->get('date_to', '');
        $search = trim((string) $request->get('search', ''));

        $moduleOptions = AuditLog::query()
            ->select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        $eventOptions = AuditLog::query()
            ->select('event')
            ->distinct()
            ->orderBy('event')
            ->pluck('event');

        $auditLogs = AuditLog::query()
            ->when($module !== '', fn ($query) => $query->where('module', $module))
            ->when($event !== '', fn ($query) => $query->where('event', $event))
            ->when($dateFrom !== '', fn ($query) => $query->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo !== '', fn ($query) => $query->whereDate('created_at', '<=', $dateTo))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('actor_name', 'like', "%{$search}%")
                        ->orWhere('actor_role', 'like', "%{$search}%")
                        ->orWhere('module', 'like', "%{$search}%")
                        ->orWhere('event', 'like', "%{$search}%")
                        ->orWhere('subject_label', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.page.admin.audit-logs.index', compact(
            'auditLogs',
            'dateFrom',
            'dateTo',
            'event',
            'eventOptions',
            'module',
            'moduleOptions',
            'search',
        ));
    }

    // public function users()
    // {
    //     $users = User::query()
    //         ->whereIn('role', ['provider', 'customer'])
    //         ->with(['provider', 'customer'])
    //         ->orderBy('name')
    //         ->get();

    //     return view('admin.page.admin.user.index', compact('users'));
    // }
    public function users(Request $request)
    {
        $query = User::with(['customer', 'provider'])
            ->whereIn('role', ['customer', 'provider'])
            ->where(function ($query) {
                $query->where('role', 'customer')
                    ->orWhere(function ($providerQuery) {
                        $providerQuery->where('role', 'provider')
                            ->whereHas('provider', function ($profileQuery) {
                                $profileQuery->where('application_status', '!=', 'declined');
                            });
                    });
            })
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('barangay', 'like', "%{$search}%");
                    })
                    ->orWhereHas('provider', function ($providerQuery) use ($search) {
                        $providerQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('barangay', 'like', "%{$search}%")
                            ->orWhere('profession', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('role') && in_array($request->role, ['customer', 'provider'], true)) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $users = $query->get();

        return view('admin.page.admin.user.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.page.admin.user.create');
    }

    public function storeUser(Request $request)
    {
        $role = $request->input('role');

        $rules = [
            'role' => ['required', Rule::in(['customer', 'provider'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($role === 'customer') {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone_number'] = ['nullable', 'string', 'max:255'];
            $rules['gender'] = ['required', Rule::in(['male', 'female', 'prefer_not_to_say'])];
            $rules['street_address'] = ['nullable', 'string', 'max:255'];
            $rules['city'] = ['nullable', 'string', 'max:255'];
            $rules['barangay'] = ['nullable', 'string', 'max:255'];
            $rules['zipcode'] = ['nullable', 'string', 'regex:/^\d{4}$/'];
        } else {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone_number'] = ['required', 'string', 'max:255'];
            $rules['gender'] = ['required', Rule::in(['male', 'female', 'prefer_not_to_say'])];
            $rules['home_address'] = ['required', 'string', 'max:255'];
            $rules['city'] = ['required', 'string', 'max:255'];
            $rules['barangay'] = ['nullable', 'string', 'max:255'];
            $rules['zipcode'] = ['required', 'string', 'regex:/^\d{4}$/'];
            $rules['profession'] = ['required', 'string', 'max:255'];
            $rules['year_exp'] = ['required', 'integer', 'min:1', 'max:100'];
        }

        $validated = $request->validate($rules, [
            'zipcode.regex' => 'The ZIP Code must be 4 digits.',
        ]);

        $otpService = app(OtpService::class);

        if ($otpService->hasReachedDailyLimit()) {
            return redirect()
                ->route('admin.users.create')
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('flash_message', $otpService->limitFlashMessage());
        }

        $createdUser = null;

        DB::transaction(function () use ($validated, $role, &$createdUser) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $role,
                'is_active' => true,
            ]);

            if ($role === 'customer') {
                $user->customer()->create([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'phone_number' => $validated['phone_number'] ?? null,
                    'gender' => $validated['gender'],
                    'street_address' => $validated['street_address'] ?? null,
                    'city' => $validated['city'] ?? null,
                    'barangay' => $validated['barangay'] ?? null,
                    'zipcode' => $validated['zipcode'] ?? null,
                ]);
            } else {
                $user->provider()->create([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'phone_number' => $validated['phone_number'],
                    'gender' => $validated['gender'],
                    'home_address' => $validated['home_address'],
                    'city' => $validated['city'],
                    'barangay' => $validated['barangay'] ?? null,
                    'zipcode' => $validated['zipcode'],
                    'profession' => $validated['profession'],
                    'year_exp' => $validated['year_exp'],
                ]);
            }

            $createdUser = $user;
        });

        if ($createdUser) {
            AdminNotificationService::adminCreatedUser($createdUser, $role);
            AuditLogService::record(
                'Users',
                'created',
                'Created ' . $role . ' account for ' . ($createdUser->name ?: $createdUser->email) . '.',
                $createdUser,
                ucfirst($role) . ' #' . $createdUser->id,
                ['email' => $createdUser->email, 'role' => $role]
            );
        }

        return redirect()->route('admin.users')->with('flash_message', [
            'title' => '',
            'message' => 'User created successfully.',
            'type' => 'success',
        ]);
    }

    public function showUser(User $user)
    {
        $this->assertManagedUser($user);
        $user->load(['provider', 'customer']);

        return view('admin.page.admin.user.show', compact('user'));
    }

    public function editUser(User $user)
    {
        $this->assertManagedUser($user);
        $user->load(['provider', 'customer']);

        return view('admin.page.admin.user.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $this->assertManagedUser($user);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'change_password' => ['required', 'in:0,1'],
            'is_active' => ['required', 'in:0,1'],
        ];

        if ($request->boolean('change_password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        if ($user->role === 'customer') {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone_number'] = ['nullable', 'string', 'max:255'];
            $rules['gender'] = ['required', Rule::in(['male', 'female', 'prefer_not_to_say'])];
            $rules['street_address'] = ['nullable', 'string', 'max:255'];
            $rules['city'] = ['nullable', 'string', 'max:255'];
            $rules['barangay'] = ['nullable', 'string', 'max:255'];
            $rules['zipcode'] = ['nullable', 'string', 'regex:/^\d{4}$/'];
        } else {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone_number'] = ['required', 'string', 'max:255'];
            $rules['gender'] = ['required', Rule::in(['male', 'female', 'prefer_not_to_say'])];
            $rules['home_address'] = ['required', 'string', 'max:255'];
            $rules['city'] = ['required', 'string', 'max:255'];
            $rules['barangay'] = ['nullable', 'string', 'max:255'];
            $rules['zipcode'] = ['required', 'string', 'regex:/^\d{4}$/'];
            $rules['profession'] = ['required', 'string', 'max:255'];
            $rules['year_exp'] = ['required', 'integer', 'min:1', 'max:100'];
        }

        $validated = $request->validate($rules, [
            'zipcode.regex' => 'The ZIP Code must be 4 digits.',
        ]);

        DB::transaction(function () use ($validated, $user) {
            $payload = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'is_active' => (bool) $validated['is_active'],
            ];

            if (($validated['change_password'] ?? '0') === '1') {
                $payload['password'] = Hash::make($validated['password']);
            }

            $user->update($payload);

            if ($user->role === 'customer') {
                $user->customer()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'first_name' => $validated['first_name'],
                        'last_name' => $validated['last_name'],
                        'phone_number' => $validated['phone_number'] ?? null,
                        'gender' => $validated['gender'],
                        'street_address' => $validated['street_address'] ?? null,
                        'city' => $validated['city'] ?? null,
                        'barangay' => $validated['barangay'] ?? null,
                        'zipcode' => $validated['zipcode'] ?? null,
                    ]
                );
            } else {
                $user->provider()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'first_name' => $validated['first_name'],
                        'last_name' => $validated['last_name'],
                        'phone_number' => $validated['phone_number'],
                        'gender' => $validated['gender'],
                        'home_address' => $validated['home_address'],
                        'city' => $validated['city'],
                        'barangay' => $validated['barangay'] ?? null,
                        'zipcode' => $validated['zipcode'],
                        'profession' => $validated['profession'],
                        'year_exp' => $validated['year_exp'],
                    ]
                );
            }
        });

        AuditLogService::record(
            'Users',
            'updated',
            'Updated ' . $user->role . ' account for ' . ($user->name ?: $user->email) . '.',
            $user,
            ucfirst($user->role) . ' #' . $user->id,
            ['email' => $user->email, 'role' => $user->role, 'is_active' => $user->is_active]
        );

        return redirect()->route('admin.users')->with('flash_message', [
            'title' => '',
            'message' => 'User updated successfully.',
            'type' => 'success',
        ]);
    }

    public function destroyUser(Request $request, User $user)
    {
        $this->assertManagedUser($user);

        if ($user->id === auth()->id()) {
            abort(403);
        }

        $subjectLabel = ucfirst($user->role) . ' #' . $user->id;
        $deletedName = $user->name ?: $user->email;
        $deletedEmail = $user->email;
        $deletedRole = $user->role;

        $user->delete();

        AuditLogService::record(
            'Users',
            'deleted',
            'Deleted ' . $deletedRole . ' account for ' . $deletedName . '.',
            $user,
            $subjectLabel,
            ['email' => $deletedEmail, 'role' => $deletedRole]
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'User deleted successfully.']);
        }

        return redirect()->route('admin.users')->with('flash_message', [
            'title' => '',
            'message' => 'User deleted successfully.',
            'type' => 'success',
        ]);
    }

    private function assertManagedUser(User $user): void
    {
        if (! in_array($user->role, ['provider', 'customer'], true)) {
            abort(404);
        }

        if ($user->role === 'provider') {
            $user->loadMissing('provider');

            if (!$user->provider || $user->provider->application_status === 'declined') {
                abort(404);
            }
        }
    }

    public function applicants(Request $request)
    {
        $query = Provider::with('user')
            ->whereIn('application_status', ['pending', 'declined'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('profession', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%")
                    ->orWhere('barangay', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('application_status', $request->status);
        }

        $applicants = $query->get();

        return view('admin.page.admin.applicants.index', compact('applicants'));
    }
    public function showApplicant(Provider $provider)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $provider->load('user');

        return view('admin.page.admin.applicants.show', compact('provider'));
    }
    public function showApplicantDocument(Provider $provider, string $document)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $path = match ($document) {
            'resume' => $provider->resume_path,
            'barangay-clearance' => $provider->barangay_clearance_path,
            default => null,
        };

        if (empty($path) || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ]);
    }
    public function acceptApplicant(Provider $provider)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $provider->update([
            'application_status' => 'accepted',
            'application_reviewed_at' => now(),
            'application_reviewed_by' => auth()->id(),
            'application_remarks' => null,
        ]);

        if ($provider->user) {
            $provider->user->update([
                'is_active' => 1,
            ]);
        }

        AuditLogService::record(
            'Applicants',
            'accepted',
            'Accepted provider application for ' . (trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: 'Provider #' . $provider->id) . '.',
            $provider,
            'Provider #' . $provider->id,
            ['user_id' => $provider->user_id]
        );

        return redirect()->route('admin.applicants')->with('flash_message', [
            'title' => 'Applicant Accepted',
            'message' => 'Provider account is now active.',
            'type' => 'success',
        ]);
    }
    public function declineApplicant(Request $request, Provider $provider)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'remarks' => ['nullable', 'string', 'max:1000'],
            'resubmission_required_documents' => ['nullable', 'array'],
            'resubmission_required_documents.*' => ['in:resume,barangay_clearance'],
        ]);

        $provider->update([
            'application_status' => 'declined',
            'application_reviewed_at' => now(),
            'application_reviewed_by' => auth()->id(),
            'application_remarks' => $validated['remarks'] ?? null,
            'resubmission_required_documents' => $validated['resubmission_required_documents'] ?? null,
        ]);

        if ($provider->user) {
            $provider->user->update([
                'is_active' => 1,
            ]);
        }

        AuditLogService::record(
            'Applicants',
            'declined',
            'Declined provider application for ' . (trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: 'Provider #' . $provider->id) . '.',
            $provider,
            'Provider #' . $provider->id,
            [
                'user_id' => $provider->user_id,
                'remarks' => $validated['remarks'] ?? null,
                'resubmission_required_documents' => $validated['resubmission_required_documents'] ?? null,
            ]
        );

        return redirect()->route('admin.applicants')->with('flash_message', [
            'title' => 'Applicant Declined',
            'message' => 'Provider application has been declined.',
            'type' => 'warning',
        ]);
    }






    /*
     *
     *  General Setting Controllers
     * 
    */
    public function setting(Request $request)
    {
        $categorySearch = $request->input('category_search');
        $platformSettings = PlatformSetting::current();
        $smtpDailyLimit = 300;
        $smtpUsageRecords = DailyOtpUsage::query()
            ->latest('date')
            ->paginate(2, ['*'], 'smtp_usage_page')
            ->withQueryString();
        $smtpTodayUsage = DailyOtpUsage::query()
            ->where('date', now('Asia/Manila')->toDateString())
            ->first();
        $smtpUsedToday = (int) ($smtpTodayUsage->used ?? 0);
        $smtpRemainingToday = max($smtpDailyLimit - $smtpUsedToday, 0);

        $serviceCategories = ServiceCategory::query()
            ->when($categorySearch, function ($query) use ($categorySearch) {
                $query->where('name', 'like', '%' . $categorySearch . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.page.admin.general_setting.index', compact(
            'serviceCategories',
            'categorySearch',
            'platformSettings',
            'smtpDailyLimit',
            'smtpUsageRecords',
            'smtpUsedToday',
            'smtpRemainingToday'
        ));
    }

    public function updatePlatformContact(Request $request)
    {
        $validated = $request->validate([
            'platform_email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'facebook_page' => ['nullable', 'url', 'max:255'],
            'office_address' => ['nullable', 'string', 'max:1000'],
            'support_hours' => ['nullable', 'string', 'max:255'],
        ]);

        PlatformSetting::current()->update($validated);

        AuditLogService::record(
            'General Settings',
            'updated',
            'Updated platform contact settings.',
            PlatformSetting::current(),
            'Platform contact settings',
            ['fields' => array_keys($validated)]
        );

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Platform contact settings saved successfully.',
            'type' => 'success',
        ]);
    }

    public function updatePlatformBranding(Request $request)
    {
        $validated = $request->validate([
            'platform_name' => ['nullable', 'string', 'max:255'],
            'platform_tagline' => ['nullable', 'string', 'max:500'],
            'service_area' => ['nullable', 'string', 'max:255'],
            'privacy_policy_url' => ['nullable', 'url', 'max:255'],
            'terms_url' => ['nullable', 'url', 'max:255'],
        ]);

        PlatformSetting::current()->update($validated);

        AuditLogService::record(
            'General Settings',
            'updated',
            'Updated platform branding and legal settings.',
            PlatformSetting::current(),
            'Platform branding settings',
            ['fields' => array_keys($validated)]
        );

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Platform branding and legal settings saved successfully.',
            'type' => 'success',
        ]);
    }

    public function updateOtpFeature(Request $request)
    {
        $validated = $request->validate([
            'otp_enabled' => ['nullable', 'in:1'],
        ]);

        PlatformSetting::current()->update([
            'otp_enabled' => isset($validated['otp_enabled']),
        ]);

        AuditLogService::record(
            'General Settings',
            'updated',
            isset($validated['otp_enabled'])
                ? 'Enabled OTP verification.'
                : 'Disabled OTP verification.',
            PlatformSetting::current(),
            'OTP feature settings',
            ['otp_enabled' => isset($validated['otp_enabled'])]
        );

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => isset($validated['otp_enabled'])
                ? 'OTP verification has been enabled.'
                : 'OTP verification has been turned off. Account creation will continue without email OTP.',
            'type' => 'success',
        ]);
    }

    public function markAdminNotificationsRead(Request $request)
    {
        $user = auth()->user();

        if (! $user || ! $user->isAdmin()) {
            abort(403);
        }

        if ($request->filled('notification_id')) {
            AdminNotification::query()
                ->where('id', $request->input('notification_id'))
                ->whereNull('read_at')
                ->update([
                    'read_at' => now(),
                ]);

            return response()->json([
                'message' => 'Notification marked as read.',
            ]);
        }

        AdminNotification::query()
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        return response()->json([
            'message' => 'Notifications marked as read.',
        ]);
    }
    public function storeServiceCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:service_categories,name'],
        ]);

        $serviceCategory = ServiceCategory::create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        AuditLogService::record(
            'Service Categories',
            'created',
            'Created service category "' . $serviceCategory->name . '".',
            $serviceCategory,
            'Category #' . $serviceCategory->id,
            ['name' => $serviceCategory->name]
        );

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Service category created successfully.',
            'type' => 'success',
        ]);
    }
    public function updateServiceCategory(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_categories', 'name')->ignore($serviceCategory->id),
            ],
            'is_active' => ['nullable', 'in:1'],
        ]);

        $serviceCategory->update([
            'name' => $validated['name'],
            'is_active' => $request->has('is_active'),
        ]);

        AuditLogService::record(
            'Service Categories',
            'updated',
            'Updated service category "' . $serviceCategory->name . '".',
            $serviceCategory,
            'Category #' . $serviceCategory->id,
            ['name' => $serviceCategory->name, 'is_active' => $serviceCategory->is_active]
        );

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Service category updated successfully.',
            'type' => 'success',
        ]);
    }
    public function destroyServiceCategory(Request $request, ServiceCategory $serviceCategory)
    {
        $categoryName = $serviceCategory->name;
        $categoryId = $serviceCategory->id;

        $serviceCategory->delete();

        AuditLogService::record(
            'Service Categories',
            'deleted',
            'Deleted service category "' . $categoryName . '".',
            $serviceCategory,
            'Category #' . $categoryId,
            ['name' => $categoryName]
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Service category deleted successfully.',
            ]);
        }

        return redirect()->route('admin.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Service category deleted successfully.',
            'type' => 'success',
        ]);
    }
}
