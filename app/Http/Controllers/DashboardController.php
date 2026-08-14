<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $quotaUsed = Quote::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('dashboard', [
            'totalQuotes' => Quote::where('user_id', $userId)->count(),
            'viewedQuotes' => Quote::where('user_id', $userId)->whereNotNull('viewed_at')->count(),
            'pendingQuotes' => Quote::where('user_id', $userId)->whereIn('status', ['sent', 'viewed'])->count(),
            'quotaUsed' => $quotaUsed,
            'quotaLimit' => 5,
        ]);
    }
}
