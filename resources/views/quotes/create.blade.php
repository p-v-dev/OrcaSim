<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('New Quote') }}</h2>
            <a href="{{ route('quotes.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Back to Quotes') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (auth()->user()->plan_type === 'free')
                        <div class="mb-4 px-4 py-3 bg-gray-100 rounded-lg text-sm text-gray-700">
                            {{ __('Free plan') }} — {{ $quotaUsed }}/{{ $quotaLimit }} {{ __('quotes used this month') }}
                            @if ($quotaUsed >= $quotaLimit)
                                <span class="text-red-600 font-medium block mt-1">{{ __('You have reached your monthly limit.') }}</span>
                            @endif
                        </div>
                    @endif

                    <x-input-error :messages="$errors->get('quote')" class="mb-4" />

                    <form method="post" action="{{ route('quotes.store') }}" class="space-y-6" x-data="quoteForm(@json(old('items', [])))">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="client_name" :value="__('Client Name')" />
                                <x-text-input id="client_name" name="client_name" type="text" class="mt-1 block w-full" :value="old('client_name')" required />
                                <x-input-error :messages="$errors->get('client_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="client_email" :value="__('Client Email')" />
                                <x-text-input id="client_email" name="client_email" type="email" class="mt-1 block w-full" :value="old('client_email')" required />
                                <x-input-error :messages="$errors->get('client_email')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="expires_at" :value="__('Expires At')" />
                                <x-text-input id="expires_at" name="expires_at" type="date" class="mt-1 block w-full" :value="old('expires_at')" />
                                <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Line Items') }}</h3>
                                <x-secondary-button type="button" @click="addItem()">{{ __('Add Item') }}</x-secondary-button>
                            </div>
                            <x-input-error :messages="$errors->get('items')" class="mt-2" />

                            <table class="mt-4 min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Description') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">{{ __('Qty') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-32">{{ __('Unit Price') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-32">{{ __('Total') }}</th>
                                        <th class="px-4 py-3 w-16"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr>
                                            <td class="px-4 py-2">
                                                <x-text-input type="text" x-model="item.description" x-bind:name="'items[' + index + '][description]'" class="block w-full" required />
                                            </td>
                                            <td class="px-4 py-2">
                                                <x-text-input type="number" x-model.number="item.quantity" x-bind:name="'items[' + index + '][quantity]'" class="block w-full" min="1" required />
                                            </td>
                                            <td class="px-4 py-2">
                                                <x-text-input type="number" x-model.number="item.unit_price" x-bind:name="'items[' + index + '][unit_price]'" class="block w-full" step="0.01" min="0" required />
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-900 font-medium" x-text="lineTotal(item).toFixed(2)"></td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-900" x-show="items.length > 1">
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>

                            <div class="mt-4 text-right text-lg font-semibold text-gray-900">
                                {{ __('Total:') }} <span x-text="grandTotal().toFixed(2)"></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Quote') }}</x-primary-button>
                            <a href="{{ route('quotes.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
