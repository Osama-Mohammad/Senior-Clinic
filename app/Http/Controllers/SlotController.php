<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function getAvailableSlots(Request $request)
    {
        $doctor = Doctor::findOrFail($request->doctor_id);
        $date = $request->date;
        $dayName = ucfirst(Carbon::parse($date)->format('l'));

        $schedule = $doctor->availability_schedule[$dayName] ?? null;

        if (!$schedule || empty($schedule['from']) || empty($schedule['to'])) {
            return response()->json([]);
        }

        $start = Carbon::parse("$date {$schedule['from']}");
        $end = Carbon::parse("$date {$schedule['to']}");

        $bookedTimes = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_datetime', $date)
            ->pluck('appointment_datetime')
            ->map(fn($dt) => Carbon::parse($dt)->format('H:i'))
            ->toArray();

        $slots = [];
        for ($time = $start->copy(); $time->lt($end); $time->addMinutes(30)) {
            $slot = $time->format('H:i');
            if (!in_array($slot, $bookedTimes)) {
                $slots[] = $slot;
            }
        }

        return response()->json($slots);
    }
}
