<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

// Installation Routes
Route::prefix('install')->group(function () {
    Route::get('/', [InstallController::class, 'index'])->name('install.index');
    Route::post('/database', [InstallController::class, 'database'])->name('install.database');
    Route::post('/admin', [InstallController::class, 'admin'])->name('install.admin');
    Route::post('/complete', [InstallController::class, 'complete'])->name('install.complete');
});

// Language Routes
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['bn', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/members', [HomeController::class, 'members'])->name('members');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{id}', [HomeController::class, 'newsDetail'])->name('news.detail');
Route::get('/activities', [HomeController::class, 'activities'])->name('activities');
Route::get('/notices', [HomeController::class, 'notices'])->name('notices');
Route::get('/donations', [HomeController::class, 'donations'])->name('donations');
Route::post('/donations/store', [HomeController::class, 'storeDonation'])->name('donations.store');
Route::get('/tracking', [HomeController::class, 'tracking'])->name('tracking');
Route::post('/tracking/search', [HomeController::class, 'trackingSearch'])->name('tracking.search');

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'doRegister'])->name('register.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
});

// User Routes
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('user.profile');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/id-card', [DashboardController::class, 'idCard'])->name('user.id-card');
    Route::get('/id-card/download/{format}', [DashboardController::class, 'downloadIdCard'])->name('user.id-card.download');
    Route::get('/dps', [DashboardController::class, 'dps'])->name('user.dps');
    Route::post('/dps/apply', [DashboardController::class, 'applyDps'])->name('user.dps.apply');
    Route::get('/loan', [DashboardController::class, 'loan'])->name('user.loan');
    Route::post('/loan/apply', [DashboardController::class, 'applyLoan'])->name('user.loan.apply');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('user.transactions');
    Route::get('/chat', [DashboardController::class, 'chat'])->name('user.chat');
    Route::post('/chat/send', [DashboardController::class, 'sendChat'])->name('user.chat.send');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('users', 'Admin\UserController');
    Route::post('users/{id}/approve', [AdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('users/{id}/reject', [AdminController::class, 'rejectUser'])->name('admin.users.reject');
    Route::resource('news', 'Admin\NewsController');
    Route::resource('notices', 'Admin\NoticeController');
    Route::resource('activities', 'Admin\ActivityController');
    Route::resource('dps', 'Admin\DpsController');
    Route::resource('loans', 'Admin\LoanController');
    Route::post('loans/{id}/approve', [AdminController::class, 'approveLoan'])->name('admin.loans.approve');
    Route::post('loans/{id}/reject', [AdminController::class, 'rejectLoan'])->name('admin.loans.reject');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::resource('features', 'Admin\FeatureController');
});
