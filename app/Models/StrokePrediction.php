<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrokePrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'ai_model_id',
        'patient_id',
        'doctor_id',
        'submitted_attributes',
        'result',
        'percentage_probability',
    ];

    protected $casts = [
        'submitted_attributes' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function aiModel()
    {
        return $this->belongsTo(AIModel::class);
    }
}
