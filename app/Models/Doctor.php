<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'specialization',
        'price',
        'max_daily_appointments',
        'available_days',
        'available_hours',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    // protected $casts = [
    //     'available_days' => 'array',
    //     'available_hours' => 'array',
    //     'price' => 'decimal:2',
    // ];
    protected $attributes = [
        'available_days' => '[]',
        'available_hours' => '[]',
    ];
}
