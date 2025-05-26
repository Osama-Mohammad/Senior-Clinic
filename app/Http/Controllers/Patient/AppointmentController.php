<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Notifications\Patient\AppointmentCancelNotification;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $appointments = Appointment::where('patient_id', $patient->id)->get();
        $appointments = $appointments->load('doctor');
        return view('patient.appointment.index', compact('appointments', 'patient'));
    }

    public function search(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        $query = Appointment::with('patient', 'doctor')
            ->where('patient_id', $patient->id); // Always filter by patient

        // Only filter by status if it's not empty/null
        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $appointments = $query->get()->map(function ($a) {
            return [
                'id' => $a->id,
                'doctor_name' => $a->doctor->first_name . ' ' . $a->doctor->last_name,
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

        $appointment->load('doctor', 'patient');
        $appointment->patient->notify(new AppointmentCancelNotification($appointment));
        return response()->json(['success' => true, 'status' => $appointment->status]);
    }
}
