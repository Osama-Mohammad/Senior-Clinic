<?php

namespace App\Http\Controllers;

use App\Models\PatientLog;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientLogController extends Controller
{
    public function create(Appointment $appointment)
    {
        abort_if($appointment->status !== 'Completed', 403);
        return view('Appointment.logs.create', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'description'       => 'required|string',
            'attachments.*'     => 'file|mimes:pdf,jpg,png,docx|max:2048',
            'treatment'         => 'nullable|string',
            'recocmendation'    => 'nullable|string'
        ]);

        $files = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('patient_logs', 'public');
            }
        }

        PatientLog::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'patient_id'  => $appointment->patient_id,
                'doctor_id'   => $appointment->doctor_id,
                'description' => $data['description'],
                'attachments' => $files,
                'treatment'         => $data['treatment'],
                'recocmendation'    => $data['recocmendation']

            ]
        );

        return redirect()
            ->route('doctor.patient.show', $appointment->patient_id)
            ->with('success', 'Patient history updated.');
    }
}
