<?php

namespace App\Http\Middleware;

use App\Models\Quote;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckQuoteLimit
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->plan_type === 'free') {
            $monthlyCount = Quote::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            if ($monthlyCount >= 5) {
                return back()->withErrors(['quote' => 'Free plan limit reached (5 quotes/month). Upgrade to paid.']);
            }
        }

        return $next($request);
    }
}
