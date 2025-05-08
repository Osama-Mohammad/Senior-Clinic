<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Doctor $doctor)
    {
        $doctor = $doctor->load('clinic');
        // dd($doctor);
        return view('Appointment.create', compact('doctor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd(Auth::guard('patient')->user()->id);

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

        // Step 1: Count current appointments for that doctor on the selected date
        $appointmentCount = Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_datetime', $appointment->toDateString())->count();

        if ($appointmentCount >= $doctor->max_daily_appointments) {
            return back()->withErrors([
                'appointment_datetime' => 'Doctor is fully booked on ' . $appointment->toFormattedDateString() . '.'
            ])->withInput();
        }


        // If we reach here, it’s valid—proceed to save the appointment...
        Appointment::create([
            'doctor_id'            => $doctor->id,
            'clinic_id'            => $validated['clinic_id'],
            'appointment_datetime' => $appointment,
            'status' => 'Booked',
            'patient_id' => Auth::guard('patient')->user()->id
        ]);
        return redirect()->route('patient.show', Auth::guard('patient')->user()->id)->with('success Booked Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
