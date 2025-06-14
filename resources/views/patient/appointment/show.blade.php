<x-layout>
  <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Page Title --}}
    <h1 class="text-3xl font-bold mb-6">
      Appointment with Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}
    </h1>

    {{-- Appointment Details Card --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <h2 class="text-sm font-semibold text-gray-500 uppercase">Date &amp; Time</h2>
          <p class="mt-1 text-gray-700">
            {{ $appointment->appointment_datetime->format('d M Y, H:i') }}
          </p>
        </div>
        <div>
          <h2 class="text-sm font-semibold text-gray-500 uppercase">Status</h2>
          <p class="mt-1">
            <span
              class="inline-block px-3 py-1 rounded-full text-sm font-medium"
              :class="{
                'bg-green-100 text-green-700': '{{ $appointment->status }}' === 'completed',
                'bg-yellow-100 text-yellow-800': '{{ $appointment->status }}' === 'booked',
                'bg-red-100 text-red-700': '{{ $appointment->status }}' === 'canceled'
              }"
              class="bg-gray-100 text-gray-800"
            >
              {{ ucfirst($appointment->status) }}
            </span>
          </p>
        </div>
        <div>
          <h2 class="text-sm font-semibold text-gray-500 uppercase">Patient</h2>
          <p class="mt-1 text-gray-700">
            {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
          </p>
        </div>
      </div>
    </div>

    {{-- Patient History --}}
    <h2 class="text-2xl font-bold mb-4">Patient History</h2>

    @if($appointment->log)
      <div class="bg-white shadow rounded-lg p-6 mb-6">
        {{-- Description --}}
        <h3 class="text-xl font-semibold mb-2">Doctor’s Notes</h3>
        <p class="text-gray-700 whitespace-pre-wrap">
          {{ $appointment->log->description }}
        </p>

        {{-- Treatment --}}
        <h4 class="font-semibold text-purple-700 mt-4">💊 Treatment Plan</h4>
        <p class="text-gray-700">
          {{ $appointment->log->treatment ? $appointment->log->treatment : 'No treatment plan provided.' }}
        </p>

        {{-- Doctor's Recommendation --}}
        <h4 class="font-semibold text-green-700 mt-4">✅ Doctor’s Recommendation</h4>
        <p class="text-gray-700">
          {{ $appointment->log->recommendation ? $appointment->log->recommendation : 'No recommendation provided.' }}
        </p>

        {{-- Attachments --}}
        @if(!empty($appointment->log->attachments))
          <div class="mt-6">
            <h4 class="font-semibold mb-2">Attachments</h4>
            <ul class="list-disc list-inside space-y-1">
              @foreach($appointment->log->attachments as $path)
                <li>
                  <a
                    href="{{ Storage::url($path) }}"
                    target="_blank"
                    class="text-teal-600 hover:underline"
                  >
                    {{ basename($path) }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    @else
      <p class="text-gray-500 italic">No history has been recorded for this appointment yet.</p>
    @endif

    {{-- Back Link --}}
    <a
      href="{{ route('patient.appointment.index') }}"
      class="inline-block mt-4 text-teal-600 hover:underline"
    >
      ← Back to My Appointments
    </a>
  </div>
</x-layout>
