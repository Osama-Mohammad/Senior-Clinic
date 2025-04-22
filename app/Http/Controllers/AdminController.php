<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public $cities = [
        "Beirut",         // Capital and largest city
        "Tripoli",        // Second-largest city, in the north
        "Sidon (Saida)",  // Major southern coastal city
        "Tyre (Sour)",    // Historic coastal city in the south
        "Byblos (Jbeil)", // One of the oldest continuously inhabited cities
        "Zahle",          // Major city in the Bekaa Valley
        "Nabatieh",       // Important city in southern Lebanon
        "Jounieh",        // Coastal city north of Beirut
        "Baalbek",        // Famous for its Roman ruins
        "Aley",           // Mountain town near Beirut
        "Batroun",        // Coastal city north of Byblos
        "Bint Jbeil",     // Southern town near the Israeli border
        "Chouf (Deir el Qamar)", // Historical Druze center
        "Hermel",         // Northern city in the Bekaa region
        "Jbeil (Byblos)", // Alternative name for Byblos
        "Jezzine",        // Scenic mountain town
        "Rashaya",        // Known for its historic castle
        "Zgharta",        // Northern city near Tripoli
        "Anjar",          // Known for its Umayyad ruins
        "Marjayoun"       // Southern town with historical significance
    ];

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Admin::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('admin.dashboard', $admin)->with('success', 'Admin created successfully');
    }

    public function dashboard(Admin $admin)
    {
        return view('admin.dashboard', compact('admin'));
    }

    public function manageDoctors()
    {
        $doctors = Doctor::paginate();
        return view('admin.doctors.manage_doctors', compact('doctors'));
    }

    public function editDoctor(Doctor $doctor)
    {
        $doctor = Doctor::findOrFail($doctor->id);
        $available_days = json_decode($doctor->available_days, true);
        $available_hours = json_decode($doctor->available_hours, true);
        return view('admin.doctors.edit-doctor', compact('doctor', 'available_days', 'available_hours'));
    }

    public function updateDoctor(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_daily_appointments' => 'required|integer|min:1',
            'available_days' => 'required|array',
            'available_hours' => 'required|array',
        ]);

        $validated['available_days'] = json_encode($validated['available_days']);
        $validated['available_hours'] = json_encode($validated['available_hours']);

        $doctor->update($validated);

        return redirect()->route('admin.manageDoctors', Auth::guard('admin')->user())->with('success', 'Doctor updated successfully');
    }

    public function createDoctor()
    {
        return view('admin.doctors.create-doctor');
    }

    public function storeDoctor(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $doctor = new Doctor();
        $doctor->first_name = $validated['first_name'];
        $doctor->last_name = $validated['last_name'];
        $doctor->email = $validated['email'];
        $doctor->password = bcrypt($validated['password']);

        $doctor->save();

        return redirect()->route('admin.manageDoctors', Auth::guard('admin')->user())->with('success', 'Doctor created successfully');
    }

    public function deleteDoctor(Doctor $doctor)
    {
        $doctor->delete();
        return back()->with('success', 'deleted doctor successfully');
    }



    public function managePatients()
    {
        $patients = Patient::paginate();
        return view('admin.patients.index', compact('patients'));
    }


    public function createPatient()
    {
        $cities = $this->cities;
        return view('admin.patients.create', compact('cities'));
    }



    public function editPatient(Patient $patient)
    {
        $cities = $this->cities;
        return view('admin.patients.edit', compact('patient', 'cities'));
    }


    public function storePatient(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:patients',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:M,F',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $patient = new Patient();
        $patient->first_name = $validated['first_name'];
        $patient->last_name = $validated['last_name'];
        $patient->email = $validated['email'];
        $patient->password = $validated['password'];
        $patient->phone_number = $validated['phone_number'];
        $patient->address = $validated['address'];
        $patient->date_of_birth = $validated['date_of_birth'];
        $patient->gender = $validated['gender'];

        $patient->save();

        return redirect()->route("admin.managePatients", Auth::guard('admin')->user())->with('success', 'Patient updated successfully.');
    }

    public function updatePatient(Request $request, Patient $patient)
    {

        $patientId = $patient->id;

        $validated  = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:patients,email,' . $patientId,
            // 'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:M,F',
        ]);

        // $validated['password'] = Hash::make($validated['password']);

        $patient->update($validated);

        return redirect()->route("admin.managePatients", Auth::guard('admin')->user())->with('success', 'Patient updated successfully.');
    }

    public function deletePatient(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'deleted patient successfully');
    }
}
