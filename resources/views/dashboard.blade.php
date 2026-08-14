<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-500">{{ __('Total Quotes') }}</div>
                        <div class="text-2xl font-bold">{{ $totalQuotes }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-500">{{ __('Viewed') }}</div>
                        <div class="text-2xl font-bold">{{ $viewedQuotes }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-sm text-gray-500">{{ __('Pending Response') }}</div>
                        <div class="text-2xl font-bold">{{ $pendingQuotes }}</div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->plan_type === 'free')
                <div class="mb-4 px-4 py-3 bg-gray-100 rounded-lg text-sm text-gray-700 text-center">
                    {{ __('Free plan') }} — {{ $quotaUsed }}/{{ $quotaLimit }} {{ __('quotes used this month') }}
                    @if ($quotaUsed >= $quotaLimit)
                        <span class="text-red-600 font-medium block mt-1">{{ __('Upgrade to create more quotes.') }}</span>
                    @endif
                </div>
            @endif

            <div class="mt-6 text-center">
                <a href="{{ route('quotes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    {{ __('Create New Quote') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
