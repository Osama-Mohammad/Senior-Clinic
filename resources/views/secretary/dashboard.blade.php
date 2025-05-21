<x-layout>
    <a href="{{ route('secretary.patient.create') }}">Create Patient</a>
    @if (session('success'))
        {{ session('success') }}
    @endif

    <div class="mb-8 max-w-2xl mx-auto">
        <input type="text" id="patient-search"
            class="w-full px-5 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-teal-500 focus:outline-none"
            placeholder="🔍 Search patients by first or last name…" autocomplete="off" />
    </div>

    <div id="patients-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach ($patients as $patient)
            <div class="bg-gray-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 flex flex-col">
                @if ($patient->image)
                    <img src="{{ asset('storage/' . $patient->image) }}"
                        class="w-full h-48 object-cover rounded-md mb-4">
                @endif
                <h3 class="text-xl font-semibold text-gray-800">
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </h3>
                <p class="text-sm text-teal-600 mt-1">{{ $patient->specialization }}</p>
                <a href="{{ route('secretary.patient.createAppointment', $patient) }}"
                    class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full text-center transition">
                    Book Appointment
                </a>
            </div>
        @endforeach
    </div>

    {{-- If you have pagination controls, wrap them in a container --}}
    <div id="patients-pagination" class="mt-6">
        {{ $patients->links() }}
    </div>

    <script>
        const patientSearchUrl = "{{ route('search.patients') }}";
        const patientListEl = document.getElementById('patients-list');
        const patientPagEl = document.getElementById('patients-pagination');
        const originalPatients = patientListEl.innerHTML;
        const originalPatientsPag = patientPagEl ? patientPagEl.innerHTML : '';

        document.getElementById('patient-search')
            .addEventListener('input', function() {
                const q = this.value.trim();

                // If query is empty, restore original list + pagination
                if (q === '') {
                    patientListEl.innerHTML = originalPatients;
                    if (patientPagEl) patientPagEl.innerHTML = originalPatientsPag;
                    return;
                }

                // Only search when at least 3 characters entered
                if (q.length > 2) {
                    fetch(`${patientSearchUrl}?query=${encodeURIComponent(q)}`)
                        .then(res => res.json())
                        .then(data => {
                            patientListEl.innerHTML = '';
                            // If no matches, show a message
                            if (data.patients.length === 0) {
                                patientListEl.innerHTML =
                                    '<p class="col-span-full text-center text-gray-500">No patients found.</p>';
                            } else {
                                data.patients.forEach(p => {
                                    patientListEl.innerHTML += `
                                        <div class="bg-gray-50 rounded-xl shadow-lg p-6 flex flex-col">
                                            ${p.image
                                                ? `<img src="/storage/${p.image}" class="w-full h-48 object-cover rounded-md mb-4">`
                                                : ``
                                            }
                                            <h3 class="text-xl font-semibold mb-1">${p.first_name} ${p.last_name}</h3>
                                            <p class="text-sm text-gray-600">${p.specialization || ''}</p>
                                            <a href="/secretary/patient/${p.id}/appointments/create"
                                               class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full text-center transition">
                                                Book Now
                                            </a>
                                        </div>`;
                                });
                            }
                            // Clear pagination when searching
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
