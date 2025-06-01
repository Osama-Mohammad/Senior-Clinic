<?php

namespace App\Http\Controllers\Secretary;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Notifications\Secretary\AppointmentBookedNotification;
use App\Notifications\Secretary\AppointmentCancelNotification;
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
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required'
        ]);

        $appointment = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);

        $validated['appointment_datetime'] = $appointment;

        // 🔁 Continue with your previous validation logic
        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $day = ucfirst($appointment->format('l'));
        $schedule = $doctor->availability_schedule[$day] ?? null;

        if (!$schedule || empty($schedule['from']) || empty($schedule['to'])) {
            return back()->withErrors([
                'appointment_time' => "Doctor is not available on $day."
            ])->withInput();
        }

        // Check appointment in range
        $start = Carbon::parse("$validated[appointment_date] {$schedule['from']}");
        $end = Carbon::parse("$validated[appointment_date] {$schedule['to']}");
        if ($appointment->lt($start) || $appointment->gt($end)) {
            return back()->withErrors([
                'appointment_time' => "Doctor is available only between {$schedule['from']} and {$schedule['to']}."
            ])->withInput();
        }

        // Check daily max
        $dailyMax = isset($schedule['max']) ? (int)$schedule['max'] : 0;
        $bookedCount = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_datetime', $appointment->toDateString())
            ->where('status', 'Booked')
            ->count();

        if ($bookedCount >= $dailyMax) {
            return back()->withErrors([
                'appointment_time' => "Doctor is fully booked on " . $appointment->toFormattedDateString()
            ])->withInput();
        }

        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'clinic_id' => $validated['clinic_id'],
            'appointment_datetime' => $appointment,
            'status' => 'Booked',
            'patient_id' => $patient->id
        ]);

        $patient = $appointment->patient;
        $patient->notify(new AppointmentBookedNotification($appointment));

        return redirect()->route('secretary.dashboard')->with('success', 'Appointment booked successfully.');
    }

    public function search(Request $request)
    {
        $secretary = Auth::guard('secretary')->user();
        $doctorId = $secretary->doctor->id;

        $query = Appointment::with('patient', 'doctor')
            ->where('doctor_id', $doctorId)->latest(); // Always filter by doctor

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

            try {
                $patient = $appointment->patient;
                $patient->notify(new AppointmentCancelNotification($appointment));
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to send cancellation email: ' . $e->getMessage()
                ], 500);
            }
        }

        $appointment->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true, 'status' => $appointment->status]);
    }
}
