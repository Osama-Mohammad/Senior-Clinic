<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'specialization',
        'price',
        'availability_schedule', // only the JSON column now
        'image',
        'description',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'availability_schedule' => 'array',  // cast JSON <-> array
        'price'                 => 'decimal:2',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function secretaries()
    {
        return $this->hasMany(Secretary::class);
    }
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'appointments', 'doctor_id', 'patient_id')->distinct();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function patientLogs()
    {
        return $this->hasMany(PatientLog::class);
    }
}
