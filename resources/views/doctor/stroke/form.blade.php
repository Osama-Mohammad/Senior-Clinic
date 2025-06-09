@extends('layouts.doctor-layout')

@section('content')
    <div class="max-w-3xl mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6 text-teal-700">🧠 Stroke Prediction Test</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">{{ session('error') }}</div>
        @endif

        <form action="{{ route('doctor.stroke.test.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="patient_id" class="font-medium">Select Patient:</label>
                <select name="patient_id" required class="w-full p-2 border rounded">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block">Gender:</label>
                    <select name="gender" class="w-full p-2 border rounded">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div>
                    <label class="block">Age:</label>
                    <input type="number" step="0.1" name="age" required class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block">Hypertension:</label>
                    <select name="hypertension" class="w-full p-2 border rounded">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div>
                    <label class="block">Heart Disease:</label>
                    <select name="heart_disease" class="w-full p-2 border rounded">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div>
                    <label class="block">Ever Married:</label>
                    <select name="ever_married" class="w-full p-2 border rounded">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div>
                    <label class="block">Work Type:</label>
                    <select name="work_type" class="w-full p-2 border rounded">
                        <option value="Private">Private</option>
                        <option value="Self-employed">Self-employed</option>
                        <option value="Govt_job">Govt_job</option>
                        <option value="children">children</option>
                        <option value="Never_worked">Never_worked</option>
                    </select>
                </div>

                <div>
                    <label class="block">Residence Type:</label>
                    <select name="Residence_type" class="w-full p-2 border rounded">
                        <option value="Urban">Urban</option>
                        <option value="Rural">Rural</option>
                    </select>
                </div>

                <div>
                    <label class="block">Average Glucose Level:</label>
                    <input type="number" step="0.01" name="avg_glucose_level" required class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block">BMI:</label>
                    <input type="number" step="0.01" name="bmi" required class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block">Smoking Status:</label>
                    <select name="smoking_status" class="w-full p-2 border rounded">
                        <option value="never smoked">never smoked</option>
                        <option value="formerly smoked">formerly smoked</option>
                        <option value="smokes">smokes</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="mt-6 px-6 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Run Prediction</button>
        </form>
    </div>
@endsection
