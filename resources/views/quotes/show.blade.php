<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $quote->client_name }}</h2>
            <div class="flex items-center gap-2">
                @if ($quote->status->value === 'draft')
                    <form method="post" action="{{ route('quotes.send', $quote) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <x-primary-button>{{ __('Send') }}</x-primary-button>
                    </form>
                @endif
                <a href="{{ route('quotes.edit', $quote) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                    {{ __('Edit') }}
                </a>
                <form method="post" action="{{ route('quotes.destroy', $quote) }}" class="inline" x-data @submit.prevent="if(confirm('{{ __('Delete this quote?') }}')) $el.submit()">
                    @csrf
                    @method('DELETE')
                    <x-danger-button>{{ __('Delete') }}</x-danger-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <button onclick="history.back()" class="text-sm text-gray-600 hover:text-gray-900">&larr; Back</button>
            </div>
            @if (session('status'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">

                    @php
                        $statusClasses = [
                            'draft' => 'bg-gray-100 text-gray-800',
                            'sent' => 'bg-blue-100 text-blue-800',
                            'viewed' => 'bg-yellow-100 text-yellow-800',
                            'approved' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                        ];
                    @endphp

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $quote->client_name }}</h3>
                            <p class="text-sm text-gray-500">{{ $quote->client_email }}</p>
                            @if ($quote->expires_at)
                                <p class="text-sm text-gray-500">{{ __('Expires:') }} {{ $quote->expires_at->format('M d, Y') }}</p>
                            @endif
                        </div>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClasses[$quote->status->value] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $quote->status->label() }}
                        </span>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Description') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">{{ __('Qty') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-32">{{ __('Unit Price') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-32">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($quote->items as $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item->description }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">${{ number_format($item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right text-sm font-semibold text-gray-900">{{ __('Total') }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900">${{ number_format($quote->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <div>
                            {{ __('Created:') }} {{ $quote->created_at->format('M d, Y \a\t H:i') }}
                            @if ($quote->viewed_at)
                                &middot; {{ __('Viewed:') }} {{ $quote->viewed_at->format('M d, Y \a\t H:i') }}
                            @endif
                        </div>
                        <div class="flex items-center gap-6">
                            @if (in_array($quote->status->value, ['sent', 'viewed', 'approved']))
                                <a href="{{ route('quotes.public.show', $quote) }}?preview=1" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    {{ __('Preview as Client') }}
                                </a>
                                <button onclick="navigator.clipboard.writeText('{{ route('quotes.public.show', $quote) }}').then(() => this.textContent='{{ __('Copied!') }}')" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    {{ __('Copy Share Link') }}
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
