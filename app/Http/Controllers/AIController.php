<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Ai;
use App\Models\AiModel;

class AIController extends Controller
{
    // Constants for normalization
    const MAX_AGE = 95;
    const MAX_CPK = 7861;
    const MAX_EJECTION = 80;
    const MAX_PLATELETS = 850000;
    const MAX_CREATININE = 9.4;
    const MAX_SODIUM = 148;
    const MAX_TIME = 285;

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

            // Validate raw inputs
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'age' => 'required|numeric',
                'anaemia' => 'required|boolean',
                'creatinine_phosphokinase' => 'required|numeric',
                'diabetes' => 'required|boolean',
                'ejection_fraction' => 'required|numeric',
                'high_blood_pressure' => 'required|boolean',
                'platelets' => 'required|numeric',
                'serum_creatinine' => 'required|numeric',
                'serum_sodium' => 'required|numeric',
                'time' => 'required|numeric',
                'sex' => 'required|boolean',
                'smoking' => 'required|boolean',
            ]);

            \Log::info('✅ STEP 2: Validation passed', $validated);

            // Normalize values before sending to AI model
            $features = [
                'norm_age' => $validated['age'] / self::MAX_AGE,
                'anaemia' => $validated['anaemia'],
                'norm_creatinine_phosphokinase' => $validated['creatinine_phosphokinase'] / self::MAX_CPK,
                'diabetes' => $validated['diabetes'],
                'norm_ejection_fraction' => $validated['ejection_fraction'] / self::MAX_EJECTION,
                'high_blood_pressure' => $validated['high_blood_pressure'],
                'norm_platelets' => $validated['platelets'] / self::MAX_PLATELETS,
                'norm_serum_creatinine' => $validated['serum_creatinine'] / self::MAX_CREATININE,
                'norm_serum_sodium' => $validated['serum_sodium'] / self::MAX_SODIUM,
                'norm_time' => $validated['time'] / self::MAX_TIME,
                'sex' => $validated['sex'],
                'smoking' => $validated['smoking'],
            ];

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

        // Decode normalized features
        $normalized = json_decode($record->submitted_attributes, true);

        // Rebuild original (unnormalized) inputs from stored normalized values
        $raw = [
            'age' => round($normalized['norm_age'] * self::MAX_AGE),
            'creatinine_phosphokinase' => round($normalized['norm_creatinine_phosphokinase'] * self::MAX_CPK),
            'ejection_fraction' => round($normalized['norm_ejection_fraction'] * self::MAX_EJECTION),
            'platelets' => round($normalized['norm_platelets'] * self::MAX_PLATELETS),
            'serum_creatinine' => round($normalized['norm_serum_creatinine'] * self::MAX_CREATININE, 2),
            'serum_sodium' => round($normalized['norm_serum_sodium'] * self::MAX_SODIUM, 2),
            'time' => round($normalized['norm_time'] * self::MAX_TIME),
            'anaemia' => $normalized['anaemia'],
            'diabetes' => $normalized['diabetes'],
            'high_blood_pressure' => $normalized['high_blood_pressure'],
            'sex' => $normalized['sex'],
            'smoking' => $normalized['smoking'],
        ];

        return view('doctor.ai-result', compact('record', 'normalized', 'raw'));
    }
}
