<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BookingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Storage;
use File;
use Carbon\Carbon;

class ProviderController extends Controller
{

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
            ->sum(DB::raw('COALESCE(tbl_services.price, 0)'));

        $todayEarnings = BookingRequest::query()
            ->join('booking_infos', 'booking_infos.id', '=', 'booking_requests.booking_info_id')
            ->join('tbl_services', 'tbl_services.id', '=', 'booking_infos.service_id')
            ->where('booking_requests.provider_id', $provider->id)
            ->where('booking_requests.status', 'COMPLETED')
            ->whereDate('booking_infos.date', $today)
            ->whereNull('tbl_services.deleted_at')
            ->sum(DB::raw('COALESCE(tbl_services.price, 0)'));

        /*
        |--------------------------------------------------------------------------
        | Ratings
        |--------------------------------------------------------------------------
        | No rating/review table exists in the uploaded files.
        | Keep this 0 for now, or replace later when you already have reviews table.
        */
        $ratings = 0;

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
                            THEN COALESCE(tbl_services.price, 0) 
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
                            THEN COALESCE(tbl_services.price, 0) 
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
                        THEN COALESCE(tbl_services.price, 0) 
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
                SUM(COALESCE(tbl_services.price, 0)) as earnings_total
            ')
            ->groupBy('service_categories.name')
            ->havingRaw('SUM(COALESCE(tbl_services.price, 0)) > 0')
            ->orderByDesc('earnings_total')
            ->get();

        return view('admin.provdashboard', compact(
            'year',
            'selectedYear',
            'selectedMonth',
            'chartLabels',
            'totalBookings',
            'todayBookings',
            'completedBookings',
            'completedToday',
            'ratings',
            'totalEarnings',
            'todayEarnings',
            'monthlyBookings',
            'monthlyEarnings',
            'recentBookings',
            'topCategories',
            'categoryEarnings'
        ));
    }
    // Index Settings
    public function setting()
    {
        $user = User::with('provider')->find(auth()->id());
        return view('admin.provsetting', compact('user'));
    }

    public function updateSetting(Request $request)
    {
        $request->validate([
            'first_name'   => 'nullable|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'profile_image'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'personal_email' => 'nullable|email|max:255',
            'home_address' => 'nullable|string|max:255',
            'province'         => 'nullable|string|max:255',
            'barangay'     => 'nullable|string|max:255',
            'zipcode'      => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'profession'   => 'nullable|string|max:255',
            'year_exp'     => 'nullable|string|max:20',

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
        $provider->personal_email= $request->personal_email;
        $provider->home_address     = $request->home_address;
        $provider->province        = $request->province;
        $provider->barangay     = $request->barangay;
        $provider->zipcode     = $request->zipcode;
        $provider->profession     = $request->profession;
        $provider->year_exp     = $request->year_exp;
        $provider->save();

        /*
        |--------------------------------------------------------------------------
        | Update Users Table
        |--------------------------------------------------------------------------
        */
        $user->name  = trim($request->first_name . ' ' . $request->last_name);
        $user->email = $request->email;
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
        $file_path = '/uploads/' . $path;
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true);
        }

        $file->move($directory, $file_name);
        return $file_path . '/' . $file_name;
    }
}
