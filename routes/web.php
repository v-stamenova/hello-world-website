<?php

use App\Livewire\Pages\Internal\Partner as PartnerPages;
use App\Models\Partner;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->name('internal.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/internal/partners', PartnerPages\Index::class)
        ->middleware('can:viewAny,' . Partner::class)
        ->name('partners.index');
});
