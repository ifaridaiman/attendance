<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

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

Route::resource('attendance', AttendanceController::class);
Route::redirect('/', '/attendance');
Route::post('/attendance/search', [AttendanceController::class, 'search'])->name('attendance.search');
Route::patch('/attendance/{id}/registration', [AttendanceController::class, 'validateRegistration'])->name('attendance.validateRegistration');
Route::patch('/attendance/{id}/best-dress', [AttendanceController::class, 'validateBestDress'])->name('attendance.validateBestDress');
Route::patch('/attendance/{id}/best-dress-cancel', [AttendanceController::class, 'cancelBestDress'])->name('attendance.cancelBestDress');

