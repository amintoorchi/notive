<?php

use App\Http\Controllers\AgentTestController;
use App\Http\Controllers\ServerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('note.index');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('notes', 'pages.note.index')->name('note.index');
    Route::livewire('notes/editor/{note?}', 'pages.note.editor')->name('note.editor');
});

require __DIR__.'/settings.php';
