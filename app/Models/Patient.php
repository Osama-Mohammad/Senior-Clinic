<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'address',
        'date_of_birth',
        'gender',
        'image',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'appointments', 'patient_id', 'doctor_id')->distinct();
    }
}
