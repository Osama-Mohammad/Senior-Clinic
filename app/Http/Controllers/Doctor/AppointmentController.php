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
        $doctor = Auth::guard('doctor')->user();

        $query = Appointment::with('patient')
            ->where('doctor_id', $doctor->id);

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $appointments = $query->get()->map(function ($a) {
            return [
                'id' => $a->id,
                'patient_id' => $a->patient_id,
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
