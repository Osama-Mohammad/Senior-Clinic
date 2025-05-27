<?php

namespace App\Notifications\Secretary;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use App\Models\Appointment;

class AppointmentCancelNotification extends Notification
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $doctor = $this->appointment->doctor;
        $clinic = $this->appointment->clinic;
        $datetime = Carbon::parse($this->appointment->appointment_datetime)->format('l, F j, Y \a\t h:i A');

        return (new MailMessage)
            ->subject('Appointment Cancellation Notice')
            ->greeting("Hello {$notifiable->first_name},")
            ->line("We regret to inform you that your upcoming appointment has been canceled.")
            ->line("❌ Appointment Details:")
            ->line("• Doctor: Dr. {$doctor->first_name} {$doctor->last_name}")
            // ->line("• Clinic: {$clinic->name}")
            ->line("• Date & Time: {$datetime}")
            // ->line("• Address: {$clinic->address}")
            ->line("If you need assistance or would like to reschedule, please contact us.")
            ->line('We apologize for the inconvenience and thank you for your understanding.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'doctor_id' => $this->appointment->doctor_id,
            'clinic_id' => $this->appointment->clinic_id,
            'canceled_at' => now(),
        ];
    }
}
