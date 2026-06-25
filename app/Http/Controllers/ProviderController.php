<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;
use App\Models\ProviderDeletedRecord;
use App\Models\BookingRequest;
use App\Models\ServiceRating;
use App\Services\AdminNotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Storage;
use File;
use Carbon\Carbon;

class ProviderController extends Controller
{
    public function resubmit()
    {
        $user = User::with('provider')->find(auth()->id());
        $provider = $user?->provider;

        if (! $provider) {
            abort(403, 'Provider account not found.');
        }

        if ($provider->application_status === 'accepted') {
            return redirect()->route('provider.dashboard');
        }

        if ($provider->application_status !== 'declined') {
            Auth::logout();

            return redirect()->route('login')->with('flash_message', [
                'title' => 'Application Under Review',
                'message' => 'Your provider application is still under review.',
                'type' => 'info',
            ]);
        }

        if (empty($provider->resubmission_required_documents)) {
            return redirect()->route('provider.declined');
        }

        return view('admin.provider-resubmit', compact('user', 'provider'));
    }

    public function declined()
    {
        $user = User::with('provider')->find(auth()->id());
        $provider = $user?->provider;

        if (! $provider) {
            abort(403, 'Provider account not found.');
        }

        if ($provider->application_status === 'accepted') {
            return redirect()->route('provider.dashboard');
        }

        if ($provider->application_status !== 'declined') {
            Auth::logout();

            return redirect()->route('login')->with('flash_message', [
                'title' => 'Application Under Review',
                'message' => 'Your provider application is still under review.',
                'type' => 'info',
            ]);
        }

        if (!empty($provider->resubmission_required_documents)) {
            return redirect()->route('provider.resubmit');
        }

        return view('admin.provider-declined', compact('user', 'provider'));
    }

    public function deleteDeclinedRecords(Request $request)
    {
        $user = auth()->user();
        $provider = $user?->provider;

        if (! $user || ! $provider || $provider->application_status !== 'declined' || !empty($provider->resubmission_required_documents)) {
            abort(403);
        }

        foreach ([$provider->resume_path, $provider->barangay_clearance_path] as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $deletedRecord = ProviderDeletedRecord::create([
            'provider_name' => trim(($provider->first_name ?? '') . ' ' . ($provider->last_name ?? '')) ?: $user->name,
            'provider_email' => $user->email,
            'deleted_at' => now(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->forceDelete();

        AdminNotificationService::providerDeletedRecords($deletedRecord);

        return redirect()->route('login')->with('flash_message', [
            'title' => 'Records Deleted',
            'message' => 'Your provider application records have been deleted.',
            'type' => 'success',
        ]);
    }

    public function updateResubmission(Request $request)
    {
        $user = auth()->user();
        $provider = $user?->provider;

        if (! $provider || $provider->application_status !== 'declined') {
            abort(403);
        }

        $requiredDocuments = $provider->resubmission_required_documents ?: ['resume', 'barangay_clearance'];

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'regex:/^09[0-9]{9}$/'],
            'home_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'regex:/^\d{4}$/'],
            'profession' => ['required', 'string', 'max:255'],
            'year_exp' => ['required', 'integer', 'min:1', 'max:100'],
            'resume' => [in_array('resume', $requiredDocuments, true) ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:5120'],
            'barangay_clearance' => [in_array('barangay_clearance', $requiredDocuments, true) ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];

        $validated = $request->validate($rules, [
            'phone_number.regex' => 'The phone number must start with 09 and must be exactly 11 digits.',
            'zipcode.regex' => 'The ZIP Code must be 4 digits.',
        ]);

        if ($request->hasFile('resume')) {
            $provider->resume_path = $request->file('resume')->store('provider-resumes', 'public');
        }

        if ($request->hasFile('barangay_clearance')) {
            $provider->barangay_clearance_path = $request->file('barangay_clearance')->store('provider-barangay-clearances', 'public');
        }

        $provider->fill([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'home_address' => $validated['home_address'],
            'city' => $validated['city'],
            'barangay' => $validated['barangay'],
            'zipcode' => $validated['zipcode'],
            'profession' => $validated['profession'],
            'year_exp' => $validated['year_exp'],
            'application_status' => 'pending',
            'application_reviewed_at' => null,
            'application_reviewed_by' => null,
            'application_remarks' => null,
            'resubmission_required_documents' => null,
        ]);
        $provider->save();

        $user->update([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'is_active' => 0,
        ]);

        AdminNotificationService::newProviderApplication($user);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('flash_message', [
            'title' => 'Application Resubmitted',
            'message' => 'Your updated application was sent for admin review.',
            'type' => 'success',
        ]);
    }

    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $provider = $user->provider ?? null;

        if (!$provider) {
            abort(403, 'Provider account not found.');
        }

        $year = now()->year;
        $today = now()->toDateString();
        $selectedYear = (int) $request->get('year', now()->year);
        $selectedMonth = $request->get('month');

        $selectedMonth = $selectedMonth !== null && $selectedMonth !== ''
            ? (int) $selectedMonth
            : null;

        $year = $selectedYear;
        $today = now()->toDateString();

        /*
        |--------------------------------------------------------------------------
        | Base Provider Booking Query
        |--------------------------------------------------------------------------
        */
        $providerBookingQuery = BookingRequest::query()
            ->where('booking_requests.provider_id', $provider->id)
            ->whereHas('bookingInfo.service');
        $earningsSql = $this->bookingEarningsSql();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Cards
        |--------------------------------------------------------------------------
        */
        $totalBookings = (clone $providerBookingQuery)->count();

        $todayBookings = (clone $providerBookingQuery)
            ->whereHas('bookingInfo', function ($query) use ($today) {
                $query->whereDate('date', $today);
            })
            ->count();

        $completedBookings = (clone $providerBookingQuery)
            ->where('booking_requests.status', 'COMPLETED')
            ->count();

        $completedToday = (clone $providerBookingQuery)
            ->where('booking_requests.status', 'COMPLETED')
            ->whereHas('bookingInfo', function ($query) use ($today) {
                $query->whereDate('date', $today);
            })
            ->count();

        $totalEarnings = BookingRequest::query()
            ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
            ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
            ->where('booking_requests.provider_id', $provider->id)
            ->where('booking_requests.status', 'COMPLETED')
            ->whereNull('tbl_services.deleted_at')
            ->sum(DB::raw($earningsSql));

        $todayEarnings = BookingRequest::query()
            ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
            ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
            ->where('booking_requests.provider_id', $provider->id)
            ->where('booking_requests.status', 'COMPLETED')
            ->whereDate('booking_infos.date', $today)
            ->whereNull('tbl_services.deleted_at')
            ->sum(DB::raw($earningsSql));

            /*
            |--------------------------------------------------------------------------
            | Ratings
            |--------------------------------------------------------------------------
            | Provider overall rating from all service ratings under this provider.
            */
            $providerRatings = ServiceRating::where('provider_id', $provider->id)->get();

            $ratingCount = $providerRatings->count();

            $averageRating = round($providerRatings->avg('rating') ?? 0, 1);

            $todayRatings = ServiceRating::where('provider_id', $provider->id)
                ->whereDate('created_at', $today)
                ->count();

            $ratingTodayPercent = $ratingCount > 0
                ? round(($todayRatings / $ratingCount) * 100)
                : 0;

        /*
        |--------------------------------------------------------------------------
        | Monthly Bookings + Earnings
        |--------------------------------------------------------------------------
        */
        // $monthlyStats = (clone $providerBookingQuery)
        //     ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
        //     ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
        //     ->selectRaw('
        //         MONTH(booking_infos.date) as month,
        //         COUNT(booking_requests.id) as bookings_count,
        //         SUM(
        //             CASE 
        //                 WHEN booking_requests.status = "COMPLETED" 
        //                 THEN COALESCE(tbl_services.price, 0) 
        //                 ELSE 0 
        //             END
        //         ) as earnings_total
        //     ')
        //     ->whereYear('booking_infos.date', $year)
        //     ->groupBy(DB::raw('MONTH(booking_infos.date)'))
        //     ->get()
        //     ->keyBy('month');

        /*
        |--------------------------------------------------------------------------
        | Chart Filter: Yearly or Monthly
        |--------------------------------------------------------------------------
        | If month is empty, show Jan-Dec.
        | If month is selected, show daily data for selected month.
        */
        $chartLabels = [];
        $monthlyBookings = [];
        $monthlyEarnings = [];

        if ($selectedMonth) {
            $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
            $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();

            $dailyStats = BookingRequest::query()
                ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
                ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
                ->where('booking_requests.provider_id', $provider->id)
                ->whereBetween('booking_infos.date', [$startDate->toDateString(), $endDate->toDateString()])
                ->whereNull('tbl_services.deleted_at')
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
                $monthlyBookings[] = (int) ($dailyStats[$day]->bookings_count ?? 0);
                $monthlyEarnings[] = (float) ($dailyStats[$day]->earnings_total ?? 0);
            }
        } else {
            $monthlyStats = BookingRequest::query()
                ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
                ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
                ->where('booking_requests.provider_id', $provider->id)
                ->whereYear('booking_infos.date', $selectedYear)
                ->whereNull('tbl_services.deleted_at')
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
                $monthlyBookings[] = (int) ($monthlyStats[$month]->bookings_count ?? 0);
                $monthlyEarnings[] = (float) ($monthlyStats[$month]->earnings_total ?? 0);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Recent Bookings
        |--------------------------------------------------------------------------
        */
        $recentBookings = BookingRequest::with([
                'bookingInfo.service.serviceCategory',
                'bookingInfo.customer',
            ])
            ->where('provider_id', $provider->id)
            ->latest()
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Categories
        |--------------------------------------------------------------------------
        | Count most booked categories for this provider.
        */
        $topCategories = DB::table('booking_requests')
            ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
            ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
            ->leftJoin('service_categories', 'service_categories.id', '=', 'tbl_services.service_category_id')
            ->where('booking_requests.provider_id', $provider->id)
            ->whereNotIn('booking_requests.status', ['DECLINED', 'CANCELLED'])
            ->selectRaw('
                service_categories.id,
                COALESCE(service_categories.name, "Uncategorized") as name,
                COUNT(booking_requests.id) as bookings_count,
                SUM(
                    CASE 
                        WHEN booking_requests.status = "COMPLETED" 
                        THEN ' . $earningsSql . '
                        ELSE 0 
                    END
                ) as earnings_total
            ')
            ->groupBy('service_categories.id', 'service_categories.name')
            ->orderByDesc('bookings_count')
            ->limit(4)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Pie Chart Earnings By Category
        |--------------------------------------------------------------------------
        */
        $categoryEarnings = DB::table('booking_requests')
            ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
            ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
            ->leftJoin('service_categories', 'service_categories.id', '=', 'tbl_services.service_category_id')
            ->where('booking_requests.provider_id', $provider->id)
            ->where('booking_requests.status', 'COMPLETED')
            ->selectRaw('
                COALESCE(service_categories.name, "Uncategorized") as name,
                SUM(' . $earningsSql . ') as earnings_total
            ')
            ->groupBy('service_categories.name')
            ->havingRaw('SUM(' . $earningsSql . ') > 0')
            ->orderByDesc('earnings_total')
            ->get();

        $accountHealth = $provider->accountHealth();

        return view('admin.provdashboard', compact(
            'year',
            'selectedYear',
            'selectedMonth',
            'chartLabels',
            'totalBookings',
            'todayBookings',
            'completedBookings',
            'completedToday',
            'averageRating',
            'ratingCount',
            'todayRatings',
            'ratingTodayPercent',
            'totalEarnings',
            'todayEarnings',
            'monthlyBookings',
            'monthlyEarnings',
            'recentBookings',
            'topCategories',
            'categoryEarnings',
            'accountHealth'
        ));
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

    public function bookingCalendar(Request $request)
    {
        $provider = auth()->user()->provider ?? null;

        if (!$provider) {
            abort(403, 'Provider account not found.');
        }

        $monthInput = $request->input('month', now()->format('Y-m'));

        try {
            $currentMonth = Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth();
        } catch (\Exception $e) {
            $currentMonth = now()->startOfMonth();
        }

        $selectedDate = $request->input('date', now()->toDateString());

        try {
            $selectedDate = Carbon::parse($selectedDate)->toDateString();
        } catch (\Exception $e) {
            $selectedDate = now()->toDateString();
        }

        $startOfMonth = $currentMonth->copy()->startOfMonth();
        $endOfMonth = $currentMonth->copy()->endOfMonth();
        $calendarStart = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $calendarEnd = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        $calendarDays = collect();
        for ($date = $calendarStart->copy(); $date->lte($calendarEnd); $date->addDay()) {
            $calendarDays->push($date->copy());
        }

        $bookings = BookingRequest::with([
                'bookingInfo.service',
                'bookingInfo.customer',
            ])
            ->where('provider_id', $provider->id)
            ->whereIn('status', ['ACCEPTED', 'ONGOING', 'COMPLETED'])
            ->whereHas('bookingInfo', function ($query) use ($calendarStart, $calendarEnd) {
                $query->whereBetween('date', [
                    $calendarStart->toDateString(),
                    $calendarEnd->toDateString(),
                ]);
            })
            ->get()
            ->sortBy(function ($booking) {
                $bookingInfo = $booking->bookingInfo;
                return trim(($bookingInfo?->date?->format('Y-m-d') ?? '') . ' ' . ($bookingInfo?->time?->format('H:i') ?? ''));
            });

        $bookingsByDate = $bookings->groupBy(fn ($booking) => $booking->bookingInfo?->date?->toDateString());
        $selectedBookings = $bookingsByDate->get($selectedDate, collect());

        $todayBookingsCount = $bookingsByDate->get(now()->toDateString(), collect())->count();
        $confirmedBookingsCount = $bookings->count();
        $monthBookingsCount = $bookings->count();

        return view('admin.provider-calendar', [
            'currentMonth' => $currentMonth,
            'previousMonth' => $currentMonth->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $currentMonth->copy()->addMonth()->format('Y-m'),
            'calendarDays' => $calendarDays,
            'bookingsByDate' => $bookingsByDate,
            'selectedDate' => $selectedDate,
            'selectedBookings' => $selectedBookings,
            'todayBookingsCount' => $todayBookingsCount,
            'confirmedBookingsCount' => $confirmedBookingsCount,
            'monthBookingsCount' => $monthBookingsCount,
        ]);
    }

    // Index Settings
    public function setting()
    {
        $user = User::with('provider')->find(auth()->id());
        $availabilityDays = Provider::AVAILABILITY_DAYS;
        $defaultAvailabilityDays = Provider::DEFAULT_AVAILABILITY_DAYS;
        $defaultAvailabilityStartTime = Provider::DEFAULT_AVAILABILITY_START_TIME;
        $defaultAvailabilityEndTime = Provider::DEFAULT_AVAILABILITY_END_TIME;

        return view('admin.provsetting', compact(
            'user',
            'availabilityDays',
            'defaultAvailabilityDays',
            'defaultAvailabilityStartTime',
            'defaultAvailabilityEndTime'
        ));
    }

    public function updateSetting(Request $request)
    {
        $request->validate([
            'first_name'   => 'nullable|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'profile_image'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'home_address' => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'barangay'     => 'nullable|string|max:255',
            'zipcode'      => ['nullable', 'string', 'regex:/^\d{4}$/'],
            // 'email'        => 'nullable|email|max:255',
            'profession'   => 'nullable|string|max:255',
            'year_exp'     => 'required|integer|min:1|max:100',
            'availability_days' => 'required|array|min:1',
            'availability_days.*' => 'in:' . implode(',', array_keys(Provider::AVAILABILITY_DAYS)),
            'availability_start_time' => 'nullable|required_with:availability_end_time|date_format:H:i',
            'availability_end_time' => 'nullable|required_with:availability_start_time|date_format:H:i|after:availability_start_time',
            'change_password' => 'nullable|boolean',
            'password' => 'required_if:change_password,1|nullable|string|min:8|confirmed',
        ], [
            'zipcode.regex' => 'The ZIP Code must be 4 digits.',
        ]);

        $user = auth()->user();
        $provider = $user->provider;

        /*
        |--------------------------------------------------------------------------
        | Handle Image Removal
        |--------------------------------------------------------------------------
        */
        if ($request->remove_profile_image == "1") {

            if ($provider->profile_image && file_exists(public_path($provider->profile_image))) {
                unlink(public_path($provider->profile_image));
            }

            $provider->profile_image = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Handle New Upload
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $this->uploadFile(
                $request->file('profile_image'),
                'profile',
                'provider_profiles'
            );

            $provider->profile_image = $profileImagePath;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Provider Table
        |--------------------------------------------------------------------------
        */
        $provider->first_name  = $request->first_name;
        $provider->last_name   = $request->last_name;
        $provider->phone_number= $request->phone_number;
        $provider->home_address     = $request->home_address;
        $provider->city        = $request->city;
        $provider->barangay     = $request->barangay;
        $provider->zipcode     = $request->zipcode;
        $provider->profession     = $request->profession;
        $provider->year_exp     = $request->year_exp;
        $provider->availability_days = $request->input('availability_days', Provider::DEFAULT_AVAILABILITY_DAYS);
        $provider->availability_start_time = $request->availability_start_time ?: Provider::DEFAULT_AVAILABILITY_START_TIME;
        $provider->availability_end_time = $request->availability_end_time ?: Provider::DEFAULT_AVAILABILITY_END_TIME;
        $provider->save();

        /*
        |--------------------------------------------------------------------------
        | Update Users Table
        |--------------------------------------------------------------------------
        */
        $user->name  = trim($request->first_name . ' ' . $request->last_name);
        // $user->email = $request->email;

        if ($request->boolean('change_password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('provider.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Profile updated successfully.',
            'type' => 'success'
        ]);
    }

    // Helper function to handle file uploads
    public function uploadFile($file, $type = null, $path)
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), 0, 30) . '-' . time() . ($type ? '-' . $type : '') . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = 'uploads/' . $path;
        $directory = public_path($file_path);

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true);
        }

        $file->move($directory, $file_name);
        return $file_path . '/' . $file_name;
    }
}
