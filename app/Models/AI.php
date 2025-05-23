<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ai extends Model
{
    protected $table = 'heart_failure';

    protected $fillable = [
        'ai_model_id',
        'patient_id',
        'doctor_id',
        'submitted_attributes',
        'result',
        'percentage_probability',
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
        return $this->belongsTo(AiModel::class);
    }
}
