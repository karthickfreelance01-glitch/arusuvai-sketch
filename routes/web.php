<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Arusuvai Mess – static sketch routes
|--------------------------------------------------------------------------
| Pages are static Blade views fed from config/arusuvai.php.
| Only the Stripe checkout talks to an external service.
*/

// Language switch (English, Tamil, Malayalam, Hindi)
Route::get('lang/{locale}', function (string $locale) {
    if (array_key_exists($locale, config('arusuvai.languages'))) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang');

// Public website
Route::view('/', 'pages.home')->name('home');
Route::view('/menu', 'pages.menu')->name('menu');
Route::view('/book-now', 'pages.book-now')->name('book');
Route::view('/meal-change', 'pages.meal-change')->name('meal-change');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// Stripe payment
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

// Customer dashboard (static demo)
Route::prefix('account')->name('account.')->group(function () {
    Route::view('/', 'account.overview')->name('home');
    Route::view('/track', 'account.track')->name('track');
    Route::view('/subscription', 'account.subscription')->name('subscription');
    Route::view('/rewards', 'account.rewards')->name('rewards');
    Route::view('/notifications', 'account.notifications')->name('notifications');
    Route::view('/profile', 'account.profile')->name('profile');
});

// Admin dashboard (static demo)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.overview')->name('home');
    Route::view('/subscribers', 'admin.subscribers')->name('subscribers');
    Route::view('/deliveries', 'admin.deliveries')->name('deliveries');
    Route::view('/menu', 'admin.menu')->name('menu');
    Route::view('/payments', 'admin.payments')->name('payments');
    Route::view('/marketing', 'admin.marketing')->name('marketing');
    Route::view('/notifications', 'admin.notifications')->name('notifications');
});
