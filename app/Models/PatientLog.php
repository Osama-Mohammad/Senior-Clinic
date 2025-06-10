<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientLog extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'description',
        'attachments',
        'recocmendation',
        'treatment'
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    protected $attributes = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
