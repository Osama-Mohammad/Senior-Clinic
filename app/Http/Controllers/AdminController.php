<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.doctors.create-doctor');
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
}
