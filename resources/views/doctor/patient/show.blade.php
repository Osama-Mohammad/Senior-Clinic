<x-layout>
    <div class="max-w-4xl mx-auto mt-12 bg-white rounded-xl shadow-lg p-8">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <!-- Profile Image -->
            <div class="flex-shrink-0">
                <img src="{{ $patient->image ? asset('storage/' . $patient->image) : asset('default-avatar.png') }}"
                    alt="Patient Photo" class="w-40 h-40 object-cover rounded-full shadow-md border-2 border-blue-300">
            </div>

            <!-- Patient Info -->
            <div class="flex-1 space-y-4">
                <h2 class="text-2xl font-bold text-blue-800">
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-gray-700">
                    <div>
                        <span class="font-semibold">Email:</span> {{ $patient->email }}
                    </div>
                    <div>
                        <span class="font-semibold">Phone:</span> {{ $patient->phone_number }}
                    </div>
                    <div>
                        <span class="font-semibold">Gender:</span> {{ $patient->gender === 'M' ? 'Male' : 'Female' }}
                    </div>
                    <div>
                        <span class="font-semibold">Date of Birth:</span> {{ $patient->date_of_birth }}
                    </div>
                    <div class="md:col-span-2">
                        <span class="font-semibold">Address:</span> {{ $patient->address }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('doctor.appointments.index') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow">
                ⬅ Back to Appointments
            </a>
        </div>
    </div>
</x-layout>
