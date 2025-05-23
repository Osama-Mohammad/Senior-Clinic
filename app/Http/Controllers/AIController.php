<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Ai;
use App\Models\AiModel;

class AIController extends Controller
{
    public function create()
    {
        return view('AiTest.create');
    }
    public function showForm()
    {
        $doctor = auth('doctor')->user();
        $patients = $doctor->patients ?? []; // Assuming doctor has patients relationship
        return view('doctor.ai-test-form', compact('patients'));
    }

public function submitForm(Request $request)
{
    try {
        \Log::info('🔥 [STEP 1] Receiving form request');

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'norm_age' => 'required|numeric',
            'anaemia' => 'required|boolean',
            'norm_creatinine_phosphokinase' => 'required|numeric',
            'diabetes' => 'required|boolean',
            'norm_ejection_fraction' => 'required|numeric',
            'high_blood_pressure' => 'required|boolean',
            'norm_platelets' => 'required|numeric',
            'norm_serum_creatinine' => 'required|numeric',
            'norm_serum_sodium' => 'required|numeric',
            'norm_time' => 'required|numeric',
        ]);

        \Log::info('✅ [STEP 2] Validation passed', $validated);

        $features = collect($validated)->except('patient_id')->toArray();
        \Log::info('📤 [STEP 3] Sending to Flask API', $features);

        $response = Http::timeout(5)->post('http://127.0.0.1:5000/predict-heart', $features);

        if (!$response->successful()) {
            \Log::error('❌ [STEP 4] Flask API failed', ['body' => $response->body()]);
            return back()->with('error', 'Flask AI failed.');
        }

        $data = $response->json();
        \Log::info('📥 [STEP 5] Received from Flask', $data);

        $aiModel = AiModel::firstOrCreate([
              ['name' => 'Heart Failure'],
                ['description' => 'AI model for predicting heart failure risk']
        ]);

        $record = Ai::create([
            'ai_model_id' => $aiModel->id,
            'patient_id' => $validated['patient_id'],
            'doctor_id' => auth('doctor')->id(),
            'submitted_attributes' => json_encode($features),
            'result' => $data['result'] == 1 ? 'Positive' : 'Negative',
            'percentage_probability' => $data['probability'],
        ]);

        \Log::info('💾 [STEP 6] Record saved', $record->toArray());

        return redirect()->route('doctor.ai.test.result', $record->id);

    } catch (\Throwable $e) {
        \Log::error('🔥 [FAIL] Exception in submitForm()', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return back()->with('error', 'Exception: ' . $e->getMessage());
    }
}



    public function showResult($id)
    {
        $record = Ai::with(['patient', 'doctor', 'aiModel'])->findOrFail($id);

        return view('doctor.ai-result', compact('record'));
    }
}
