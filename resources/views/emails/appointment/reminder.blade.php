<!-- resources/views/emails/appointment_reminder.blade.php -->
<h1>Appointment Reminder</h1>
<p>Dear {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }},</p>
<p>This is a reminder that you have an appointment with Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }} on {{ $appointment->appointment_datetime->format('l, F j, Y h:i A') }}.</p>
<p>Thank you for choosing our service.</p>
