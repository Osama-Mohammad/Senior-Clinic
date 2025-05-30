<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    protected $fillable = ['patient_id', 'doctor_id', 'clinic_id', 'appointment_datetime', 'status'];
    protected $casts = [
        'appointment_datetime' => 'datetime',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function log()
    {
        return $this->hasOne(PatientLog::class);
    }
}
