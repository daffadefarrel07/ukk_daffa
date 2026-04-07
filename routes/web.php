<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $user = auth()->user();
    if ($user && $user->siswa) {
        return redirect()->route('siswa.dashboard');
    }
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/siswa/dashboard', [StudentController::class, 'dashboard'])->middleware('auth')->name('siswa.dashboard');

// Aspirasi routes for siswa
Route::get('/siswa/aspirasi/create', [StudentController::class, 'createAspirasi'])->middleware('auth')->name('siswa.aspirasi.create');
Route::post('/siswa/aspirasi', [StudentController::class, 'storeAspirasi'])->middleware('auth')->name('siswa.aspirasi.store');

// Unified dashboard route: render siswa dashboard for siswa or show same layout for other users
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (! $user) {
        return redirect()->route('login');
    }

    // If user is admin, direct to admin dashboard
    if (!empty($user->is_admin)) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->siswa) {
        return redirect()->route('siswa.dashboard');
    }

    // For non-siswa users, render the same siswa dashboard view with safe defaults
    $siswa = (object) [
        'nis' => $user->email ?? '—',
        'kelas' => '-',
    ];

    $items = collect();
    $avgProgress = 0;
    $completionPercent = 0;
    $aspirasiCount = 0;
    $latestFeedback = null;

    return view('siswa.dashboard', compact('siswa','items','avgProgress','completionPercent','aspirasiCount','latestFeedback'));
})->middleware('auth')->name('dashboard');

// Admin dashboard
use App\Http\Controllers\AdminController;
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logoutAdmin'])->name('admin.logout');
    // Admin aspirasi pages
    Route::get('/admin/aspirasi', [AdminController::class, 'listAspirasi'])->name('admin.aspirasi.list');
    Route::get('/admin/aspirasi/status', [AdminController::class, 'aspirasiStatus'])->name('admin.aspirasi.status');
    Route::get('/admin/aspirasi/feedback', [AdminController::class, 'aspirasiFeedback'])->name('admin.aspirasi.feedback');
    Route::get('/admin/aspirasi/{id}/edit', [AdminController::class, 'editAspirasi'])->name('admin.aspirasi.edit');
    Route::post('/admin/aspirasi/{id}/update', [AdminController::class, 'updateAspirasi'])->name('admin.aspirasi.update');
});

// Admin login (hardcoded credentials)
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'doLogin'])->name('admin.login.post');

// Note: `user.dashboard` route removed — non-siswa users are redirected via /dashboard
