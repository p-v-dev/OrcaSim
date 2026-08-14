<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicQuoteController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/quotes', QuoteController::class)->except(['store']);
    Route::post('/quotes', [QuoteController::class, 'store'])->middleware('quote.limit')->name('quotes.store');
    Route::patch('/quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');
});

require __DIR__.'/auth.php';

Route::get('/q/{quote}', [PublicQuoteController::class, 'show'])->name('quotes.public.show');
Route::post('/q/{quote}/approve', [PublicQuoteController::class, 'approve'])->name('quotes.public.approve');
Route::post('/q/{quote}/reject', [PublicQuoteController::class, 'reject'])->name('quotes.public.reject');
