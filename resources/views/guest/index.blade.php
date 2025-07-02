<x-layout>

    <x-guest-navbar />

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
            aria-label="Previous slide">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button @click="current = (current === images.length - 1) ? 0 : current + 1"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white text-teal-600 p-3 rounded-full shadow-md hover:bg-gray-100 z-30"
            aria-label="Next slide">
            <i class="fas fa-chevron-right"></i>
        </button>

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
            <div class="space-y-6">
                <h2 class="text-4xl font-extrabold text-teal-700">About Us</h2>
                <p class="text-gray-700 text-lg leading-relaxed">
                    Welcome to <span class="font-semibold text-teal-600">MEDIBOOK AI</span>, where cutting-edge
                    technology meets compassionate care.
                    Our mission is to revolutionize healthcare in Lebanon — combining expertise, empathy, and innovation
                    to serve you better.
                </p>
                <p class="text-gray-600 text-base">
                    From AI-powered diagnostics to seamless appointment scheduling, we ensure every patient experience
                    is efficient, personalized, and stress-free.
                    With a network of skilled doctors and modern clinics, we're redefining what it means to feel truly
                    cared for.
                </p>
            </div>
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
                    <div
                        class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 flex flex-col">
                        @if ($clinic->image)
                            <img src="{{ asset('storage/' . $clinic->image) }}"
                                class="w-full h-48 sm:h-56 md:h-64 object-cover object-center rounded-md mb-4"
>
                        @endif
                        <h3 class="text-xl font-semibold text-gray-800">{{ $clinic->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1 flex-grow">{{ Str::limit($clinic->description, 100) }}</p>

                        {{-- Authenticated users see the real “View Doctors” link --}}
                        @auth('patient')
                            <a href="{{ route('clinic.show', $clinic) }}"
                                class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition text-center">
                                View Doctors
                            </a>
                        @endauth

                        {{-- Guests see a button that prompts them to sign up --}}
                        @guest('patient')
                            <button
                                onclick="if (confirm('You need to sign up or log in to view this clinic. Proceed to Sign Up?')) { window.location='{{ route('patient.create') }}'; }"
                                class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition">
                                View Doctors
                            </button>
                        @endguest
                    </div>
                @endforeach
            </div>
            <div id="clinics-pagination" class="mt-10 text-center">
                {{ $clinics->appends(request()->except('clinics_page'))->links() }}
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
                    <div
                        class="bg-gray-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 flex flex-col">
                        @if ($doctor->image)
                            <img src="{{ asset('storage/' . $doctor->image) }}"
                                class="w-full h-48 sm:h-56 md:h-64 object-cover object-center rounded-md mb-4">
                        @endif

                        <h3 class="text-xl font-semibold text-gray-800">
                            Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                        </h3>
                        <p class="text-sm text-teal-600 mt-1">{{ $doctor->description }}</p>
                        <p class="text-sm text-teal-600 mt-1">Clinic : {{ $doctor->clinic->name }}</p>


                        {{-- Authenticated users see the real “Book Appointment” link --}}
                        @auth('patient')
                            <a href="{{ route('patient.appointment.create', $doctor) }}"
                                class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition text-center">
                                Book Appointment
                            </a>
                        @endauth

                        {{-- Guests see a button that prompts them to sign up --}}
                        @guest('patient')
                            <button
                                onclick="if (confirm('You need to sign up or log in to book an appointment. Proceed to Sign Up?')) { window.location='{{ route('patient.create') }}'; }"
                                class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition">
                                Book Appointment
                            </button>
                        @endguest
                    </div>
                @endforeach
            </div>
            <div id="doctors-pagination" class="mt-10 text-center">
                {{ $doctors->appends(request()->except('doctors_page'))->links() }}
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Utility to wire up an AJAX live‐search
            function liveSearch(inputId, listId, urlBase, renderItem) {
                const input = document.getElementById(inputId);
                const list = document.getElementById(listId);
                let timer;

                input.addEventListener('keyup', () => {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        const q = encodeURIComponent(input.value.trim());
                        fetch(`${urlBase}?query=${q}`)
                            .then(res => res.json())
                            .then(json => {
                                list.innerHTML = '';
                                (json[Object.keys(json)[0]] || []).forEach(item => {
                                    // renderItem should return an Element or HTML string
                                    const el = renderItem(item);
                                    if (typeof el === 'string') {
                                        const wrapper = document.createElement('div');
                                        wrapper.innerHTML = el;
                                        list.appendChild(wrapper.firstElementChild);
                                    } else {
                                        list.appendChild(el);
                                    }
                                });
                            })
                            .catch(console.error);
                    }, 300); // 300 ms debounce
                });
            }

            // Clinics live‐search
            liveSearch(
                'clinic-search',
                'clinics-list',
                '{{ route('search.clinics') }}',
                clinic => `
      <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 flex flex-col">
        ${clinic.image ? `<img src="/storage/${clinic.image}" class="w-full h-48 object-cover rounded-md mb-4">` : ''}
        <h3 class="text-xl font-semibold text-gray-800">${clinic.name}</h3>
        <p class="text-sm text-gray-600 mt-1">${clinic.description.slice(0, 100)}</p>
        <a href="/clinics/${clinic.id}"
           class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition">
          View Doctors
        </a>
      </div>
    `
            );

            // Doctors live‐search
            liveSearch(
                'doctor-search',
                'doctors-list',
                '{{ route('search.doctors') }}',
                doc => `
      <div class="bg-gray-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 flex flex-col">
        ${doc.image
          ? `<img src="/storage/${doc.image}" class="w-full h-48 object-cover rounded-md mb-4">`
          : ''}
        <h3 class="text-xl font-semibold text-gray-800">Dr. ${doc.first_name} ${doc.last_name}</h3>
        ${doc.description
          ? `<p class="text-sm text-teal-600 mt-1">
                          ${doc.description.length > 100 ? doc.description.slice(0, 100) + '…' : doc.description}
                         </p>`
          : ''}
          ${doc.clinic && doc.clinic.name
        ? `<p class="text-sm text-teal-600 mt-1">Clinic : ${doc.clinic.name}</p>`
        : ''}
        <a href="/patient/appointment/create/${doc.id}"
           class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition text-center">
          Book Appointment
        </a>
      </div>
    `
            );
        });
    </script>
    <x-footer />
</x-layout>
