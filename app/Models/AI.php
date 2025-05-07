<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AI extends Model
{
    protected $fillable = ['patients_id', 'disease_name', 'description', 'submitted_attributes', 'result', 'percentage_probability', 'image'];
    protected $casts = [
        'submitted_attributes' => 'array'
    ];
    // $ai->submitted_attributes = ['symptom1' => true, 'symptom2' => false]; Laravel will handle the JSON encoding and decoding for you.



}
