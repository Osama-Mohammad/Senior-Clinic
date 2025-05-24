<?php

namespace App\Http\Controllers\Secretary;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    public function index()
    {
        $secretary = Auth::guard('secretary')->user();
        $appointments = Appointment::where('doctor_id', $secretary->doctor_id)->get();
        $appointments = $appointments->load('doctor', 'patient');
        return view('secretary.appointment.index', compact('appointments', 'secretary'));
    }

    public function create(Patient $patient)
    {

        $secretary = Auth::guard('secretary')->user();
        $doctor = $secretary->doctor;
        $schedules = $doctor['availability_schedule'];
        return view('secretary.appointment.create', compact('doctor', 'schedules', 'patient'));
    }

    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'clinic_id' => 'required|exists:clinics,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_datetime' => 'required|after:now'
        ]);

        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $appointment = Carbon::parse($validated['appointment_datetime']);

        $day = strtolower($appointment->format('l'));
        $key = ucfirst($day);

        $time = $appointment->format('H:i');

        // Pull the schedule for that day (or null if none)
        $schedule = $doctor->availability_schedule[$key] ?? null;

        if (!$schedule || empty($schedule['from']) || empty($schedule['to'])) {
            return back()->withErrors([
                'appointment_datetime' => "Doctor is not available on " . ucfirst($day) . "."
            ])->withInput();
        }

        // ✅ Get and validate the max allowed per day
        $dailyMax = isset($schedule['max']) ? (int)$schedule['max'] : 0;
        if ($dailyMax <= 0) {
            return back()->withErrors([
                'appointment_datetime' => "Doctor has no maximum appointments set for " . ucfirst($day) . "."
            ])->withInput();
        }
        // Turn those strings into Carbon instances for comparison
        $start = Carbon::parse($appointment->toDateString() . ' ' . $schedule['from']); // 2025-05-15 09:00
        $end   = Carbon::parse($appointment->toDateString() . ' ' . $schedule['to']);   // 2025-05-15 14:00


        if ($appointment->lt($start) || $appointment->gt($end)) {
            return back()->withErrors([
                'appointment_datetime' =>
                "Doctor is available on " . ucfirst($day)
                    . " only between {$schedule['from']} and {$schedule['to']}."
            ])->withInput();
        }

        $appointmentCount = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_datetime', $appointment->toDateString())
            ->where('status', 'Booked')
            ->count();

        if ($appointmentCount >= $dailyMax) {
            return back()->withErrors([
                'appointment_datetime' =>
                "Doctor is fully booked on " . $appointment->toFormattedDateString()
                    . " (max {$dailyMax} appointments per day)."
            ])->withInput();
        }



        // If we reach here, it’s valid—proceed to save the appointment...
        Appointment::create([
            'doctor_id'            => $doctor->id,
            'clinic_id'            => $validated['clinic_id'],
            'appointment_datetime' => $appointment,
            'status' => 'Booked',
            'patient_id' =>  $patient->id
        ]);
        return redirect()->route('secretary.dashboard')->with('success', ' Booked Successfully');
    }
    public function search(Request $request)
    {
        $secretary = Auth::guard('secretary')->user();
        $doctorId = $secretary->doctor->id;

        $query = Appointment::with('patient', 'doctor')
            ->where('doctor_id', $doctorId); // Always filter by doctor

        // Only filter by status if it's not empty/null
        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $appointments = $query->get()->map(function ($a) {
            return [
                'id' => $a->id,
                'patient_id' => $a->patient->id, // <-- Add this
                'patient_name' => $a->patient->first_name . ' ' . $a->patient->last_name,
                'appointment_datetime' => $a->appointment_datetime,
                'status' => $a->status,
            ];
        });

        return response()->json($appointments);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:Booked,Cancel Requested,Canceled,Completed',
        ]);

        // Check if status change is to "Canceled"
        if ($request->status === 'Canceled') {
            $now = now();
            $appointmentDate = $appointment->appointment_datetime;

            if ($now->lt($appointmentDate) && $now->diffInHours($appointmentDate) < 48) {
                return response()->json([
                    'success' => false,
                    'error' => 'Cancellation is only allowed at least 2 days (48 hours) before the appointment.'
                ], 422);
            }

            // Require cancellation to be at least 2 full days before the appointment
            // $diffInDays = $now->diffInDays($appointmentDate, false);
            // if ($diffInDays < 2) {
            //     return response()->json([
            //         'success' => false,
            //         'error' => 'Cancellation is only allowed at least 2 days before the appointment.'
            //     ], 422); // Unprocessable Entity
            // }
        }

        $appointment->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true, 'status' => $appointment->status]);
    }
}
