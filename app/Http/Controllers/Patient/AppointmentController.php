<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Notifications\Patient\AppointmentCancelNotification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display the appointment view.
     */
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $appointments = Appointment::where('patient_id', $patient->id)->latest()->get()->load('doctor');
        return view('patient.appointment.index', compact('appointments', 'patient'));
    }

    /**
     * Return appointments as JSON (used by AlpineJS).
     */
    public function search(Request $request)
    {
        $patient = Auth::guard('patient')->user();

        $query = Appointment::with('doctor')
            ->where('patient_id', $patient->id)->latest();

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $appointments = $query->get()->map(function ($a) {
            return [
                'id' => $a->id,
                'doctor_name' => $a->doctor->first_name . ' ' . $a->doctor->last_name,
                'appointment_datetime' => Carbon::parse($a->appointment_datetime)->format('F j, Y - h:i A'),
                'status' => $a->status,
            ];
        });

        return response()->json($appointments);
    }

    /**
     * Update the appointment status (e.g., cancel).
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:Booked,Cancel Requested,Canceled,Completed',
        ]);

        // Restrict late cancellations
        if ($request->status === 'Canceled') {
            $now = now();
            $appointmentDate = $appointment->appointment_datetime;

            if ($now->lt($appointmentDate) && $now->diffInHours($appointmentDate) < 48) {
                return response()->json([
                    'success' => false,
                    'error' => 'Cancellation is only allowed at least 2 days (48 hours) before the appointment.'
                ], 422);
            }
        }

        $appointment->update([
            'status' => $request->status
        ]);

        // Notify patient
        $appointment->load('doctor', 'patient');
        $appointment->patient->notify(new AppointmentCancelNotification($appointment));

        return response()->json(['success' => true, 'status' => $appointment->status]);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('patient', 'doctor', 'log');
        return view('patient.appointment.show', compact('appointment'));
    }
}
