<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Add this

class DoctorController extends Controller
{
    use AuthorizesRequests; // Add this trait






    public function index()
    {
        $doctors = Doctor::all();
        return view('doctor.index', compact('doctors'));
    }


    public function create()
    {
        return view('doctor.create');
    }



    public function edit(Doctor $doctor)
    {
        $doctor = Doctor::findOrFail($doctor->id);

        $available_days = is_string($doctor->available_days)
            ? json_decode($doctor->available_days, true) ?? []
            : $doctor->available_days;

        $available_hours = is_string($doctor->available_hours)
            ? json_decode($doctor->available_hours, true) ?? []
            : $doctor->available_hours;

        return view('doctor.edit', compact('doctor', 'available_days', 'available_hours'));
    }


    public function update(Request $request, Doctor $doctor)
    {
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone_number' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif',
            'price' => 'required|numeric|min:0',
            'max_daily_appointments' => 'required|integer|min:1',
            'availability_schedule' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            if ($doctor->image && Storage::disk('public')->exists($doctor->image)) {
                Storage::disk('public')->delete($doctor->image);
            }

            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // Save everything directly (casted fields are handled automatically)
        $doctor->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'image' => $validated['image'] ?? $doctor->image,
            'price' => $validated['price'],
            'max_daily_appointments' => $validated['max_daily_appointments'],
            'availability_schedule' => $validated['availability_schedule'] ?? [],
        ]);

        return redirect()->route('doctor.dashboard', Auth::guard('doctor')->user())->with('success', 'Doctor updated successfully');
    }


    public function dashboard()
    {
        $doctor = Auth::guard('doctor')->user();

        return view('doctor.dashboard', compact('doctor'));
    }
}
