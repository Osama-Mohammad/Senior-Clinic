<?php

namespace App\Notifications\Secretary;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentBookedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $appointment;
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
            ->greeting("Hello {$notifiable->first_name},")
            ->line("Your appointment has been successfully booked.")
            ->line("👨‍⚕️ Doctor: Dr. {$doctor->first_name} {$doctor->last_name}")
            // ->line("🏥 Clinic: {$clinic->name}")
            ->line("🗓️ Date & Time: {$datetime}")
            // ->line("📌 Address: {$clinic->address}")
            ->line("Please make sure to arrive 10 minutes early.")
            ->line('Thank you for choosing our clinic!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
