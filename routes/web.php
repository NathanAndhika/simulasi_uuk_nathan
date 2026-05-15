<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
   return redirect('/attendance');
});

Route::get('/dashboard', function () {
   return redirect('/attendance');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
   Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
   Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
   Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

   Route::get('/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
   Route::put('/attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
   Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
});

require __DIR__.'/auth.php';
