<x-layout>
    <!-- AlpineJS Component -->
    <div class="max-w-6xl mx-auto mt-10 px-4" x-data="appointmentFilter()" x-init="init()">
        <h2 class="text-2xl font-bold text-blue-800 mb-6 text-center">Doctor Appointments</h2>

        <!-- Filter Dropdown -->
        <div class="mb-6 max-w-sm mx-auto">
            <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Filter by Status</label>
            <select id="status" x-model="selectedStatus" @change="filterAppointments"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400">
                <option value="">All</option>
                <option value="Booked">Booked</option>
                <option value="Cancel Requested">Cancel Requested</option>
                <option value="Canceled">Canceled</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        <!-- Appointments Table -->
        <div class="overflow-x-auto rounded-xl shadow-lg bg-white">
            <template x-if="appointments.length > 0">
                <table class="min-w-full divide-y divide-blue-200">
                    <thead class="bg-blue-100 text-blue-900 text-sm font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Patient</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <template x-for="appointment in appointments" :key="appointment.id">
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4" x-text="appointment.id"></td>
                                <td class="px-6 py-4">
                                    <a :href="`/doctor/patient/${appointment.patient_id}/show`"
                                        class="text-blue-600 hover:underline" x-text="appointment.patient_name">
                                    </a>
                                </td>
                                <td class="px-6 py-4" x-text="appointment.appointment_datetime"></td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                        :class="{
                                            'bg-green-100 text-green-700': appointment.status === 'Completed',
                                            'bg-yellow-100 text-yellow-800': appointment.status === 'Booked',
                                            'bg-orange-100 text-orange-700': appointment.status === 'Cancel Requested',
                                            'bg-red-100 text-red-700': appointment.status === 'Canceled'
                                        }"
                                        x-text="appointment.status">
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>

            <!-- Empty State -->
            <template x-if="appointments.length === 0">
                <div class="text-center px-6 py-10 text-gray-500 italic">No Appointments Found.</div>
            </template>
        </div>
    </div>

    <!-- Include Axios and AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <!-- AlpineJS Logic -->
    <script>
        function appointmentFilter() {
            return {
                selectedStatus: '',
                appointments: [],
                fetchAppointments() {
                    console.log("Fetching with status:", this.selectedStatus);
                    axios.get('{{ route('doctor.appointments.search') }}', {
                        params: {
                            status: this.selectedStatus
                        }
                    }).then(response => {
                        this.appointments = response.data;
                    }).catch(error => {
                        console.error('Error fetching appointments:', error);
                        this.appointments = [];
                    });
                },
                filterAppointments() {
                    this.fetchAppointments();
                },
                init() {
                    this.fetchAppointments();
                }
            };
        }
    </script>
</x-layout>
