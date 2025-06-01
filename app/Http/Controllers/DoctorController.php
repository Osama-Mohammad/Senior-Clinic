<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DoctorController extends Controller
{
    use AuthorizesRequests;

    public function search(Request $request)
    {
        $q = $request->get('query', '');
        $doctors = Doctor::where('first_name', 'like', "%{$q}%")
            ->orWhere('last_name', 'like', "%{$q}%")
            ->get();

        return response()->json(['doctors' => $doctors]);
    }

    public function index()
    {
        $doctors = Doctor::paginate(6);
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
        // ✅ Step 1: Clean availability_schedule input
        $rawSchedule = $request->input('availability_schedule', []);
        $cleanedSchedule = [];

        foreach ($rawSchedule as $day => $data) {
            if (
                !empty($data['from']) &&
                !empty($data['to']) &&
                isset($data['max']) &&
                preg_match('/^\d{2}:\d{2}$/', $data['from']) &&
                preg_match('/^\d{2}:\d{2}$/', $data['to']) &&
                is_numeric($data['max'])
            ) {
                $cleanedSchedule[$day] = $data;
            }
        }

        $request->merge(['availability_schedule' => $cleanedSchedule]);

        // ✅ Step 2: Validate using Validator (not validate()) for more control
        $validator = Validator::make($request->all(), [
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'email'                 => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone_number'          => 'required|string|max:20',
            'image'                 => 'nullable|image|mimes:png,jpg,jpeg,gif',
            'price'                 => 'required|numeric|min:0',
            'availability_schedule' => 'nullable|array',
        ]);

        foreach ($cleanedSchedule as $day => $entry) {
            $from = Carbon::createFromFormat('H:i', $entry['from']);
            $to = Carbon::createFromFormat('H:i', $entry['to']);

            if ($from->gte($to)) {
                $validator->errors()->add("availability_schedule.$day.to", "The end time must be after the start time.");
            }

            $availableMinutes = $to->diffInMinutes($from);
            $maxPossible = intdiv($availableMinutes, 30);

            if ($entry['max'] > $maxPossible) {
                $validator->errors()->add("availability_schedule.$day.max", "Max appointments for $day exceeds available time. Max allowed: $maxPossible.");
            }
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ✅ Step 3: Handle image upload
        if ($request->hasFile('image')) {
            if ($doctor->image && Storage::disk('public')->exists($doctor->image)) {
                Storage::disk('public')->delete($doctor->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // ✅ Step 4: Save the doctor update
        $doctor->update([
            'first_name'            => $request->first_name,
            'last_name'             => $request->last_name,
            'email'                 => $request->email,
            'phone_number'          => $request->phone_number,
            'image'                 => $imagePath ?? $doctor->image,
            'price'                 => $request->price,
            'availability_schedule' => $cleanedSchedule,
        ]);

        return redirect()
            ->route('doctor.dashboard', Auth::guard('doctor')->user())
            ->with('success', 'Doctor updated successfully');
    }

    public function dashboard()
    {
        $doctor = Auth::guard('doctor')->user();
        return view('doctor.dashboard', compact('doctor'));
    }
}
