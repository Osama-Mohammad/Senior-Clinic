@extends('layouts.doctor-layout')

@section('content')
    <div class="min-h-screen bg-gradient-to-r from-blue-50 to-cyan-50 flex items-center justify-center py-12 px-6">
        <div class="w-full max-w-2xl bg-white p-8 rounded-2xl shadow-2xl space-y-6 animate-fade-in">

            <h2 class="text-2xl font-bold text-center text-teal-700">🧠 Run AI Heart Failure Test</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('doctor.ai.test.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Select Patient:</label>
                    <select name="patient_id" required class="w-full rounded border-gray-300">
                        <option value="">-- Choose Patient --</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Inputs: Numeric -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ai.number-input label="Age (normalized)" name="norm_age" />
                    <x-ai.number-input label="Creatinine Phosphokinase (normalized)" name="norm_creatinine_phosphokinase" />
                    <x-ai.number-input label="Ejection Fraction (normalized)" name="norm_ejection_fraction" />
                    <x-ai.number-input label="Platelets (normalized)" name="norm_platelets" />
                    <x-ai.number-input label="Serum Creatinine (normalized)" name="norm_serum_creatinine" />
                    <x-ai.number-input label="Serum Sodium (normalized)" name="norm_serum_sodium" />
                    <x-ai.number-input label="Time (normalized)" name="norm_time" />
                </div>

                <!-- Inputs: Binary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ai.binary-select label="Anaemia" name="anaemia" />
                    <x-ai.binary-select label="Diabetes" name="diabetes" />
                    <x-ai.binary-select label="High Blood Pressure" name="high_blood_pressure" />
                </div>

                <div class="text-center pt-4">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow">
                        🔍 Run Prediction
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
