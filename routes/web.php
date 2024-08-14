<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

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

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/details/{slug}',[EventController::class,'index'])->name('detail');
Route::post('/checkout/event/{slug}', [EventController::class,'checkout'])->name('checkout');
Route::post('/checkout/pay', [EventController::class,'checkoutPay'])->name('checkout-pay');
Route::get('/checkout-success', [EventController::class,'checkoutSuccess'])->name('checkout-success');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Code untuk routing admin
        Route::resource('events', AdminEventController::class);
        Route::resource('events.tickets', AdminTicketController::class);

        Route::get('pdf/{event}/{transaction}', [AdminTransactionController::class, 'pdf'])->name('pdf');
        Route::get('approve/{event}/{transaction}', [AdminTransactionController::class, 'approve'])->name('approve');
        Route::resource('events.transactions', AdminTransactionController::class);

        Route::get('events/{event}/scan', [AdminEventController::class, 'scan'])->name('events.scan');
    });
});
