    @extends('layouts.doctor-layout')

    @section('content')
        <div class="max-w-3xl mx-auto py-10">
            <h2 class="text-2xl font-bold mb-6 text-teal-700">🧠 Stroke Prediction Result</h2>

            <div class="bg-white p-6 shadow rounded">
                <p><strong>Patient:</strong> {{ $record->patient->first_name }} {{ $record->patient->last_name }}</p>
                <p><strong>Doctor:</strong> Dr. {{ $record->doctor->first_name }} {{ $record->doctor->last_name }}</p>
                <p><strong>Model:</strong> {{ $record->aiModel->name }}</p>
                <p><strong>Prediction:</strong> <span
                        class="{{ $record->result == 'Positive' ? 'text-red-600' : 'text-green-600' }}">{{ $record->result }}</span>
                </p>
                <p><strong>Probability:</strong> {{ $record->percentage_probability }}%</p>
                <p class="mt-4"><strong>Inputs:</strong></p>
                <ul class="ml-4 list-disc">
                    @foreach (json_decode($record->submitted_attributes, true) as $key => $value)
                        <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                    @endforeach
                </ul>


            </div>
        </div>
    @endsection
