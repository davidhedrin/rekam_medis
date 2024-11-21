<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\LogoutComponent;
use App\Livewire\LoginComponent;
use App\Livewire\HomeComponent;
use App\Livewire\StaffComponent;

// Route::get('/', function () { return view('welcome'); });

Route::get('/logout', LogoutComponent::class)->name('logout');
Route::middleware(['guest'])->group(function () {
  Route::get('/login', LoginComponent::class)->name('login');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/', HomeComponent::class)->name('home');
  Route::get('/staff', StaffComponent::class)->name('staff');
});