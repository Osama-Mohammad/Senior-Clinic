<x-layout>
    <section class="min-h-screen bg-gradient-to-br from-white via-teal-50 to-teal-100 py-12 px-4">
        {{-- Header --}}
        <div class="max-w-7xl mx-auto mb-10 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-teal-800">Patient Management</h1>
            <a href="{{ route('secretary.patient.create') }}"
               class="bg-gradient-to-r from-teal-500 to-teal-700 text-white px-6 py-2 rounded-xl shadow-md hover:shadow-xl hover:scale-105 transform transition-all duration-200 font-medium">
                + New Patient
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="max-w-3xl mx-auto mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search Bar --}}
        <div class="max-w-xl mx-auto mb-10 relative">
            <input type="text" id="patient-search"
                class="w-full pl-12 pr-5 py-3 rounded-full bg-white border-2 border-teal-300 shadow focus:ring-2 focus:ring-teal-500 focus:outline-none text-gray-700 placeholder:text-gray-400"
                placeholder="🔍 Search patients by name…" autocomplete="off" />
            <span class="absolute left-5 top-3 text-xl text-teal-500">🔍</span>
        </div>

        {{-- Patients List --}}
        <div id="patients-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @foreach ($patients as $patient)
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all p-6 flex flex-col border border-teal-100">
                    @if ($patient->image)
                        <img src="{{ asset('storage/' . $patient->image) }}"
                            class="w-full h-48 object-cover rounded-xl mb-4 border border-gray-200">
                    @endif
                    <h3 class="text-xl font-bold text-gray-800 mb-1">
                        {{ $patient->first_name }} {{ $patient->last_name }}
                    </h3>
                    <p class="text-sm text-white inline-block bg-teal-500 px-3 py-1 rounded-full w-fit">
                        {{ $patient->specialization ?? 'General' }}
                    </p>
                    <a href="{{ route('secretary.patient.createAppointment', $patient) }}"
                        class="mt-5 inline-block text-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold text-sm px-6 py-2 rounded-full shadow-md hover:shadow-lg transition-all">
                        📅 Book Appointment
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div id="patients-pagination" class="mt-10 max-w-7xl mx-auto">
            {{ $patients->links() }}
        </div>
    </section>

    {{-- Search JS --}}
    <script>
        const patientSearchUrl = "{{ route('search.patients') }}";
        const patientListEl = document.getElementById('patients-list');
        const patientPagEl = document.getElementById('patients-pagination');
        const originalPatients = patientListEl.innerHTML;
        const originalPatientsPag = patientPagEl ? patientPagEl.innerHTML : '';

        document.getElementById('patient-search').addEventListener('input', function () {
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
                                    <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all p-6 flex flex-col border border-teal-100">
                                        ${p.image
                                            ? `<img src="/storage/${p.image}" class="w-full h-48 object-cover rounded-xl mb-4 border border-gray-200">`
                                            : ''
                                        }
                                        <h3 class="text-xl font-bold text-gray-800 mb-1">${p.first_name} ${p.last_name}</h3>
                                        <p class="text-sm text-white inline-block bg-teal-500 px-3 py-1 rounded-full w-fit">
                                            ${p.specialization || 'General'}
                                        </p>
                                        <a href="/secretary/patient/${p.id}/appointments/create"
                                           class="mt-5 inline-block text-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold text-sm px-6 py-2 rounded-full shadow-md hover:shadow-lg transition-all">
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
