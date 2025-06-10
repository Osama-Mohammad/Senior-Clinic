<x-layout>
    <div class="max-w-6xl mx-auto mt-10 px-4" x-data="appointmentFilter()" x-init="init()">
        <!-- ✅ Toast Notification -->
        <div x-show="showToast" x-transition
            :class="{
                'bg-green-500': toastType === 'success',
                'bg-red-500': toastType === 'error'
            }"
            class="fixed top-5 right-5 text-white px-6 py-3 rounded-lg shadow-lg z-50" x-text="toastMessage">
        </div>

        <h2 class="text-2xl font-bold text-blue-800 mb-6 text-center">Secretary {{ $secretary->first_name }}</h2>

        <!-- ✅ Filters -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <!-- Status Filter -->
            <div class="w-full md:w-1/2">
                <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Filter by Status</label>
                <select id="status" x-model="selectedStatus" @change="filterAppointments"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400">
                    <option value="">All</option>
                    <option value="Booked">Booked</option>
                    <option value="Canceled">Canceled</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <!-- Patient Search -->
            <div class="w-full md:w-1/2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Search by Patient</label>
                <input type="text" x-model="searchQuery"
                    placeholder="Enter patient name"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <!-- ✅ Export Button -->
        <div class="mb-4 text-right">
            <button @click="exportToPDF"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow">
                Export Table to PDF
            </button>
        </div>

        <!-- ✅ Appointments Table -->
        <div class="overflow-x-auto rounded-xl shadow-lg bg-white" id="appointmentsTable">
            <template x-if="filteredAppointments.length > 0">
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
                        <template x-for="appointment in filteredAppointments" :key="appointment.id">
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4" x-text="appointment.id"></td>
                                <td class="px-6 py-4">
                                    <a :href="`/secretary/patient/${appointment.patient_id}/show`"
                                        class="text-blue-600 hover:underline" x-text="appointment.patient_name">
                                    </a>
                                </td>
                                <td class="px-6 py-4" x-text="formatDate(appointment.appointment_datetime)"></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <select
                                            @focus="appointment._previousStatus = appointment.status"
                                            @change="handleStatusChange(appointment)"
                                            x-model="appointment.status"
                                            :disabled="appointment.status === 'Completed'"
                                            class="border border-gray-300 text-sm rounded px-2 py-1 focus:ring focus:ring-blue-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <option value="Booked">Booked</option>
                                            <option value="Canceled">Canceled</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full"
                                            :class="{
                                                'bg-green-100 text-green-700': appointment.status === 'Completed',
                                                'bg-yellow-100 text-yellow-800': appointment.status === 'Booked',
                                                'bg-orange-100 text-orange-700': appointment.status === 'Cancel Requested',
                                                'bg-red-100 text-red-700': appointment.status === 'Canceled'
                                            }"
                                            x-text="appointment.status">
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>

            <template x-if="filteredAppointments.length === 0">
                <div class="text-center px-6 py-10 text-gray-500 italic">No Appointments Found.</div>
            </template>
        </div>
    </div>

    <!-- ✅ Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs/dayjs.min.js"></script>

    <!-- ✅ Alpine Component Logic -->
    <script>
        function appointmentFilter() {
            return {
                selectedStatus: '',
                searchQuery: '',
                appointments: [],
                showToast: false,
                toastMessage: '',
                toastTimeout: null,
                toastType: 'success',

                get filteredAppointments() {
                    return this.appointments.filter(a =>
                        (!this.searchQuery || a.patient_name.toLowerCase().includes(this.searchQuery.toLowerCase())) &&
                        (!this.selectedStatus || a.status === this.selectedStatus)
                    );
                },

                formatDate(dateStr) {
                    return dayjs(dateStr).format('MMMM D, YYYY – h:mm A');
                },

                fetchAppointments() {
                    axios.get('{{ route('secretary.appointments.search') }}', {
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

                handleStatusChange(appointment) {
                    const newStatus = appointment.status;
                    const oldStatus = appointment._previousStatus;

                    // Confirmation logic
                    if (newStatus === 'Canceled') {
                        if (!confirm("Are you sure you want to cancel this appointment?")) {
                            appointment.status = oldStatus;
                            return;
                        }
                    }

                    if (newStatus === 'Completed') {
                        if (!confirm("Mark this appointment as completed?")) {
                            appointment.status = oldStatus;
                            return;
                        }
                    }

                    this.updateStatus(appointment);
                },

                updateStatus(appointment) {
                    axios.patch(`/secretary/appointment/${appointment.id}/update-status`, {
                        status: appointment.status
                    }).then(response => {
                        this.toastType = 'success';
                        this.toastMessage = `Status updated to "${response.data.status}"`;
                        this.showToastMessage();
                    }).catch(error => {
                        appointment.status = appointment._previousStatus;
                        this.toastType = 'error';
                        this.toastMessage = error.response?.data?.error || 'Failed to update status.';
                        this.showToastMessage();
                    });
                },

                exportToPDF() {
                    const table = document.querySelector('#appointmentsTable');
                    html2pdf().set({
                        filename: 'appointments.pdf',
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                    }).from(table).save();
                },

                showToastMessage() {
                    this.showToast = true;
                    clearTimeout(this.toastTimeout);
                    this.toastTimeout = setTimeout(() => {
                        this.showToast = false;
                    }, 3000);
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
