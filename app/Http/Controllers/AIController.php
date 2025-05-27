<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Ai;
use App\Models\AiModel;

class AIController extends Controller
{
    // Show the AI test form
    public function showForm()
    {
        $doctor = auth('doctor')->user();
        $patients = $doctor->patients ?? []; // Assuming 'patients' is a relation on Doctor
        return view('doctor.ai-test-form', compact('patients'));
    }

    // Handle form submission and AI prediction
    public function submitForm(Request $request)
    {
        try {
            \Log::info('🔥 STEP 1: Form submitted');

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

            \Log::info('✅ STEP 2: Validation passed', $validated);

            $features = collect($validated)->except('patient_id')->toArray();
            \Log::info('📤 [STEP 3] Sending to Flask API', $features);

            $response = Http::timeout(5)->post('http://127.0.0.1:5000/predict-heart', $features);

            if (!$response->successful()) {
                \Log::error('❌ Flask API failed', ['body' => $response->body()]);
                return back()->with('error', 'Flask AI failed: ' . $response->body());
            }

            $data = $response->json();
            \Log::info('📥 [STEP 4] Received from Flask', $data);

            $modelName = $data['model_name'] ?? 'Heart Failure';

            $aiModel = AiModel::firstOrCreate(
                ['name' => $modelName],
                ['description' => 'AI model for predicting heart failure risk']
            );

            $ai = Ai::create([
                'ai_model_id' => $aiModel->id,
                'patient_id' => $validated['patient_id'],
                'doctor_id' => auth('doctor')->id(),
                'submitted_attributes' => json_encode($features),
                'result' => $data['result'] ? 'Positive' : 'Negative',
                'percentage_probability' => $data['probability'],
            ]);

            \Log::info('✅ STEP 5: Record inserted', $ai->toArray());

            return redirect()->route('doctor.ai.test.result', $ai->id)
                ->with('success', 'Prediction saved successfully.');
        } catch (\Throwable $e) {
            \Log::error('❌ Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    // Show the result
    public function showResult($id)
    {
        $record = Ai::with(['patient', 'doctor', 'aiModel'])->findOrFail($id);
        return view('doctor.ai-result', compact('record'));
    }
}
