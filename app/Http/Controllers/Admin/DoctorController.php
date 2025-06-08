<?php

namespace App\Http\Controllers\Admin;

use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DoctorController extends Controller
{
    use AuthorizesRequests;
    public function manageDoctors(Admin $admin, Request $request)
    {
        $this->authorize('view', $admin);

        $query = Doctor::with('clinic');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $doctors = $query->paginate(10);

        return view('admin.doctors.manage_doctors', compact('doctors'));
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clinics = Clinic::all();
        return view('admin.doctors.create-doctor', compact('clinics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'clinic' => 'required|exists:clinics,id',
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $doctor = new Doctor();
        $doctor->first_name = $validated['first_name'];
        $doctor->last_name = $validated['last_name'];
        $doctor->clinic_id = $validated['clinic'];
        $doctor->email = $validated['email'];
        $doctor->password = bcrypt($validated['password']);

        $doctor->save();

        return redirect()->route('admin.manageDoctors', Auth::guard('admin')->user())->with('success', 'Doctor created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $doctor = Doctor::findOrFail($doctor->id);

        // dd(gettype($doctor->available_days)); // This will print: string

        $available_days = is_string($doctor->available_days)
            ? json_decode($doctor->available_days, true) ?? []
            : $doctor->available_days;

        $available_hours = is_string($doctor->available_hours)
            ? json_decode($doctor->available_hours, true) ?? []
            : $doctor->available_hours;

        return view('admin.doctors.edit-doctor', compact('doctor', 'available_days', 'available_hours'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif',
            'price' => 'nullable|numeric|min:0',
            'max_daily_appointments' => 'nullable|integer|min:1',
            'available_days' => 'nullable|array',
            'available_hours' => 'nullable|array',
            'description' => 'nullable|string'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($doctor->image && Storage::disk('public')->exists($doctor->image)) {
                Storage::disk('public')->delete($doctor->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
            // stores to storage/app/public/images and returns the relative path
        }

        if ($request->has('available_days') &&$request->has('available_hours')) {
            $validated['available_days'] = json_encode($validated['available_days']);
            $validated['available_hours'] = json_encode($validated['available_hours']);
        }
        $doctor->update($validated);

        return redirect()->route('admin.manageDoctors', Auth::guard('admin')->user())->with('success', 'Doctor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return back()->with('success', 'deleted doctor successfully');
    }
    public function ajaxSearch(Request $request)
    {
        $search = $request->input('query');

        $doctors = Doctor::with('clinic')
            ->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->limit(20)
            ->get();

        return response()->json([
            'html' => view('admin.doctors.partials.doctor_rows', compact('doctors'))->render()
        ]);
    }
}
