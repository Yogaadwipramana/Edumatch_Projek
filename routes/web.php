<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ChatController;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard redirect
Route::get('/dashboard', function () {
    if (!auth()->check()) return redirect()->route('login');
    return redirect('/redirect');
})->name('dashboard');

Route::get('/redirect', function () {
    $role = auth()->user()->role;
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru' => redirect()->route('guru.dashboard'),
        'murid' => redirect()->route('murid.dashboard'),
        default => abort(403),
    };
})->middleware('auth');

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

// Guru
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/guru/profile', [GuruController::class, 'profile'])->name('guru.profile');
    Route::put('/guru/profile/update', [GuruController::class, 'updateProfile'])->name('guru.profile.update');
    
    // Request management
    Route::get('/guru/requests', [GuruController::class, 'requests'])->name('guru.requests');
    Route::get('/guru/requests/{id}', [GuruController::class, 'showRequest'])->name('guru.requests.show');
    Route::post('/guru/requests/{id}/accept', [GuruController::class, 'acceptRequest'])->name('guru.requests.accept');
    Route::post('/guru/requests/{id}/reject', [GuruController::class, 'rejectRequest'])->name('guru.requests.reject');
    
    // Negotiation
    Route::post('/guru/negotiations/{id}', [GuruController::class, 'sendNegotiation'])->name('guru.negotiations.send');
    Route::post('/guru/negotiations/{id}/deal', [GuruController::class, 'dealNegotiation'])->name('guru.negotiations.deal');
});

// Murid
Route::middleware(['auth', 'role:murid'])->group(function () {
    Route::get('/murid/dashboard', [MuridController::class, 'dashboard'])->name('murid.dashboard');
    Route::get('/murid/profile', [MuridController::class, 'profile'])->name('murid.profile');
    Route::put('/murid/profile/update', [MuridController::class, 'updateProfile'])->name('murid.profile.update');
    
    // Guru features
    Route::get('/gurus', [GuruController::class, 'index'])->name('guru.index');
    Route::get('/gurus/{id}', [GuruController::class, 'show'])->name('guru.show');
    
    // Request management
    Route::get('/murid/requests', [MuridController::class, 'requests'])->name('murid.requests');
    Route::get('/murid/requests/create/{guru_id}', [MuridController::class, 'createRequest'])->name('murid.requests.create');
    Route::post('/murid/requests/store/{guru_id}', [MuridController::class, 'storeRequest'])->name('murid.requests.store');
    Route::get('/murid/requests/{id}', [MuridController::class, 'showRequest'])->name('murid.requests.show');
    
    // Negotiation
    Route::post('/murid/negotiations/{id}', [MuridController::class, 'sendNegotiation'])->name('murid.negotiations.send');
    Route::post('/murid/negotiations/{id}/complete', [MuridController::class, 'completeNegotiation'])->name('murid.negotiations.complete');
});
