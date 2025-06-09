<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\StrokePrediction;
use App\Models\AiModel;

class StrokePredictionController extends Controller
{
    const MAX_AGE = 82;
    const MAX_GLUCOSE = 271;
    const MAX_BMI = 97;

    public function showForm()
    {
        $doctor = auth('doctor')->user();
        $patients = $doctor->patients ?? [];
        return view('doctor.stroke.form', compact('patients'));
    }

    public function submitForm(Request $request)
    {
        try {
            Log::info('🔥 Stroke Form Submitted');

            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'gender' => 'required|string',
                'age' => 'required|numeric',
                'hypertension' => 'required|boolean',
                'heart_disease' => 'required|boolean',
                'ever_married' => 'required|string',
                'work_type' => 'required|string',
                'Residence_type' => 'required|string',
                'avg_glucose_level' => 'required|numeric',
                'bmi' => 'required|numeric',
                'smoking_status' => 'required|string',
            ]);

            $features = [
                'gender' => $validated['gender'],
                'hypertension' => (int) $validated['hypertension'],
                'heart_disease' => (int) $validated['heart_disease'],
                'ever_married' => $validated['ever_married'],
                'Residence_type' => $validated['Residence_type'],
                'work_type' => $validated['work_type'],
                'smoking_status' => $validated['smoking_status'],
                'age' => $validated['age'],  // ⛔ no normalization
                'avg_glucose_level' => $validated['avg_glucose_level'],
                'bmi' => $validated['bmi'],
            ];
            Log::info('📤 Sending to Stroke Flask API', $features);

            $response = Http::timeout(5)->post('http://127.0.0.1:5000/predict-stroke', $features);

            if (!$response->successful()) {
                Log::error('❌ Flask Stroke API Failed', ['body' => $response->body()]);
                return back()->with('error', 'Stroke prediction service is unavailable.');
            }

            $data = $response->json();
            Log::info('📥 Stroke API Response', $data);

            $aiModel = AiModel::firstOrCreate(
                ['name' => 'Stroke Predictor'],
                ['description' => 'AI model for predicting stroke risk']
            );

            $prediction = StrokePrediction::create([
                'ai_model_id' => $aiModel->id,
                'patient_id' => $validated['patient_id'],
                'doctor_id' => auth('doctor')->id(),
                'submitted_attributes' => json_encode($features),
                'result' => $data['result'] ? 'Stroke' : 'No Stroke',
                'percentage_probability' => $data['probability'],
            ]);

            return redirect()->route('doctor.stroke.test.result', ['id' => $prediction->id])
                ->with('success', 'Stroke prediction saved successfully.');
        } catch (\Throwable $e) {
            Log::error('❌ Exception during Stroke Prediction', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function showResult($id)
    {
        $record = StrokePrediction::with(['patient', 'doctor', 'aiModel'])->findOrFail($id);
        $features = json_decode($record->submitted_attributes, true);

        $raw = [
            'age' => round($features['age'] * self::MAX_AGE),
            'avg_glucose_level' => round($features['avg_glucose_level'] * self::MAX_GLUCOSE, 2),
            'bmi' => round($features['bmi'] * self::MAX_BMI, 2),
            'gender' => $features['gender'],
            'hypertension' => $features['hypertension'],
            'heart_disease' => $features['heart_disease'],
            'ever_married' => $features['ever_married'],
            'work_type' => $features['work_type'],
            'Residence_type' => $features['Residence_type'],
            'smoking_status' => $features['smoking_status'],
        ];

        return view('doctor.stroke.result', compact('record', 'features', 'raw'));
    }
}
