<x-layout>
    <x-navbar />
    <div class="max-w-6xl mx-auto mt-10 px-4" x-data="appointmentManager()" x-init="init()">

        <!-- ✅ Toast Notification -->
        <div x-show="showToast" x-transition
            :class="{
                'bg-green-500': toastType === 'success',
                'bg-red-500': toastType === 'error'
            }"
            class="fixed top-5 right-5 text-white px-6 py-3 rounded-lg shadow-lg z-50"
            x-text="toastMessage">
        </div>

        <!-- ✅ Page Title -->
        <h2 class="text-2xl font-bold text-blue-800 mb-6 text-center">
            Welcome {{ $patient->first_name }}
        </h2>

        <!-- ✅ Appointment Table -->
        <div class="overflow-x-auto rounded-xl shadow-lg bg-white">
            <template x-if="appointments.length > 0">
                <table class="min-w-full divide-y divide-blue-200">
                    <thead class="bg-blue-100 text-blue-900 text-sm font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Doctor</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <template x-for="appointment in appointments" :key="appointment.id">
                            <tr class="hover:bg-blue-50 transition duration-200 ease-in-out">
                                <td class="px-6 py-4 font-medium text-blue-800" x-text="appointment.id"></td>
                                <td class="px-6 py-4 font-medium" x-text="appointment.doctor_name"></td>
                                <td class="px-6 py-4 text-sm text-gray-600" x-text="appointment.appointment_datetime"></td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full shadow-sm"
                                        :class="{
                                            'bg-green-100 text-green-700': appointment.status === 'Completed',
                                            'bg-yellow-100 text-yellow-800': appointment.status === 'Booked',
                                            'bg-orange-100 text-orange-700': appointment.status === 'Cancel Requested',
                                            'bg-red-100 text-red-700': appointment.status === 'Canceled'
                                        }"
                                        x-text="appointment.status">
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        x-show="appointment.status === 'Booked'"
                                        @click="cancelAppointment(appointment)"
                                        class="text-red-600 hover:text-red-800 text-sm font-semibold underline underline-offset-2">
                                        Cancel
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>

            <!-- 🕳️ Empty State -->
            <template x-if="appointments.length === 0">
                <div class="text-center px-6 py-10 text-gray-500 italic">No appointments found.</div>
            </template>
        </div>
    </div>

    <!-- ✅ Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <script>
        function appointmentManager() {
            return {
                appointments: [],
                toastMessage: '',
                toastType: 'success',
                showToast: false,
                toastTimeout: null,

                init() {
                    this.fetchAppointments();
                },

                fetchAppointments() {
                    axios.get('{{ route('patient.appointments.search') }}')
                        .then(res => {
                            this.appointments = res.data.map(a => ({
                                ...a,
                                doctor_name: a.doctor_name
                            }));
                        });
                },

                cancelAppointment(appointment) {
                    const confirmed = confirm("Are you sure you want to cancel this appointment?");
                    if (!confirmed) return;

                    axios.patch(`/patient/appointment/${appointment.id}/update-status`, {
                        status: 'Canceled'
                    }).then(res => {
                        appointment.status = res.data.status;
                        this.toastType = 'success';
                        this.toastMessage = 'Appointment canceled successfully.';
                        this.showToastMessage();
                    }).catch(error => {
                        this.toastType = 'error';
                        this.toastMessage = error.response?.data?.error || 'Failed to cancel appointment.';
                        this.showToastMessage();
                    });
                },

                formatDate(datetime) {
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    };
                    return new Date(datetime).toLocaleString('en-US', options);
                },

                showToastMessage() {
                    this.showToast = true;
                    clearTimeout(this.toastTimeout);
                    this.toastTimeout = setTimeout(() => this.showToast = false, 3000);
                }
            }
        }
    </script>
</x-layout>
