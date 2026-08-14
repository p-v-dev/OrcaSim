<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'OrcaLink') }} - Quotes for Freelancers</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <nav class="bg-white/80 backdrop-blur-sm border-b border-gray-200 fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <a href="/" class="text-2xl font-bold text-indigo-600 tracking-tight">OrcaLink</a>
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Log in</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Get started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="pt-16">
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 text-center">
                <h1 class="text-4xl sm:text-6xl font-bold tracking-tight text-gray-900">Professional quotes,<br>delivered instantly.</h1>
                <p class="mt-6 text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">Create, share, and track quotes with your clients. No more PDF attachments — just a link and a click.</p>
                <div class="mt-10 flex gap-4 justify-center">
                    @auth
                        <a href="{{ route('quotes.create') }}" class="rounded-lg bg-indigo-600 px-8 py-3 text-sm font-semibold text-white hover:bg-indigo-700 transition">Create your first quote</a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-8 py-3 text-sm font-semibold text-white hover:bg-indigo-700 transition">Start for free</a>
                        <a href="{{ route('login') }}" class="rounded-lg border border-gray-300 px-8 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Log in</a>
                    @endauth
                </div>
            </section>

            <section class="bg-white py-24">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center text-gray-900">Everything you need to quote</h2>
                    <p class="mt-4 text-lg text-gray-600 text-center max-w-xl mx-auto">Simple tools that make sending quotes feel like a superpower.</p>
                    <div class="mt-16 grid gap-8 sm:grid-cols-3">
                        <div class="rounded-xl border border-gray-200 p-8 text-center hover:shadow-md transition">
                            <div class="mx-auto w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="mt-6 text-lg font-semibold text-gray-900">Quotes with line items</h3>
                            <p class="mt-2 text-sm text-gray-600">Add items, quantities, and prices. Preview before you send.</p>
                        </div>
                        <div class="rounded-xl border border-gray-200 p-8 text-center hover:shadow-md transition">
                            <div class="mx-auto w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            </div>
                            <h3 class="mt-6 text-lg font-semibold text-gray-900">Share via public link</h3>
                            <p class="mt-2 text-sm text-gray-600">No PDFs, no email attachments. Just a link your client can open anywhere.</p>
                        </div>
                        <div class="rounded-xl border border-gray-200 p-8 text-center hover:shadow-md transition">
                            <div class="mx-auto w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <h3 class="mt-6 text-lg font-semibold text-gray-900">Track views & approvals</h3>
                            <p class="mt-2 text-sm text-gray-600">Know when your client opens the quote and get notified when they approve.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-24">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-900">Simple pricing</h2>
                    <p class="mt-4 text-lg text-gray-600">Start free, upgrade when you outgrow it.</p>
                    <div class="mt-16 grid gap-8 sm:grid-cols-2 max-w-2xl mx-auto">
                        <div class="rounded-xl border border-gray-200 bg-white p-8">
                            <h3 class="text-lg font-semibold text-gray-900">Free</h3>
                            <p class="mt-4 text-4xl font-bold text-gray-900">$0</p>
                            <p class="mt-1 text-sm text-gray-500">forever</p>
                            <ul class="mt-8 space-y-3 text-left text-sm">
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>5 quotes per month</li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Public share links</li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>View & approval tracking</li>
                            </ul>
                            <a href="{{ route('register') }}" class="mt-8 block w-full rounded-lg border border-gray-300 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Get started</a>
                        </div>
                        <div class="rounded-xl border-2 border-indigo-600 bg-white p-8 relative">
                            <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full">Popular</span>
                            <h3 class="text-lg font-semibold text-gray-900">Pro</h3>
                            <p class="mt-4 text-4xl font-bold text-gray-900">$9</p>
                            <p class="mt-1 text-sm text-gray-500">per month</p>
                            <ul class="mt-8 space-y-3 text-left text-sm">
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Unlimited quotes</li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Public share links</li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>View & approval tracking</li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Priority support</li>
                            </ul>
                            <a href="{{ route('register') }}" class="mt-8 block w-full rounded-lg bg-indigo-600 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition">Get started</a>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="border-t border-gray-200 bg-white py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'OrcaLink') }}. All rights reserved.</p>
                </div>
            </footer>
        </main>
    </body>
</html>
