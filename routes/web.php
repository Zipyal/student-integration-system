<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MaterialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Все маршруты, требующие аутентификации, помещены в middleware 'auth'
| Админ-маршруты дополнительно защищены middleware 'can:admin'
*/

// ==================== Аутентификация ====================
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'showRegisterForm')->name('register');
    Route::post('register', 'register');
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
    
    // Восстановление пароля
    Route::get('forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('forgot-password', 'sendResetLinkEmail')->name('password.email');
    Route::get('reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('reset-password', 'resetPassword')->name('password.update');
});

// ==================== Защищенные маршруты ====================
Route::middleware('auth')->group(function () {
    
    // Личный кабинет
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // ======= Мероприятия =======
    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('events.index');
        Route::get('/{event}', [EventController::class, 'show'])->name('events.show');
        Route::post('/{event}/register', [EventController::class, 'register'])->name('events.register');
        Route::post('/{event}/cancel', [EventController::class, 'cancelRegistration'])->name('events.cancel');
    });
    
    // ======= Сообщения =======
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('messages.index');
        Route::post('/', [MessageController::class, 'store'])->name('messages.store');
        Route::get('/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });
    
    // ======= Адаптационные материалы =======
    Route::resource('materials', MaterialController::class)->only(['index', 'show']);
    
    // ======= Админ-панель =======
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        // Дашборд
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Управление пользователями
        Route::resource('users', AdminController::class)->except(['show']);
        
        // Управление мероприятиями
        Route::resource('events', AdminController::class)->except(['show']);
        
        // Управление материалами
        Route::resource('materials', AdminController::class)->except(['show']);
        
        // Статистика
        Route::get('stats', [AdminController::class, 'stats'])->name('stats');
    });
    
    // ======= API для календаря =======
    Route::prefix('api')->group(function () {
        Route::get('calendar/events', [EventController::class, 'calendarEvents'])->name('api.calendar.events');
    });
});

// Главная страница (можно добавить позже)
Route::get('/', function () {
    return view('welcome');
})->name('home');
