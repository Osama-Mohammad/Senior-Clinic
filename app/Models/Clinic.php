<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable = ['name', 'address', 'phone_number', 'description', 'image'];


    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
