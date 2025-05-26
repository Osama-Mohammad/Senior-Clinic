<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Notifications\Patient\AppointmentBookedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create(Doctor $doctor)
    {
        $doctor = $doctor->load('clinic');
        // dd($doctor);
        $schedules = $doctor['availability_schedule'];
        return view('Appointment.create', compact('doctor', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'clinic_id' => 'required|exists:clinics,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required'
        ]);

        $appointment = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);

        $validated['appointment_datetime'] = $appointment;

        // Your same validation logic from before
        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $day = ucfirst($appointment->format('l'));
        $schedule = $doctor->availability_schedule[$day] ?? null;

        if (!$schedule || empty($schedule['from']) || empty($schedule['to'])) {
            return back()->withErrors(['appointment_time' => "Doctor is not available on $day."])->withInput();
        }

        $start = Carbon::parse("{$validated['appointment_date']} {$schedule['from']}");
        $end = Carbon::parse("{$validated['appointment_date']} {$schedule['to']}");
        if ($appointment->lt($start) || $appointment->gt($end)) {
            return back()->withErrors(['appointment_time' => "Doctor is available between {$schedule['from']} and {$schedule['to']}."])->withInput();
        }

        $dailyMax = isset($schedule['max']) ? (int)$schedule['max'] : 0;
        $count = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_datetime', $appointment->toDateString())
            ->where('status', 'Booked')->count();

        if ($count >= $dailyMax) {
            return back()->withErrors(['appointment_time' => "Doctor is fully booked on " . $appointment->toFormattedDateString()])->withInput();
        }

        // Save
        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'clinic_id' => $validated['clinic_id'],
            'appointment_datetime' => $appointment,
            'status' => 'Booked',
            'patient_id' => Auth::guard('patient')->user()->id
        ]);

        // Notify
        $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($appointment->id);
        $appointment->patient->notify(new AppointmentBookedNotification($appointment));

        return redirect()->route('patient.show', Auth::guard('patient')->user()->id)->with('success', 'Booked Successfully');
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
