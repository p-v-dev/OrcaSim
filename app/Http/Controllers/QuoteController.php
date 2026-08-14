<?php

namespace App\Http\Controllers;

use App\Enums\QuoteStatus;
use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuoteController extends Controller
{
    public function index(): View
    {
        $quotes = Quote::where('user_id', auth()->id())
            ->withCount('items')
            ->latest()
            ->paginate(15);

        return view('quotes.index', compact('quotes'));
    }

    public function show(Quote $quote): View
    {
        $this->authorizeAccess($quote);

        return view('quotes.show', compact('quote'));
    }

    public function create(): View
    {
        $quotaUsed = Quote::where('user_id', auth()->id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('quotes.create', [
            'quotaUsed' => $quotaUsed,
            'quotaLimit' => 5,
        ]);
    }

    public function store(StoreQuoteRequest $request): RedirectResponse
    {
        $quote = Quote::create([
            'user_id' => auth()->id(),
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'expires_at' => $request->expires_at,
        ]);

        $total = 0;
        foreach ($request->items as $item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $quote->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $lineTotal,
            ]);
            $total += $lineTotal;
        }

        $quote->update(['total' => $total]);

        return to_route('quotes.index')->with('status', 'Quote created.');
    }

    public function edit(Quote $quote): View
    {
        $this->authorizeAccess($quote);

        return view('quotes.edit', compact('quote'));
    }

    public function update(StoreQuoteRequest $request, Quote $quote): RedirectResponse
    {
        $this->authorizeAccess($quote);

        $quote->update([
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'expires_at' => $request->expires_at,
        ]);

        $quote->items()->delete();

        $total = 0;
        foreach ($request->items as $item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $quote->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'line_total' => $lineTotal,
            ]);
            $total += $lineTotal;
        }

        $quote->update(['total' => $total]);

        return to_route('quotes.index')->with('status', 'Quote updated.');
    }

    public function send(Quote $quote): RedirectResponse
    {
        $this->authorizeAccess($quote);

        $quote->update(['status' => QuoteStatus::Sent]);

        return to_route('quotes.show', $quote)->with('status', 'Quote sent.');
    }

    public function destroy(Quote $quote): RedirectResponse
    {
        $this->authorizeAccess($quote);
        $quote->delete();

        return to_route('quotes.index')->with('status', 'Quote deleted.');
    }

    private function authorizeAccess(Quote $quote): void
    {
        if ($quote->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
