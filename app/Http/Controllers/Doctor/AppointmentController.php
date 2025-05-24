<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function search(Request $request)
    {
        $doctorId = Auth::guard('doctor')->id();

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

    public function index()
    {
        $appointments = Appointment::where('doctor_id', Auth::guard('doctor')->user()->id)->get();
        $appointments = $appointments->load('doctor', 'patient');
        return view('Appointment.index', compact('appointments'));
    }
}
