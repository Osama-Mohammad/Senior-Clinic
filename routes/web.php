<?php

use App\Models\Clinic;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Admin\ClinicController as AdminCLinicController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicController;
use App\Models\Appointment;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('auth.loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('/register', [AuthController::class, 'registerPage'])->name('auth.register');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::prefix('patient')->group(function () {
    Route::get('/create', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/store', [PatientController::class, 'store'])->name('patient.store');

    Route::get('/show/{patient}', [PatientController::class, 'show'])->name('patient.show');

    Route::get('/edit/{patient}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/update/{patient}', [PatientController::class, 'update'])->name('patient.update');

    Route::delete('/delete/{patient}', [PatientController::class, 'destroy'])->name('patient.delete');
});

// ✅ routes/web.php
Route::prefix('patient')->group(function () {
    Route::get('/create', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/store', [PatientController::class, 'store'])->name('patient.store');

    Route::get('/show/{patient}', [PatientController::class, 'show'])->name('patient.show');
    Route::get('/edit/{patient}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/update/{patient}', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('/delete/{patient}', [PatientController::class, 'destroy'])->name('patient.delete');

    // Ai Tests
    Route::prefix("AiTest")->group(function () {
        Route::get('/create', [AIController::class, 'create'])->name('patient.Ai.create');
    });

    /* Appointments */
    // Route::resource('appointments', AppointmentController::class);
    Route::prefix('appointment')->group(function () {
        Route::get('/create/{doctor}', [AppointmentController::class, 'create'])->name('patient.appointment.create');
        Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('patient.appointment.store');
    });
});

// If you have other routes like 'about', 'clinics.index', etc., ensure those are defined too.

// Admin routes with authentication
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard/{admin}', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    /* Admin Manage Doctors */
    Route::get('/manage-doctors/{admin}', [App\Http\Controllers\Admin\DoctorController::class, 'manageDoctors'])->name('admin.manageDoctors');
    Route::get('/create-doctor', [App\Http\Controllers\Admin\DoctorController::class, 'create'])->name('admin.createDoctor');
    Route::post('/store-doctor', [App\Http\Controllers\Admin\DoctorController::class, 'store'])->name('admin.storeDoctor');
    Route::get('/edit-doctor/{doctor}', [App\Http\Controllers\Admin\DoctorController::class, 'edit'])->name('admin.editDoctor');
    Route::put('/update-doctor/{doctor}', [App\Http\Controllers\Admin\DoctorController::class, 'update'])->name('admin.updateDoctor');
    Route::delete('/delete-doctor/{doctor}', [App\Http\Controllers\Admin\DoctorController::class, 'destroy'])->name('admin.deleteDoctor');

    /* Admin Manage Patients */
    Route::get('/manage-patients/{admin}', [App\Http\Controllers\Admin\PatientController::class, 'managePatients'])->name('admin.managePatients');
    Route::get('/create-patient', [App\Http\Controllers\Admin\PatientController::class, 'create'])->name('admin.createPatient');
    Route::post('/store-patient', [App\Http\Controllers\Admin\PatientController::class, 'store'])->name('admin.storePatient');
    Route::get('/edit-patient/{patient}', [App\Http\Controllers\Admin\PatientController::class, 'edit'])->name('admin.editPatient');
    Route::put('/update-patient/{patient}', [App\Http\Controllers\Admin\PatientController::class, 'update'])->name('admin.updatePatient');
    Route::delete('/delete-patient/{patient}', [App\Http\Controllers\Admin\PatientController::class, 'destroy'])->name('admin.deletePatient');

    /* Admin Manage Clinics */
    Route::get('/manage-clinics/{admin}', [App\Http\Controllers\Admin\ClinicController::class, 'index'])->name('admin.manageClinics');
    Route::get('/create-clinic', [App\Http\Controllers\Admin\ClinicController::class, 'create'])->name('admin.createClinic');
    Route::post('/store-clinic', [App\Http\Controllers\Admin\ClinicController::class, 'store'])->name('admin.storeClinic');
    Route::get('/edit-clinic/{clinic}', [App\Http\Controllers\Admin\ClinicController::class, 'edit'])->name('admin.editClinic');
    Route::put('/update-clinic/{clinic}', [App\Http\Controllers\Admin\ClinicController::class, 'update'])->name('admin.updateClinic');
    Route::delete('/delete-clinic/{clinic}', [App\Http\Controllers\Admin\ClinicController::class, 'destroy'])->name('admin.deleteClinic');

    /* Manage AI Test */
    Route::get("/manage-AIs/{admin}", [App\Http\Controllers\Admin\AIController::class, 'index'])->name('admin.manageAi');
    Route::get('/create-AiTest', [App\Http\Controllers\Admin\AIController::class, 'create'])->name('admin.createAi');
});

// Public admin registration routes
Route::prefix('admin')->group(function () {
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
});

Route::prefix('doctor')->group(function () {
    Route::get('/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/store', [DoctorController::class, 'store'])->name('doctor.store');

    Route::get('/edit/{doctor}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/update/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');

    Route::get('/index', [DoctorController::class, 'index'])->name('doctor.index');

    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
});

Route::prefix('clinic')->group(function () {
    Route::get('/index', [ClinicController::class, 'index'])->name('clinic.index');
});
