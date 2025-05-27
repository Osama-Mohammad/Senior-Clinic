<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send appointment reminders to patients 2 days before their appointments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = now()->addDays(2)->toDateString();

        $appointments = Appointment::whereDate('appointment_datetime', $date)
            ->where('status', '!=', 'completed')
            ->with(['patient', 'doctor'])
            ->get();

        foreach ($appointments as $appt) {
            Mail::to($appt->patient->email)
                ->send(new AppointmentReminder($appt));

            $this->info("Reminder sent to {$appt->patient->email}");
        }

        return 0;
    }
}
