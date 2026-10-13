<?php

namespace App\Http\Controllers;

use App\Enums\DonationStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Display the signed-in user's donation statistics.
 */
class DashboardController extends Controller
{
    /**
     * Show completed donation totals for the current user.
     */
    public function index(Request $request): View
    {
        $now = now();
        $startOfThisYear = $now->copy()->startOfYear();
        $startOfNextYear = $startOfThisYear->copy()->addYear();
        $startOfLastYear = $startOfThisYear->copy()->subYear();
        $completedUsdDonations = $request->user()
            ->donations()
            ->where('status', DonationStatus::Completed->value)
            ->where('currency', 'USD');

        return view('account.dashboard', [
            'totalDonations' => (clone $completedUsdDonations)->count(),
            'lastYearAmount' => (clone $completedUsdDonations)
                ->where('created_at', '>=', $startOfLastYear)
                ->where('created_at', '<', $startOfThisYear)
                ->sum('amount'),
            'thisYearAmount' => (clone $completedUsdDonations)
                ->where('created_at', '>=', $startOfThisYear)
                ->where('created_at', '<', $startOfNextYear)
                ->where('created_at', '<=', $now)
                ->sum('amount'),
            'lastYear' => $startOfLastYear->year,
            'thisYear' => $startOfThisYear->year,
        ]);
    }
}
