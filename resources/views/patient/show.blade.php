<x-layout>
    <x-navbar />

    <!-- ✅ Hero Section With Image Carousel Background -->
    <section
        x-data="{
            current: 0,
            images: [
                '{{ asset('photos/home.jpg') }}',
                '{{ asset('photos/login_background.jpg') }}',
                '{{ asset('photos/logo1.jpg') }}'
            ],
            init() {
                setInterval(() => this.current = (this.current + 1) % this.images.length, 3000)
            }
        }"
        class="relative w-full h-[90vh] min-h-[500px] overflow-hidden"
    >
        <!-- Background Image -->
        <img
            :src="images[current]"
            alt="Doctors Team"
            class="absolute inset-0 w-full h-full object-cover object-top z-0 transition duration-500 ease-in-out"
        >

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/40 to-transparent z-10"></div>

        <!-- Content -->
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
                <a href="#"
                   class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold px-6 py-3 rounded-md transition">
                    Book Now
                </a>
            </div>
        </div>

        <!-- Arrows -->
        <button
            @click="current = (current === 0) ? images.length - 1 : current - 1"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white text-teal-600 p-3 rounded-full shadow-md hover:bg-gray-100 z-30"
            aria-label="Previous slide"
        >
            <i class="fas fa-chevron-left"></i>
        </button>
        <button
            @click="current = (current === images.length - 1) ? 0 : current + 1"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white text-teal-600 p-3 rounded-full shadow-md hover:bg-gray-100 z-30"
            aria-label="Next slide"
        >
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Dot Indicators -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 z-30">
            <template x-for="(img, index) in images" :key="index">
                <div
                    @click="current = index"
                    :class="current === index ? 'bg-teal-500' : 'bg-white'"
                    class="w-3 h-3 rounded-full cursor-pointer shadow border border-gray-300"
                ></div>
            </template>
        </div>
    </section>

    <!-- ✅ About Us Section (Clean + Fit Design) -->
    <section  id="about" class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- 📝 Text Content -->
            <div class="space-y-6">
                <h2 class="text-4xl font-bold text-teal-700">About Us</h2>
                <p class="text-gray-700 text-lg leading-relaxed">
                    We are committed to delivering world-class healthcare with a compassionate approach.
                    Our team of highly skilled professionals ensures you receive the best care through
                    cutting-edge technologies and personalized attention.
                </p>
                <p class="text-gray-500 text-base">
                    Explore our clinics, meet our expert doctors, and benefit from AI-powered diagnostics and modern treatment solutions designed just for you.
                </p>
            </div>

            <!-- 🖼️ Static Image -->
            <div class="relative">
                <img
                    src="{{ asset('photos/home.jpg') }}"
                    alt="Healthcare Team"
                    class="w-full h-80 md:h-96 rounded-xl object-cover shadow-xl ring-1 ring-teal-100"
                >
            </div>
        </div>
    </section>

    <!-- 🌟 Clinics Section -->
<section id="clinics" class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-teal-700 mb-8 text-center">Our Clinics</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($clinics as $clinic)
                <div class="bg-white rounded-lg shadow hover:shadow-xl hover:-translate-y-1 transition transform p-6">

                    <!-- 🖼️ Clinic Image -->
                    @if ($clinic->image)
                        <img src="{{ asset('storage/' . $clinic->image) }}" alt="{{ $clinic->name }}"
                            class="w-full h-48 object-cover rounded-md mb-4 shadow-sm">
                    @endif

                    <!-- ✏️ Clinic Name -->
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $clinic->name }}</h3>

                    <!-- 📍 Address -->
                    <p class="text-sm text-gray-500 mb-1">
                        <i class="fas fa-map-marker-alt text-teal-500 mr-1"></i> {{ $clinic->address ?? 'No address' }}
                    </p>

                    <!-- ☎️ Phone -->
                    <p class="text-sm text-gray-500 mb-1">
                        <i class="fas fa-phone text-teal-500 mr-1"></i> {{ $clinic->phone_number }}
                    </p>

                    <!-- 📝 Description -->
                    <p class="text-gray-600 mt-3 text-sm">
                        {{ $clinic->description }}
                    </p>

                    <!-- 📌 Book Now Button -->
                    <a href="#"
                        class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-4 py-2 rounded-md transition">
                        Book Now
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>


    <!-- 🌟 Doctors Section -->
<section id="doctors" class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-teal-700 mb-8 text-center">Our Doctors</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($doctors as $doctor)
                <div class="bg-gray-50 rounded-lg shadow hover:shadow-xl hover:-translate-y-1 transition transform p-6">
                    <!-- 🖼️ Clinic Image -->
                    @if ($clinic->image)
                        <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->name }}"
                            class="w-full h-48 object-cover rounded-md mb-4 shadow-sm">
                    @endif

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ $doctor->first_name }} {{ $doctor->last_name }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-1">
                        <i class="fas fa-user-md text-teal-500 mr-2"></i> {{ $doctor->specialization }}
                    </p>
                    <p class="text-sm text-gray-600 mb-1">
                        <i class="fas fa-phone text-teal-500 mr-2"></i> {{ $doctor->phone_number }}
                    </p>
                    <p class="text-sm text-gray-600 mt-3">
                        <i class="fas fa-dollar-sign text-teal-500 mr-2"></i> Consultation Fee: ${{ $doctor->price }}
                    </p>
                    <a href="#"
                       class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-4 py-2 rounded-md transition">
                        View
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


    <x-footer />
</x-layout>
