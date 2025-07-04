<x-layout>
      <x-navbar />
    <div class="max-w-2xl mx-auto mt-12 bg-white shadow-md rounded-xl p-8 space-y-6" x-data="appointmentForm()" x-init="init()">
        <h2 class="text-3xl font-bold text-teal-700 text-center">Book Your Appointment</h2>

        <form action="{{ route('patient.appointment.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Doctor:</label>
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                <p class="mt-1 text-gray-900 font-semibold">{{ $doctor->first_name }} {{ $doctor->last_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Clinic:</label>
                <input type="hidden" name="clinic_id" value="{{ $doctor->clinic->id }}">
                <p class="mt-1 text-gray-900 font-semibold">{{ $doctor->clinic->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Select Date:</label>
                <input type="date" name="appointment_date" x-model="selectedDate" @change="fetchSlots"
                       :min="minDate" :max="maxDate" @input="preventFullyBooked($event)"
                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                @error('appointment_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

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

            <input type="hidden" name="appointment_datetime" :value="selectedDate + 'T' + selectedTime">

            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-sm font-medium text-gray-700 mb-2">Doctor Availability:</p>
                <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        @if (!empty($schedules[$day]['from']) && !empty($schedules[$day]['to']))
                            <li><strong>{{ $day }}:</strong> From {{ $schedules[$day]['from'] }} to {{ $schedules[$day]['to'] }}</li>
                        @else
                            <li><strong>{{ $day }}:</strong> <span class="text-red-500">Not Available</span></li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-2 rounded-md shadow transition">
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
                disabledDates: [],
                minDate: new Date().toISOString().split('T')[0],
                maxDate: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],

                init() {
                    fetch(`/api/fully-booked-dates?doctor_id={{ $doctor->id }}`)
                        .then(res => res.json())
                        .then(data => {
                            this.disabledDates = data;
                        });
                },

                fetchSlots() {
                    if (!this.selectedDate) return;

                    fetch(`/api/available-slots?doctor_id={{ $doctor->id }}&date=${this.selectedDate}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.fully_booked) {
                                this.availableSlots = [];
                                this.selectedTime = '';
                                alert("Doctor is fully booked for this day. Please choose another date.");
                                return;
                            }
                            this.availableSlots = data.slots;
                            this.selectedTime = '';
                        })
                        .catch(error => {
                            console.error("Error fetching slots:", error);
                            alert("Something went wrong while loading available slots.");
                        });
                },

                preventFullyBooked(e) {
                    const selected = e.target.value;
                    if (this.disabledDates.includes(selected)) {
                        alert("Doctor is fully booked for this day.");
                        this.selectedDate = '';
                        e.target.value = '';
                    }
                }
            }
        }
    </script>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-layout>
