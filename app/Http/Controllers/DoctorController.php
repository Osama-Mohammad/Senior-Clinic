<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DoctorController extends Controller
{
    use AuthorizesRequests;

    /**
     * Ajax search by doctor name
     */
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
        // ✅ Step 1: Clean up the availability_schedule before validation
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

        // Overwrite request input before validation
        $request->merge(['availability_schedule' => $cleanedSchedule]);

        // ✅ Step 2: Validate input
        $validated = $request->validate([
            'first_name'                   => 'required|string|max:255',
            'last_name'                    => 'required|string|max:255',
            'email'                        => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone_number'                 => 'required|string|max:20',
            'image'                        => 'nullable|image|mimes:png,jpg,jpeg,gif',
            'price'                        => 'required|numeric|min:0',

            'availability_schedule'        => 'nullable|array',
            'availability_schedule.*.from' => 'nullable|date_format:H:i',
            'availability_schedule.*.to'   => 'nullable|date_format:H:i|after:availability_schedule.*.from',
            'availability_schedule.*.max'  => 'nullable|integer|min:1',
        ]);
        
        foreach ($validated['availability_schedule'] as $day => $entry) {
            $from = \Carbon\Carbon::createFromFormat('H:i', $entry['from']);
            $to = \Carbon\Carbon::createFromFormat('H:i', $entry['to']);

            $availableMinutes = $to->diffInMinutes($from);
            $maxPossible = intdiv($availableMinutes, 30); // one appointment every 30 min

            if ($entry['max'] > $maxPossible) {
                return back()->withErrors([
                    "availability_schedule.$day.max" => "Max appointments for $day exceeds available time. You can have max $maxPossible slots of 30 min."
                ])->withInput();
            }
        }


        // ✅ Step 3: Handle image upload
        if ($request->hasFile('image')) {
            if ($doctor->image && Storage::disk('public')->exists($doctor->image)) {
                Storage::disk('public')->delete($doctor->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        // ✅ Step 4: Save doctor update
        $doctor->update([
            'first_name'            => $validated['first_name'],
            'last_name'             => $validated['last_name'],
            'email'                 => $validated['email'],
            'phone_number'          => $validated['phone_number'],
            'image'                 => $validated['image'] ?? $doctor->image,
            'price'                 => $validated['price'],
            'availability_schedule' => $validated['availability_schedule'] ?? [],
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
