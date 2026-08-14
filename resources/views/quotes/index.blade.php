<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Quotes') }}</h2>
            <a href="{{ route('quotes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                {{ __('New Quote') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('status'))
                        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-md text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($quotes->isEmpty())
                        <p class="text-gray-500 text-center py-8">{{ __('No quotes yet.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Client') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Created') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($quotes as $quote)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $quote->client_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClasses = [
                                                        'draft' => 'bg-gray-100 text-gray-800',
                                                        'sent' => 'bg-blue-100 text-blue-800',
                                                        'viewed' => 'bg-yellow-100 text-yellow-800',
                                                        'approved' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $class = $statusClasses[$quote->status->value] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                                    {{ $quote->status->label() }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($quote->total, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $quote->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <a href="{{ route('quotes.show', $quote) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
                                                <a href="{{ route('quotes.edit', $quote) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                                @if ($quote->status->value === 'draft')
                                                    <form method="post" action="{{ route('quotes.send', $quote) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="text-green-600 hover:text-green-900">{{ __('Send') }}</button>
                                                    </form>
                                                @endif
                                                <form method="post" action="{{ route('quotes.destroy', $quote) }}" class="inline" x-data @submit.prevent="if(confirm('{{ __('Delete quote for') }} {{ $quote->client_name }}? {{ __('This cannot be undone.') }}')) $el.submit()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $quotes->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
