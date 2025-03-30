<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MaterialController;

// Главная страница
Route::view('/', 'welcome')->name('home');

// Аутентификация
Route::controller(AuthController::class)->group(function () {
    // Основные маршруты
    Route::middleware('guest')->group(function () {
        Route::get('register', 'showRegisterForm')->name('register');
        Route::post('register', 'register');
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
        
        // Восстановление пароля
        Route::get('forgot-password', 'showForgotPasswordForm')->name('password.request');
        Route::post('forgot-password', 'sendResetLinkEmail')->name('password.email');
        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
        Route::post('reset-password', 'resetPassword')->name('password.update');
    });
    
    // Подтверждение email
    Route::middleware('auth')->group(function () {
        Route::get('email/verify', 'showVerifyEmailNotice')->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', 'verifyEmail')
             ->middleware('signed')->name('verification.verify');
        Route::post('email/resend', 'resendVerifyEmail')
             ->middleware('throttle:6,1')->name('verification.send');
    });
    
    // Выход
    Route::post('logout', 'logout')->name('logout');
});

// Защищенные маршруты
Route::middleware(['auth', 'verified'])->group(function () {
    // Личный кабинет
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::match(['put', 'patch'], 'profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Мероприятия
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::post('/{event}/register', [EventController::class, 'register'])->name('register');
        Route::post('/{event}/cancel', [EventController::class, 'cancelRegistration'])->name('cancel');
    });
    
    // Сообщения
    Route::resource('messages', MessageController::class)->only(['index', 'store', 'show', 'destroy']);
    
    // Материалы
    Route::resource('materials', MaterialController::class)->only(['index', 'show']);
    
    // API
    Route::prefix('api')->middleware('auth:sanctum')->group(function () {
        Route::get('calendar/events', [EventController::class, 'calendarEvents']);
    });
    
    // Куратор
    Route::middleware('can:curator')->prefix('curator')->name('curator.')->group(function () {
        Route::get('dashboard', [ProfileController::class, 'curatorDashboard'])->name('dashboard');
        Route::get('students', [ProfileController::class, 'studentList'])->name('students.index');
    });
    
    // Админка
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('stats', [AdminController::class, 'stats'])->name('stats');
        
        Route::resources([
            'users' => AdminController::class,
            'events' => AdminController::class,
            'materials' => AdminController::class,
        ], ['except' => ['show']]);
    });
});