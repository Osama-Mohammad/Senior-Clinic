<?php

use App\Mail\TestMail;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\Doctor\StrokePredictionController;

use App\Http\Controllers\Admin\ClinicController as AdminClinicController;
use App\Http\Controllers\SuperAdminController;

// Public routes
Route::get('/', function () {

    if (Auth::guard('patient')->check()) {
        return redirect()->route('patient.appointment.index');
    }
    if (Auth::guard('doctor')->check()) {
        return redirect()->route('doctor.dashboard');
    }
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard', Auth::guard('admin')->user());
    }
    if (Auth::guard('secretary')->check()) {
        return redirect()->route('secretary.dashboard', Auth::guard('secretary')->user());
    }

    $clinics = Clinic::paginate(3, ['*'], 'clinics_page');
    $doctors = Doctor::paginate(3, ['*'], 'doctors_page');

    return view('guest.index', compact('doctors', 'clinics'));
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
    Route::get('/google/complete', [AuthController::class, 'showGoogleCompleteForm'])->name('auth.google.complete');
    Route::post('/google/complete', [AuthController::class, 'completeGoogleRegistration'])->name('auth.google.complete.submit');
});

Route::middleware('auth:superadmin')->group(function () {
    Route::prefix('superAdmin')->group(function () {
        Route::get('/{superadmin}/dashboard', [SuperAdminController::class, 'show'])->name('superadmin.dashboard');
        Route::get('/admins/index', [App\Http\Controllers\SuperAdmin\AdminConstroller::class, 'index'])->name('superadmin.admin.index');

        Route::get('/admin/{admin}/edit', [App\Http\Controllers\SuperAdmin\AdminConstroller::class, 'edit'])->name('superadmin.admin.edit');
        Route::put('/admin/{admin}/update', [App\Http\Controllers\SuperAdmin\AdminConstroller::class, 'update'])->name('superadmin.admin.update');

        Route::delete('/admin/{admin}/delete', [App\Http\Controllers\SuperAdmin\AdminConstroller::class, 'destroy'])->name('superadmin.admin.delete');
    });
});

Route::prefix('patient')->group(function () {
    Route::get('/create', [PatientController::class, 'create'])->name('patient.create')->middleware('throttle:10,1');
    Route::post('/store', [PatientController::class, 'store'])->name('patient.store');

    Route::middleware(['auth:patient'])->group(function () {
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

            Route::get('/{appointment}/show', [App\Http\Controllers\Patient\AppointmentController::class, 'show'])->name('patient.appointment.show');
        });
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

        Route::get('/secretary/{secretary}/edit', [App\Http\Controllers\Doctor\SecretaryController::class, 'edit'])->name('doctor.secretary.edit');
        Route::put('/secretary/{secretary}', [App\Http\Controllers\Doctor\SecretaryController::class, 'update'])->name('doctor.secretary.update');


        Route::delete('/{secretary}/delete', [App\Http\Controllers\Doctor\SecretaryController::class, 'destroy'])->name('doctor.secretary.delete');
    });


    Route::middleware(['auth:doctor'])->group(function () {
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
        // Stroke Prediction Routes
        Route::get('/stroke-test', [App\Http\Controllers\Doctor\StrokePredictionController::class, 'showForm'])->name('doctor.stroke.test.form');
        Route::post('/stroke-test', [App\Http\Controllers\Doctor\StrokePredictionController::class, 'submitForm'])->name('doctor.stroke.test.submit');
        Route::get('/stroke-result/{id}', [App\Http\Controllers\Doctor\StrokePredictionController::class, 'showResult'])->name('doctor.stroke.test.result');

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
});

// ─── Ajax Search Routes ─────────────────────────────────────────────────────────
// Only search by **name**
Route::get('/search/clinics',  [ClinicController::class, 'search'])->name('search.clinics');
Route::get('/search/doctors', [DoctorController::class, 'search'])->name('search.doctors');
Route::get('/search/patients', [App\Http\Controllers\Secretary\PatientController::class, 'search'])->name('search.patients');

Route::get('/api/available-slots', [SlotController::class, 'getAvailableSlots']);
//add it here
Route::get('/fully-booked-dates', [\App\Http\Controllers\SlotController::class, 'getFullyBookedDates']);




Route::prefix('admin')->group(function () {
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');

    // Admin routes with authentication
    Route::middleware('auth:admin')->group(function () {
        Route::get('/{admin}/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        /* Admin Manage Doctors */
        Route::get('/manage-doctors/{admin}', [App\Http\Controllers\Admin\DoctorController::class, 'manageDoctors'])->name('admin.manageDoctors');
        Route::get('/create-doctor', [App\Http\Controllers\Admin\DoctorController::class, 'create'])->name('admin.createDoctor');
        Route::post('/store-doctor', [App\Http\Controllers\Admin\DoctorController::class, 'store'])->name('admin.storeDoctor');
        Route::get('/edit-doctor/{doctor}', [App\Http\Controllers\Admin\DoctorController::class, 'edit'])->name('admin.editDoctor');
        Route::put('/update-doctor/{doctor}', [App\Http\Controllers\Admin\DoctorController::class, 'update'])->name('admin.updateDoctor');
        Route::delete('/delete-doctor/{doctor}', [App\Http\Controllers\Admin\DoctorController::class, 'destroy'])->name('admin.deleteDoctor');
        Route::get('/admin/doctors/search', [DoctorController::class, 'ajaxSearch'])->name('admin.doctors.search');

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

        /* Manage secretaries */
        Route::get('/manage-secretaries/{admin}', [App\Http\Controllers\Admin\SecretaryController::class, 'index'])->name('admin.manage-secretary');
        Route::delete('/delete-secretary/{secretary}', [App\Http\Controllers\Admin\SecretaryController::class, "destroy"])->name('admin.deleteSecretary');
    });
});

Route::prefix('clinic')->group(function () {
    Route::get('/index', [ClinicController::class, 'index'])->name('clinic.index');
    Route::get('/show/{clinic}', [ClinicController::class, 'show'])->name('clinic.show');
});

Route::prefix('secretary')->middleware('auth:secretary')->group(function () {
    Route::get('/{secretary}/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');

    Route::get('/patient/create', [App\Http\Controllers\Secretary\PatientController::class, 'create'])->name('secretary.patient.create');
    Route::post('/patient/store', [App\Http\Controllers\Secretary\PatientController::class, 'store'])->name('secretary.patient.store');

    Route::get('/patient/{patient}/show', [App\Http\Controllers\Secretary\PatientController::class, 'show'])->name('secretary.patient.show');

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
