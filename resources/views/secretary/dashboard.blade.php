<x-layout>
    <section class="min-h-screen bg-gradient-to-br from-white via-teal-50 to-teal-100 py-12 px-6">
        {{-- Header --}}
        <div class="max-w-7xl mx-auto mb-10 flex flex-col md:flex-row justify-between items-center gap-4">
            <h1 class="text-4xl font-bold text-teal-800">👨‍⚕️ Patient Management</h1>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('secretary.patient.create') }}"
                    class="bg-gradient-to-r from-teal-500 to-teal-700 text-white px-6 py-2 rounded-xl shadow hover:shadow-xl hover:scale-105 transform transition duration-200 font-medium">
                    + New Patient
                </a>
                <a href="{{ route('secretary.appointments.index') }}"
                    class="bg-gradient-to-r from-teal-500 to-teal-700 text-white px-6 py-2 rounded-xl shadow hover:shadow-xl hover:scale-105 transform transition duration-200 font-medium">
                    📋 Manage Appointments
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-red-700 text-white px-6 py-2 rounded-xl shadow hover:shadow-xl hover:scale-105 transform transition duration-200 font-medium">
                        🚪 Log Out
                    </button>
                </form>
            </div>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="max-w-3xl mx-auto mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl shadow text-center text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search Bar --}}
        <div class="max-w-xl mx-auto mb-12 relative">
            <input type="text" id="patient-search"
                class="w-full pl-12 pr-5 py-3 rounded-full bg-white border-2 border-teal-300 shadow focus:ring-2 focus:ring-teal-500 focus:outline-none text-gray-700 placeholder-gray-400"
                placeholder="🔍 Search patients by name…" autocomplete="off" />
        </div>

        {{-- Patients Grid --}}
        <div id="patients-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @foreach ($patients as $patient)
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 p-6 border border-teal-100">
                    @if ($patient->image)
                        <img src="{{ asset('storage/' . $patient->image) }}"
                            class="w-full h-48 object-cover rounded-xl mb-4 border border-gray-200">
                    @endif
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                    <p class="text-sm text-white bg-teal-500 px-3 py-1 rounded-full w-fit mb-3">
                        {{ $patient->email ?? 'No Email Found' }}
                    </p>
                    <a href="{{ route('secretary.patient.createAppointment', $patient) }}"
                        class="block text-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold text-sm px-6 py-2 rounded-full shadow hover:shadow-lg transition">
                        📅 Book Appointment
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div id="patients-pagination" class="mt-12 max-w-7xl mx-auto text-center">
            {{ $patients->links() }}
        </div>
    </section>

    {{-- Live Search Script --}}
    <script>
        const patientSearchUrl = "{{ route('search.patients') }}";
        const patientListEl = document.getElementById('patients-list');
        const patientPagEl = document.getElementById('patients-pagination');
        const originalPatients = patientListEl.innerHTML;
        const originalPatientsPag = patientPagEl ? patientPagEl.innerHTML : '';

        document.getElementById('patient-search').addEventListener('input', function() {
            const q = this.value.trim();
            if (q === '') {
                patientListEl.innerHTML = originalPatients;
                if (patientPagEl) patientPagEl.innerHTML = originalPatientsPag;
                return;
            }

            if (q.length > 2) {
                fetch(`${patientSearchUrl}?query=${encodeURIComponent(q)}`)
                    .then(res => res.json())
                    .then(data => {
                        patientListEl.innerHTML = '';
                        if (data.patients.length === 0) {
                            patientListEl.innerHTML =
                                '<p class="col-span-full text-center text-gray-500">No patients found.</p>';
                        } else {
                            data.patients.forEach(p => {
                                patientListEl.innerHTML += `
                                    <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 p-6 border border-teal-100">
                                        ${p.image
                                            ? `<img src="/storage/${p.image}" class="w-full h-48 object-cover rounded-xl mb-4 border border-gray-200">`
                                            : ''
                                        }
                                        <h3 class="text-xl font-bold text-gray-800 mb-1">${p.first_name} ${p.last_name}</h3>
                                        <p class="text-sm text-white bg-teal-500 px-3 py-1 rounded-full w-fit mb-3">
                                            ${p.email || 'No Email'}
                                        </p>
                                        <a href="/secretary/patient/${p.id}/bookAppointment"
                                            class="block text-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold text-sm px-6 py-2 rounded-full shadow hover:shadow-lg transition">
                                            📅 Book Now
                                        </a>
                                    </div>`;
                            });
                        }
                        if (patientPagEl) patientPagEl.innerHTML = '';
                    })
                    .catch(() => {
                        patientListEl.innerHTML =
                            '<p class="col-span-full text-center text-red-500">Search failed. Please try again.</p>';
                    });
            }
        });
    </script>
</x-layout>
