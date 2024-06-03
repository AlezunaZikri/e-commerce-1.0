<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as AdminEventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('events/{event}/scan', [AdminEventController::class, 'scanAPI'])->name('api.events.scan');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
