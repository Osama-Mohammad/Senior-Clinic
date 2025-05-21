<?php

namespace App\Models;

//  use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Secretary extends Authenticatable
{
    protected $fillable = ['doctor_id', 'first_name', 'last_name', 'email', 'password', 'phone_number'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
