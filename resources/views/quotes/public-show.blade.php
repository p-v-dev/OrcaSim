<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Quote') }} — {{ $quote->client_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-3xl w-full bg-white rounded-xl shadow-lg p-8 space-y-6">

            @php
                $statusColors = [
                    'draft' => 'bg-gray-100 text-gray-700',
                    'sent' => 'bg-blue-100 text-blue-700',
                    'viewed' => 'bg-yellow-100 text-yellow-700',
                    'approved' => 'bg-green-100 text-green-700',
                    'rejected' => 'bg-red-100 text-red-700',
                ];
            @endphp

            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <h1 class="text-xl font-semibold text-gray-900">{{ $quote->client_name }}</h1>
                    <p class="text-sm text-gray-500">{{ $quote->client_email }}</p>
                    @if ($quote->expires_at)
                        <p class="text-sm text-gray-500">Expires: {{ $quote->expires_at->format('M d, Y') }}</p>
                    @endif
                </div>
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$quote->status->value] }}">
                    {{ $quote->status->label() }}
                </span>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <th class="pb-2 pr-4">Description</th>
                        <th class="pb-2 pr-4 w-20">Qty</th>
                        <th class="pb-2 pr-4 w-28">Unit Price</th>
                        <th class="pb-2 w-28 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($quote->items as $item)
                        <tr>
                            <td class="py-3 pr-4 text-gray-900">{{ $item->description }}</td>
                            <td class="py-3 pr-4 text-gray-600">{{ $item->quantity }}</td>
                            <td class="py-3 pr-4 text-gray-600">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="py-3 text-right text-gray-900 font-medium">${{ number_format($item->line_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-300">
                        <td colspan="3" class="pt-3 text-right text-sm font-semibold text-gray-900">Total</td>
                        <td class="pt-3 text-right text-base font-bold text-gray-900">${{ number_format($quote->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            @if ($quote->expires_at && $quote->expires_at->endOfDay()->isPast())
                <div class="text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg">
                    This quote has expired.
                </div>
            @elseif (in_array($quote->status->value, ['approved', 'rejected']))
                <div class="text-center py-4 text-sm font-medium text-gray-700 bg-gray-50 rounded-lg">
                    This quote has been {{ $quote->status->label() }}.
                </div>
            @elseif (in_array($quote->status->value, ['sent', 'viewed']) && ! request()->has('preview'))
                <div class="flex justify-center gap-4 pt-2">
                    <form method="post" action="{{ route('quotes.public.approve', $quote) }}">
                        @csrf
                        <button type="submit" class="px-8 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                            Approve
                        </button>
                    </form>
                    <form method="post" action="{{ route('quotes.public.reject', $quote) }}">
                        @csrf
                        <button type="submit" class="px-8 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                            Reject
                        </button>
                    </form>
                </div>
            @endif

            <p class="text-center text-xs text-gray-400 pt-2">
                Powered by OrcaLink
            </p>

        </div>
    </div>
</body>
</html>
