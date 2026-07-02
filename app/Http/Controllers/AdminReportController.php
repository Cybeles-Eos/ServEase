<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\Provider;
use App\Models\ServiceReport;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = trim((string) $request->input('search', ''));
        $dateFrom = (string) $request->input('date_from', '');
        $dateTo = (string) $request->input('date_to', '');

        $reports = ServiceReport::with([
                'customer',
                'provider.user',
                'service',
                'bookingInfo',
            ])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($dateFrom !== '', fn ($query) => $query->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo !== '', fn ($query) => $query->whereDate('created_at', '<=', $dateTo))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('reason', 'like', "%{$search}%")
                        ->orWhere('details', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('provider', function ($providerQuery) use ($search) {
                            $providerQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                                ->orWhereHas('user', fn ($userQuery) => $userQuery->where('email', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%"));
                        })
                        ->orWhereHas('customer', function ($customerQuery) use ($search) {
                            $customerQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                        })
                        ->orWhereHas('service', fn ($serviceQuery) => $serviceQuery->where('title', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalReports = ServiceReport::count();
        $openReports = ServiceReport::where('status', 'OPEN')->count();

        $providerHealthSummaries = $this->providerHealthSummaries();
        $subjectProviderCount = $providerHealthSummaries->where('is_subject', true)->count();
        $providerHealthById = $providerHealthSummaries->keyBy('provider_id');
        $providerSummaries = $providerHealthSummaries
            ->filter(fn ($provider) => $provider->max_count > 0)
            ->sortByDesc('max_count')
            ->take(8)
            ->values();

        $serviceSummaries = ServiceReport::query()
            ->join('tbl_services', 'tbl_services.id', '=', 'service_reports.service_id')
            ->join('tbl_providers', 'tbl_providers.id', '=', 'service_reports.provider_id')
            ->selectRaw('
                service_reports.service_id,
                service_reports.provider_id,
                tbl_services.title as service_title,
                COALESCE(NULLIF(TRIM(CONCAT(tbl_providers.first_name, " ", tbl_providers.last_name)), ""), "Provider") as provider_name,
                COUNT(*) as reports_count,
                MAX(service_reports.created_at) as latest_reported_at
            ')
            ->groupBy('service_reports.service_id', 'service_reports.provider_id', 'tbl_services.title', 'tbl_providers.first_name', 'tbl_providers.last_name')
            ->orderByDesc('reports_count')
            ->limit(8)
            ->get();

        $reasonBreakdown = ServiceReport::query()
            ->select('reason', DB::raw('COUNT(*) as reports_count'))
            ->groupBy('reason')
            ->orderByDesc('reports_count')
            ->limit(6)
            ->get();

        return view('admin.page.admin.reports.index', compact(
            'reports',
            'status',
            'search',
            'dateFrom',
            'dateTo',
            'totalReports',
            'openReports',
            'subjectProviderCount',
            'providerSummaries',
            'providerHealthById',
            'serviceSummaries',
            'reasonBreakdown'
        ));
    }

    public function deactivateProvider(Provider $provider)
    {
        $health = $provider->accountHealth();

        if (! $health['is_subject']) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Action Not Available',
                'message' => 'This provider has not reached the account health threshold for deactivation review.',
                'type' => 'warning',
            ]);
        }

        if (! $provider->user) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Provider Account Missing',
                'message' => 'No linked user account was found for this provider.',
                'type' => 'error',
            ]);
        }

        if (! $provider->user->is_active) {
            return redirect()->back()->with('flash_message', [
                'title' => 'Account Already Disabled',
                'message' => 'This provider account is already inactive.',
                'type' => 'warning',
            ]);
        }

        $provider->user->is_active = false;
        $provider->user->save();

        AuditLogService::record(
            'Reports',
            'deactivated',
            'Deactivated provider account after reaching the account health threshold.',
            $provider,
            'Provider #' . $provider->id,
            ['user_id' => $provider->user->id, 'account_health' => $health]
        );

        return redirect()->back()->with('flash_message', [
            'title' => 'Provider Account Deactivated',
            'message' => 'The account was disabled after reaching the account health threshold.',
            'type' => 'success',
        ]);
    }

    private function providerHealthSummaries()
    {
        $reportCounts = ServiceReport::query()
            ->select('provider_id', DB::raw('COUNT(*) as reports_count'))
            ->groupBy('provider_id');

        $declineCounts = BookingRequest::query()
            ->select('provider_id', DB::raw('COUNT(*) as declined_count'))
            ->where('status', 'DECLINED')
            ->groupBy('provider_id');

        $cancellationCounts = BookingRequest::query()
            ->select('provider_id', DB::raw('COUNT(*) as provider_cancelled_count'))
            ->where('status', 'CANCELLED')
            ->where('cancelled_by', 'provider')
            ->groupBy('provider_id');

        $limit = Provider::ACCOUNT_HEALTH_LIMIT;

        return Provider::query()
            ->leftJoin('users', 'users.id', '=', 'tbl_providers.user_id')
            ->leftJoinSub($reportCounts, 'report_counts', function ($join) {
                $join->on('report_counts.provider_id', '=', 'tbl_providers.id');
            })
            ->leftJoinSub($declineCounts, 'decline_counts', function ($join) {
                $join->on('decline_counts.provider_id', '=', 'tbl_providers.id');
            })
            ->leftJoinSub($cancellationCounts, 'cancellation_counts', function ($join) {
                $join->on('cancellation_counts.provider_id', '=', 'tbl_providers.id');
            })
            ->selectRaw('
                tbl_providers.id as provider_id,
                tbl_providers.user_id,
                users.is_active as user_is_active,
                COALESCE(NULLIF(TRIM(CONCAT(tbl_providers.first_name, " ", tbl_providers.last_name)), ""), users.name, "Provider") as provider_name,
                users.email as provider_email,
                COALESCE(report_counts.reports_count, 0) as reports_count,
                COALESCE(decline_counts.declined_count, 0) as declined_count,
                COALESCE(cancellation_counts.provider_cancelled_count, 0) as provider_cancelled_count
            ')
            ->get()
            ->map(function ($provider) use ($limit) {
                $provider->reports_count = (int) $provider->reports_count;
                $provider->declined_count = (int) $provider->declined_count;
                $provider->provider_cancelled_count = (int) $provider->provider_cancelled_count;
                $provider->max_count = max(
                    $provider->reports_count,
                    $provider->declined_count,
                    $provider->provider_cancelled_count
                );
                $provider->max_percentage = min(100, (int) round(($provider->max_count / $limit) * 100));
                $provider->is_subject = $provider->max_count >= $limit;
                $provider->risk_label = $provider->is_subject
                    ? 'Subject to Deactivation Review'
                    : ($provider->max_count >= 10 ? 'Needs Review' : 'Monitoring');
                $provider->risk_class = $provider->is_subject
                    ? 'is-danger'
                    : ($provider->max_count >= 10 ? 'is-warning' : 'is-normal');

                return $provider;
            });
    }
}
