<?php

namespace App\Observers;

use App\Models\Patient;
use App\Models\PatientLog;
use App\Models\Appointment;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        // When get updated to completed
        if ($appointment->status === 'completed' && $appointment->getOriginal('status') !== 'completed') {
            PatientLog::firstOrCreate([
                'appointment_id' => $appointment->id,
            ], [
                'patient_id'  => $appointment->patient_id,
                'doctor_id'   => $appointment->doctor_id,
                'description' => '',
                'attachments' => [],
            ]);
        }
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
