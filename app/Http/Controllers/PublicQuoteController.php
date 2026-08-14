<?php

namespace App\Http\Controllers;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicQuoteController extends Controller
{
    public function show(Quote $quote): View
    {
        if ($quote->expires_at && $quote->expires_at->endOfDay()->isPast()) {
            return view('quotes.public-show', [
                'quote' => $quote->load('items'),
                'expired' => true,
            ]);
        }

        if ($quote->viewed_at === null) {
            $quote->increment('view_count');
            $quote->update(['viewed_at' => now()]);

            if ($quote->status === QuoteStatus::Sent) {
                $quote->update(['status' => QuoteStatus::Viewed]);
            }
        }

        return view('quotes.public-show', [
            'quote' => $quote->load('items'),
            'expired' => false,
        ]);
    }

    public function approve(Quote $quote): RedirectResponse
    {
        if ($quote->expires_at && $quote->expires_at->endOfDay()->isPast()) {
            return back()->withErrors(['quote' => 'This quote has expired and cannot be approved.']);
        }

        $quote->update(['status' => QuoteStatus::Approved]);

        return back()->with('status', 'Quote approved successfully.');
    }

    public function reject(Quote $quote): RedirectResponse
    {
        if ($quote->expires_at && $quote->expires_at->endOfDay()->isPast()) {
            return back()->withErrors(['quote' => 'This quote has expired and cannot be rejected.']);
        }

        $quote->update(['status' => QuoteStatus::Rejected]);

        return back()->with('status', 'Quote rejected.');
    }
}
