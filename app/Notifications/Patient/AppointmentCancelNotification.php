<?php

namespace App\Notifications\Patient;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCancelNotification extends Notification
{
    use Queueable;

    protected $appointment;
    /**
     * Create a new notification instance.
     */
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
            ->subject('Your Appointment Has Been Canceled')
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line('We’re confirming that your appointment has been successfully canceled.')
            ->line('Here are the original appointment details:')
            ->line('👨‍⚕️ Doctor: ' . $doctor->first_name . ' ' . $doctor->last_name)
            ->line('📅 Date & Time: ' . $datetime)
            ->line('If you canceled by mistake or wish to reschedule, you can do so below:')
            ->action('Book a New Appointment', url('/patient/appointments'))
            ->line('Thank you for using MediBook AI.');
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
