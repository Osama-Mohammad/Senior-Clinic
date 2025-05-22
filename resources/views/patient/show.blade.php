<x-layout>
    <x-navbar />

    <!-- ✅ Hero Section With Image Carousel Background -->
    <section id="top" x-data="{
        current: 0,
        images: [
            '{{ asset('photos/home.jpg') }}',
            '{{ asset('photos/login_background.jpg') }}',
            '{{ asset('photos/logo1.jpg') }}'
        ],
        init() {
            setInterval(() => this.current = (this.current + 1) % this.images.length, 3000)
        }
    }" class="relative w-full h-[90vh] min-h-[500px] overflow-hidden">
        <img :src="images[current]" alt="Doctors Team"
            class="absolute inset-0 w-full h-full object-cover object-top z-0 transition duration-500 ease-in-out">
        <div class="absolute inset-0 bg-gradient-to-r from-black/40 to-transparent z-10"></div>
        <div class="relative z-20 flex items-center h-full px-6 md:px-20">
            <div class="text-white max-w-xl space-y-6">
                <p class="text-lg text-teal-200 font-medium tracking-wide">
                    Trusted by thousands of patients
                </p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                    LEADING HEALTHCARE<br class="hidden sm:block"> SOLUTIONS
                </h1>
                <p class="text-base sm:text-lg text-gray-200">
                    We deliver comprehensive services with compassion.
                </p>
                <a href="#clinics"
                    class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold px-6 py-3 rounded-md transition">
                    Explore Clinics
                </a>
            </div>
        </div>
        <button @click="current = (current === 0) ? images.length - 1 : current - 1"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white text-teal-600 p-3 rounded-full shadow-md hover:bg-gray-100 z-30"
            aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
        <button @click="current = (current === images.length - 1) ? 0 : current + 1"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white text-teal-600 p-3 rounded-full shadow-md hover:bg-gray-100 z-30"
            aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 z-30">
            <template x-for="(img, index) in images" :key="index">
                <div @click="current = index" :class="current === index ? 'bg-teal-500' : 'bg-white'"
                    class="w-3 h-3 rounded-full cursor-pointer shadow border border-gray-300"></div>
            </template>
        </div>
    </section>

<!-- ✅ About Us Section -->
<section id="about" class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- Text -->
        <div class="space-y-6">
            <h2 class="text-4xl font-extrabold text-teal-700">About Us</h2>
            <p class="text-gray-700 text-lg leading-relaxed">
                At <span class="font-semibold text-teal-600">Senior Clinic</span>, we are committed to providing world-class
                medical care with a personal touch. Our experts combine compassion and innovation to deliver the highest standards of health services.
            </p>
            <p class="text-gray-500 text-base">
                From AI-driven diagnostics to personalized treatment, every aspect of our clinic is built with your wellness in mind.
                Discover modern healthcare, designed around your needs.
            </p>
        </div>

        <!-- Image -->
        <div class="relative group">
            <img src="{{ asset('photos/home.jpg') }}" alt="Healthcare Team"
                class="w-full h-96 rounded-2xl object-cover shadow-2xl ring-1 ring-teal-100 group-hover:scale-105 transition duration-500 ease-in-out">
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
        </div>
    </div>
</section>

<!-- 🏥 Clinics Section -->
<section id="clinics" class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-extrabold text-teal-700 text-center mb-12">Explore Our Clinics</h2>

        <div class="mb-8 max-w-2xl mx-auto">
            <input type="text" id="clinic-search"
                   class="w-full px-5 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-teal-500 focus:outline-none"
                   placeholder="🔍 Search clinics by name…" autocomplete="off" />
        </div>

        <div id="clinics-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach ($clinics as $clinic)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 flex flex-col">
                    @if ($clinic->image)
                        <img src="{{ asset('storage/' . $clinic->image) }}"
                            class="w-full h-48 object-cover rounded-md mb-4">
                    @endif
                    <h3 class="text-xl font-semibold text-gray-800">{{ $clinic->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1 flex-grow">{{ Str::limit($clinic->description, 100) }}</p>
                    <a href="{{ route('clinic.show', $clinic) }}"
                       class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition text-center">
                        View Doctors
                    </a>
                </div>
            @endforeach
        </div>

        <div id="clinics-pagination" class="mt-10 text-center">
            {{ $clinics->links() }}
        </div>
    </div>
</section>

<!-- 🩺 Doctors Section -->
<section id="doctors" class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-extrabold text-teal-700 text-center mb-12">Meet Our Doctors</h2>

        <div class="mb-8 max-w-2xl mx-auto">
            <input type="text" id="doctor-search"
                   class="w-full px-5 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-teal-500 focus:outline-none"
                   placeholder="🔍 Search doctors by name…" autocomplete="off" />
        </div>

        <div id="doctors-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach ($doctors as $doctor)
                <div class="bg-gray-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 flex flex-col">
                    @if ($doctor->image)
                        <img src="{{ asset('storage/' . $doctor->image) }}"
                            class="w-full h-48 object-cover rounded-md mb-4">
                    @endif
                    <h3 class="text-xl font-semibold text-gray-800">
                        Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                    </h3>
                    <p class="text-sm text-teal-600 mt-1">{{ $doctor->specialization }}</p>
                    <a href="{{ route('patient.appointment.create', $doctor) }}"
                       class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition text-center">
                        Book Appointment
                    </a>
                </div>
            @endforeach
        </div>

        <div id="doctors-pagination" class="mt-10 text-center">
            {{ $doctors->links() }}
        </div>
    </div>
</section>


    <x-footer />

    <script>
        const clinicSearchUrl = "{{ route('search.clinics') }}";
        const clinicShowBase = "{{ url('clinic/show/') }}";
        const doctorSearchUrl = "{{ route('search.doctors') }}";
        const doctorBookBase = "{{ url('patient/appointment/create') }}";

        // cache originals
        const clinicListEl = document.getElementById('clinics-list');
        const clinicPagEl = document.getElemxaentById('clinics-pagination');
        const originalClinics = clinicListEl.innerHTML;
        const originalClinicsPag = clinicPagEl.innerHTML;

        const doctorListEl = document.getElementById('doctors-list');
        const doctorPagEl = document.getElementById('doctors-pagination');
        const originalDoctors = doctorListEl.innerHTML;
        const originalDoctorsPag = doctorPagEl.innerHTML;

        // Clinics search
        document.getElementById('clinic-search')
            .addEventListener('input', function() {
                const q = this.value.trim();
                if (!q) {
                    clinicListEl.innerHTML = originalClinics;
                    clinicPagEl.innerHTML = originalClinicsPag;
                    return;
                }
                if (q.database/migrations/2025_05_21_070716_create_heart_failure_table.php
length > 2) {
                    fetch(`${clinicSearchUrl}?query=${encodeURIComponent(q)}`)
                        .then(r => r.json())
                        .then(({
                            clinics
                        }) => {
                            clinicListEl.innerHTML = '';
                            clinics.forEach(c => {
                                clinicListEl.innerHTML += `
                                    <div class="bg-white rounded-lg shadow p-6 flex flex-col">
                                        ${c.image
                                          ? `<img src="/storage/${c.image}" class="w-full h-48 object-cover rounded-md mb-4">`
                                          : ``}
                                        <h3 class="text-xl font-semibold mb-1">${c.name}</h3>
                                        <p class="text-sm text-gray-600 flex-grow">${c.description}</p>
                                        <a href="${clinicShowBase}/${c.id}"
                                           class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-4 py-2 rounded-md transition text-center">
                                            Doctors of This Clinic
                                        </a>
                                    </div>`;
                            });
                            clinicPagEl.innerHTML = '';
                        });
                }
            });

        // Doctors search
        document.getElementById('doctor-search')
            .addEventListener('input', function() {
                const q = this.value.trim();
                if (!q) {
                    doctorListEl.innerHTML = originalDoctors;
                    doctorPagEl.innerHTML = originalDoctorsPag;
                    return;
                }
                if (q.length > 2) {
                    fetch(`${doctorSearchUrl}?query=${encodeURIComponent(q)}`)
                        .then(r => r.json())
                        .then(({
                            doctors
                        }) => {
                            doctorListEl.innerHTML = '';
                            doctors.forEach(d => {
                                doctorListEl.innerHTML += `
                                    <div class="bg-gray-50 rounded-lg shadow p-6 flex flex-col">
                                        ${d.image
                                          ? `<img src="/storage/${d.image}" class="w-full h-48 object-cover rounded-md mb-4">`
                                          : ``}
                                        <h3 class="text-xl font-semibold mb-1">${d.first_name} ${d.last_name}</h3>
                                        <p class="text-sm text-gray-600">${d.specialization}</p>
                                        <a href="${doctorBookBase}/${d.id}"
                                           class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-4 py-2 rounded-md transition text-center">
                                            Book Now
                                        </a>
                                    </div>`;
                            });
                            doctorPagEl.innerHTML = '';
                        });
                }
            });

        // AJAX pagination for both sections
        document.addEventListener('click', function(e) {
            let link = e.target.closest('#clinics-pagination a');
            if (link) {
                e.preventDefault();
                fetchPageAndReplace(link.href, '#clinics-list', '#clinics-pagination');
            }
            link = e.target.closest('#doctors-pagination a');
            if (link) {
                e.preventDefault();
                fetchPageAndReplace(link.href, '#doctors-list', '#doctors-pagination');
            }
        });

        function fetchPageAndReplace(url, listSelector, pagSelector) {
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    document.querySelector(listSelector).innerHTML = doc.querySelector(listSelector).innerHTML;
                    document.querySelector(pagSelector).innerHTML = doc.querySelector(pagSelector).innerHTML;
                })
                .catch(console.error);
        }
    </script>
</x-layout>
