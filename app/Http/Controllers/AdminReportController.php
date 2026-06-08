<?php

namespace App\Http\Controllers;

use App\Models\ServiceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $reports = ServiceReport::with([
                'customer',
                'provider.user',
                'service',
                'bookingInfo',
            ])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalReports = ServiceReport::count();
        $openReports = ServiceReport::where('status', 'OPEN')->count();

        $subjectProviderCount = ServiceReport::query()
            ->select('provider_id')
            ->groupBy('provider_id')
            ->havingRaw('COUNT(*) >= 20')
            ->get()
            ->count();

        $providerSummaries = ServiceReport::query()
            ->join('tbl_providers', 'tbl_providers.id', '=', 'service_reports.provider_id')
            ->leftJoin('users', 'users.id', '=', 'tbl_providers.user_id')
            ->selectRaw('
                service_reports.provider_id,
                COALESCE(NULLIF(TRIM(CONCAT(tbl_providers.first_name, " ", tbl_providers.last_name)), ""), users.name, "Provider") as provider_name,
                users.email as provider_email,
                COUNT(*) as reports_count,
                COUNT(DISTINCT service_reports.service_id) as reported_services_count,
                MAX(service_reports.created_at) as latest_reported_at
            ')
            ->groupBy('service_reports.provider_id', 'tbl_providers.first_name', 'tbl_providers.last_name', 'users.name', 'users.email')
            ->orderByDesc('reports_count')
            ->limit(8)
            ->get();

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
            'totalReports',
            'openReports',
            'subjectProviderCount',
            'providerSummaries',
            'serviceSummaries',
            'reasonBreakdown'
        ));
    }
}
