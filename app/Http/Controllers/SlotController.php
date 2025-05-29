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

        // Count booked appointments for the day
        $bookedCount = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_datetime', $date)
            ->where('status', 'Booked')
            ->count();

        $max = (!empty($schedule['max']) && is_numeric($schedule['max'])) ? (int)$schedule['max'] : 0;

        // Return early if fully booked
        if ($max > 0 && $bookedCount >= $max) {
            return response()->json([
                'slots' => [],
                'fully_booked' => true
            ]);
        }

        // Build slot list
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

        return response()->json([
            'slots' => $slots,
            'fully_booked' => false
        ]);
    }
    public function getFullyBookedDates(Request $request)
{
    $doctor = Doctor::findOrFail($request->doctor_id);
    $dates = [];

    // Check next 30 days
    for ($i = 0; $i < 30; $i++) {
        $date = now()->addDays($i)->format('Y-m-d');
        $dayName = ucfirst(Carbon::parse($date)->format('l'));
        $schedule = $doctor->availability_schedule[$dayName] ?? null;

        if (!$schedule || empty($schedule['from']) || empty($schedule['to'])) {
            continue; // skip days with no schedule
        }

        $max = (!empty($schedule['max']) && is_numeric($schedule['max'])) ? (int)$schedule['max'] : 0;

        $bookedCount = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_datetime', $date)
            ->where('status', 'Booked')
            ->count();

        if ($max > 0 && $bookedCount >= $max) {
            $dates[] = $date;
        }
    }

    return response()->json($dates);
}

}
