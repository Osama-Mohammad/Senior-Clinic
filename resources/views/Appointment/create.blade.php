<x-layout>
    <h2 class="text-xl font-bold mb-4">Book Appointment</h2>

    <form action="{{ route('patient.appointment.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="doctor_id">Doctor:</label>
            <input type="hidden" value="{{ $doctor->id }}" name="doctor_id">
            <p>{{ $doctor->first_name }} {{ $doctor->last_name }}</p>
            @error('doctor_id')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="clinic_id">Clinic:</label>
            <input type="hidden" value="{{ $doctor->clinic->id }}" name="clinic_id">{{ $doctor->clinic->name }}</input>
            @error('clinic_id')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="appointment_datetime">Date & Time:</label>
            <input type="datetime-local" id="appointment_datetime" name="appointment_datetime"
                class="w-full border p-2">
            @error('appointment_datetime')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>


        <p>
        <ul>
            @foreach ($schedules as $day => $data)
                <li>
                    <strong>{{ $day }}</strong>
                    From {{ $data['from'] }} to {{ $data['to'] }}
                </li>
            @endforeach
        </ul>
        </p>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Book Appointment</button>
    </form>


</x-layout>
