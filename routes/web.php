<?php

use App\Mail\TestMail;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\PatientLogController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\ClinicController as AdminClinicController;

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

    // Google OAuth
    Route::get('/google', [AuthController::class, 'googleLogin'])->name('auth.google');
    Route::get('/google-callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    // Complete profile after first‐time Google login
    Route::get('/google/complete', [AuthController::class, 'sh owGoogleCompleteForm'])->name('auth.google.complete');
    Route::post('/google/complete', [AuthController::class, 'completeGoogleRegistration'])->name('auth.google.complete.submit');
});

Route::prefix('patient')->group(function () {
    Route::get('/create', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/store', [PatientController::class, 'store'])->name('patient.store');
    Route::get('/show/{patient}', [PatientController::class, 'show'])->name('patient.show');
    Route::get('/edit/{patient}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/update/{patient}', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('/delete/{patient}', [PatientController::class, 'destroy'])->name('patient.delete');

    // AI Tests
    Route::prefix('AiTest')->group(function () {
        Route::get('/create', [AIController::class, 'create'])->name('patient.Ai.create');
    });

    /* Appointments */
    Route::prefix('appointment')->group(function () {
        Route::get('/index', [App\Http\Controllers\Patient\AppointmentController::class, 'index'])->name('patient.appointment.index');
        Route::get('/create/{doctor}', [AppointmentController::class, 'create'])->name('patient.appointment.create');
        Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('patient.appointment.store');

        Route::get('/appointments/search', [App\Http\Controllers\Patient\AppointmentController::class, 'search'])->name('patient.appointments.search');
        Route::patch('/{appointment}/update-status', [App\Http\Controllers\Patient\AppointmentController::class, 'updateStatus'])->name('patient.appointments.updateStatus');

        Route::get('/{appointment}/show',[App\Http\Controllers\Patient\AppointmentController::class,'show'])->name('patient.appointment.show');
    });
});

// Public Clinic & Doctor index
Route::prefix('clinic')->group(function () {
    Route::get('/index', [ClinicController::class, 'index'])->name('clinic.index');
});

Route::prefix('doctor')->group(function () {
    Route::get('/index', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/store', [DoctorController::class, 'store'])->name('doctor.store');
    Route::get('/edit/{doctor}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/update/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');

    Route::prefix('secretary')->group(function () {
        Route::get('/index', [App\Http\Controllers\Doctor\SecretaryController::class, 'index'])->name('doctor.secretary.index');

        Route::get('/create', [App\Http\Controllers\Doctor\SecretaryController::class, 'create'])->name('doctor.secretary.create');
        Route::post('/store', [App\Http\Controllers\Doctor\SecretaryController::class, 'store'])->name('doctor.secretary.store');

        Route::delete('/{secretary}/delete', [App\Http\Controllers\Doctor\SecretaryController::class, 'destroy'])->name('doctor.secretary.delete');
    });
});

// ─── Ajax Search Routes ─────────────────────────────────────────────────────────
// Only search by **name**
Route::get('/search/clinics',  [ClinicController::class, 'search'])->name('search.clinics');
Route::get('/search/doctors', [DoctorController::class, 'search'])->name('search.doctors');
Route::get('/search/patients', [App\Http\Controllers\Secretary\PatientController::class, 'search'])->name('search.patients');

Route::get('/api/available-slots', [SlotController::class, 'getAvailableSlots']);


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
});

// Public admin registration routes
Route::prefix('admin')->group(function () {
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
});

Route::prefix('doctor')->middleware(['auth:doctor'])->group(function () {
    Route::get('/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/store', [DoctorController::class, 'store'])->name('doctor.store');

    Route::get('/edit/{doctor}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/update/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');

    Route::get('/index', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    // ✅ AI Test Form Route (only accessible by authenticated doctors)
    Route::get('/ai-test', [AiController::class, 'showForm'])->name('doctor.ai.test.form');
    Route::post('/ai-test', [AiController::class, 'submitForm'])->name('doctor.ai.test.submit'); // ✅ MISSING LINE FIXED
    Route::get('/ai-result/{id}', [AiController::class, 'showResult'])->name('doctor.ai.test.result');

    Route::prefix('appointment')->group(function () {
        Route::get('/index', [App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('doctor.appointments.index');
        Route::get('/appointments/search', [App\Http\Controllers\Doctor\AppointmentController::class, 'search'])->name('doctor.appointments.search');

        Route::get('/{appointment}/log', [PatientLogController::class, 'create'])
            ->name('appointments.logs.create');
        Route::post('/{appointment}/log', [PatientLogController::class, 'store'])
            ->name('appointments.logs.store');
    });

    Route::prefix('patient')->group(function () {
        Route::get('/{patient}/show', [App\Http\Controllers\Doctor\PatientController::class, 'show'])->name('doctor.patient.show');
    });
});

Route::prefix('clinic')->group(function () {
    Route::get('/index', [ClinicController::class, 'index'])->name('clinic.index');
    Route::get('/show/{clinic}', [ClinicController::class, 'show'])->name('clinic.show');
});

Route::prefix('secretary')->middleware('auth:secretary')->group(function () {
    Route::get('/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');

    Route::get('/patient/create', [App\Http\Controllers\Secretary\PatientController::class, 'create'])->name('secretary.patient.create');
    Route::post('/patient/store', [App\Http\Controllers\Secretary\PatientController::class, 'store'])->name('secretary.patient.store');

    Route::get('/patient/{patient}/bookAppointment', [App\Http\Controllers\Secretary\AppointmentController::class, 'create'])->name('secretary.patient.createAppointment');
    Route::post('/patient/{patient}/bookAppointment', [App\Http\Controllers\Secretary\AppointmentController::class, 'store'])->name('secretary.patient.storeAppointment');

    Route::prefix('appointment')->group(function () {
        Route::get('/index', [App\Http\Controllers\Secretary\AppointmentController::class, 'index'])->name('secretary.appointments.index');
        Route::get('/appointments/search', [App\Http\Controllers\Secretary\AppointmentController::class, 'search'])->name('secretary.appointments.search');
        Route::patch('/{appointment}/update-status', [App\Http\Controllers\Secretary\AppointmentController::class, 'updateStatus'])->name('secretary.appointments.updateStatus');
    });
});


/* Email Testing */
Route::get('/send-email', function () {
    Mail::to('test@example.com')->send(new TestMail());
    return 'Email sent! Check Ethereal.';
});
