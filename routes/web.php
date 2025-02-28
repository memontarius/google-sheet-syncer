<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\FetchController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;


Route::get('/', [EntryController::class, 'index'])->name('entry.index');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::patch('/settings', [SettingsController::class, 'store'])->name('settings.store');

Route::post('/generate', [EntryController::class, 'generate'])->name('entry.generate');
Route::post('/clear', [EntryController::class, 'clear'])->name('entry.clear');

Route::get('/entries/create', [EntryController::class, 'create'])->name('entry.create');
Route::get('/entries/{entry}', [EntryController::class, 'show'])->name('entry.show');
Route::get('/entries/{entry}/edit', [EntryController::class, 'edit'])->name('entry.edit');
Route::patch('/entries/{entry}', [EntryController::class, 'update'])->name('entry.update');
Route::post('/entries', [EntryController::class, 'store'])->name('entry.store');
Route::delete('/entries/{entry}', [EntryController::class, 'destroy'])->name('entry.destroy');

Route::get('/fetch/{count?}', FetchController::class)->name('fetch')
    ->where(['count' => '[0-9]+'])
    ->defaults('count', 0);
