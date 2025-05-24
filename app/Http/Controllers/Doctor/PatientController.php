<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function show(Patient $patient)
    {
        return view('doctor.patient.show', compact('patient'));
    }
}
