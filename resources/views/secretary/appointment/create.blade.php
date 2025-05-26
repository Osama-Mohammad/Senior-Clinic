<x-layout>
    <div class="max-w-2xl mx-auto mt-12 bg-white shadow-md rounded-xl p-8 space-y-6" x-data="appointmentForm()"
        x-init="init()">

        <h2 class="text-3xl font-bold text-teal-700 text-center">Book Your Appointment</h2>

        <form action="{{ route('secretary.patient.storeAppointment', $patient) }}" method="POST" class="space-y-5">
            @csrf

            <!-- Doctor Info -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Doctor:</label>
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                <p class="mt-1 text-gray-900 font-semibold">
                    {{ $doctor->first_name }} {{ $doctor->last_name }}
                </p>
            </div>

            <!-- Clinic Info -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Clinic:</label>
                <input type="hidden" name="clinic_id" value="{{ $doctor->clinic->id }}">
                <p class="mt-1 text-gray-900 font-semibold">{{ $doctor->clinic->name }}</p>
            </div>

            <!-- Appointment Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Select Date:</label>
                <input type="date" name="appointment_date" x-model="selectedDate" @change="fetchSlots"
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                @error('appointment_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Time Slot -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Select Time Slot:</label>
                <select name="appointment_time" x-model="selectedTime"
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <template x-for="slot in availableSlots" :key="slot">
                        <option :value="slot" x-text="slot"></option>
                    </template>
                </select>
                @error('appointment_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hidden full datetime -->
            <input type="hidden" name="appointment_datetime" :value="selectedDate + 'T' + selectedTime">

            <!-- Doctor's Availability (Display Only) -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-sm font-medium text-gray-700 mb-2">Doctor Availability:</p>
                <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                    @foreach ($schedules as $day => $data)
                        <li><strong>{{ $day }}:</strong> From {{ $data['from'] }} to {{ $data['to'] }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Submit -->
            <div class="text-center">
                <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-2 rounded-md shadow transition">
                    Confirm Appointment
                </button>
            </div>
        </form>
    </div>

    <script>
        function appointmentForm() {
            return {
                selectedDate: '',
                selectedTime: '',
                availableSlots: [],
                init() {
                    // You can auto-select today's date or other logic
                },
                fetchSlots() {
                    if (!this.selectedDate) return;
                    fetch(`/api/available-slots?doctor_id={{ $doctor->id }}&date=${this.selectedDate}`)
                        .then(res => res.json())
                        .then(data => {
                            this.availableSlots = data;
                            this.selectedTime = '';
                        });
                }
            }
        }
    </script>
</x-layout>
