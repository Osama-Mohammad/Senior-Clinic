<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('auth.loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('/register', [AuthController::class, 'registerPage'])->name('auth.register');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

/* things to do for tomorrow add the show for the patient and add the login in logic  */

Route::prefix('patient')->group(function () {
    Route::get('/create', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/store', [PatientController::class, 'store'])->name('patient.store');

    Route::get('/show/{patient}', [PatientController::class, 'show'])->name('patient.show');

    Route::get('/edit/{patient}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/update/{patient}', [PatientController::class, 'update'])->name('patient.update');

    Route::delete('/delete/{patient}', [PatientController::class, 'destroy'])->name('patient.delete');
});


Route::prefix('admin')->group(function () {
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');

    Route::get('/dashboard/{admin}', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/manage-doctors/{admin}', [AdminController::class, 'manageDoctors'])->name('admin.manageDoctors');

    Route::get('/create-doctor', [AdminController::class, 'createDoctor'])->name('admin.createDoctor');
    Route::post('/store-doctor', [AdminController::class, 'storeDoctor'])->name('admin.storeDoctor');

    Route::get('/edit-doctor/{doctor}', [AdminController::class, 'editDoctor'])->name('admin.editDoctor');
    Route::put('/update-doctor/{doctor}', [AdminController::class, 'updateDoctor'])->name('admin.updateDoctor');
});

Route::prefix('doctor')->group(function () {
    Route::get('/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/store', [DoctorController::class, 'store'])->name('doctor.store');

    Route::get('/edit/{doctor}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/update/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');

    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
});
