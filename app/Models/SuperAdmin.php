<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\SuperAdminFactory> */
    use HasFactory, Notifiable;
    protected $fillable = ['full_name', 'email', 'password'];
}
