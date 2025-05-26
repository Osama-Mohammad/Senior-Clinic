<?php

namespace App\Notifications\Patient;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentBookedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $appointment;
    public function __construct($appointment)
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
        $datetime = $this->appointment->appointment_datetime->format('l, F j, Y \a\t g:i A');

        return (new MailMessage)
            ->subject('Your Appointment is Confirmed!')
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line('Your appointment has been successfully booked.')
            ->line('Here are the appointment details:')
            ->line('👨‍⚕️ Doctor: ' . $doctor->first_name . ' ' . $doctor->last_name)
            ->line('📅 Date & Time: ' . $datetime)
            ->action('View Your Appointments', url('/patient/appointments'))
            ->line('Thank you for using MediBook AI!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'appointment_datetime' => $this->appointment->appointment_datetime,
        ];
    }
}
