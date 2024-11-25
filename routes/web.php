<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\LogoutComponent;
use App\Livewire\LoginComponent;
use App\Livewire\HomeComponent;
use App\Livewire\StaffComponent;
use App\Livewire\PatientComponent;
use App\Livewire\RekamMedisComponent;
use App\Livewire\RekamMedisDetialComponents;

// Route::get('/', function () { return view('welcome'); });

Route::get('/logout', LogoutComponent::class)->name('logout');
Route::middleware(['guest'])->group(function () {
  Route::get('/login', LoginComponent::class)->name('login');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/', HomeComponent::class)->name('home');
  Route::get('/staff', StaffComponent::class)->name('staff');
  Route::get('/patient', PatientComponent::class)->name('patient');
  Route::get('/rekam-medis', RekamMedisComponent::class)->name('rekam-medis');
  Route::get('/rekam-medis/detail/{id}', RekamMedisDetialComponents::class)->name('rekam-medis-detail');
});