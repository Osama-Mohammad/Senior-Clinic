<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-teal-100 py-12 px-4">
        <div class="bg-white max-w-xl w-full p-8 rounded-2xl shadow-xl space-y-6 animate-fade-in">

            <h2 class="text-2xl font-bold text-teal-700 text-center">🩺 Heart Failure Prediction Result</h2>

            <p><strong>Patient:</strong> {{ $record->patient->first_name }} {{ $record->patient->last_name }}</p>
            <p><strong>Doctor:</strong> {{ $record->doctor->first_name }} {{ $record->doctor->last_name }}</p>
            <p><strong>Model Used:</strong> {{ $record->aiModel->name }}</p>

            <div class="bg-gray-100 p-4 rounded">
                <p><strong>Result:</strong>
                    <span class="{{ $record->result === 'Positive' ? 'text-red-600' : 'text-green-600' }}">
                        {{ $record->result }}
                    </span>
                </p>
                <p><strong>Probability:</strong> {{ $record->percentage_probability }}%</p>
            </div>

            <div>
                <h4 class="font-semibold mt-4">Submitted Data:</h4>
                <pre class="bg-gray-50 p-3 rounded text-sm overflow-x-auto">{{ json_encode(json_decode($record->submitted_attributes), JSON_PRETTY_PRINT) }}</pre>
            </div>

            <div class="text-center pt-4">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:underline">← Back to Dashboard</a>
            </div>
        </div>
    </div>
</x-layout>
