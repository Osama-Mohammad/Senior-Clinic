<x-layout>
    <x-navbar />

    <!-- ✅ Hero Section With Perfectly Fit Image -->
    <section class="relative w-full h-[90vh] min-h-[500px]">
        <!-- Background Image with object-contain -->
            <img 
        src="{{ asset('photos/home.jpg') }}" 
        alt="Doctors Team" 
        class="absolute inset-0 w-full h-full object-cover object-top z-0"
            />

        <!-- Optional Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/40 to-transparent z-10"></div>

        <!-- Text Content -->
        <div class="relative z-20 flex items-center h-full px-6 md:px-20">
            <div class="text-white max-w-xl space-y-6">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold leading-tight">
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
    </section>
    <!-- About Us Section with Image Carousel -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

        <!-- Text Section -->
        <div class="space-y-6">
            <h2 class="text-3xl font-bold text-gray-800">About Us</h2>
            <p class="text-gray-600 text-lg">
                We are committed to delivering world-class healthcare with a compassionate approach.
                Our team of highly skilled professionals ensures you receive the best care through
                modern technologies and personalized attention.
            </p>
            <p class="text-gray-500">
                Explore our clinics, meet our expert doctors, and benefit from AI-powered diagnostics.
            </p>
        </div>

        <!-- Image Carousel -->
        <div 
            x-data="{
                current: 0,
                images: [
                    '{{ asset('photos/home.jpg') }}',
                    '{{ asset('photos/login_background.jpg') }}',
                    '{{ asset('photos/logo1.jpg') }}'
                ]
            }" 
            class="relative w-full"
        >
            <div class="relative overflow-hidden rounded-xl shadow-lg">
                <img 
                    :src="images[current]" 
                    alt="About Image" 
                    class="w-full h-72 sm:h-80 md:h-96 object-cover transition duration-500 ease-in-out"
                >

                <!-- Left Arrow -->
                <button 
                    @click="current = (current === 0) ? images.length - 1 : current - 1"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white text-teal-600 p-2 rounded-full shadow hover:bg-gray-100"
                >
                    <i class="fas fa-chevron-left"></i>
                </button>

                <!-- Right Arrow -->
                <button 
                    @click="current = (current === images.length - 1) ? 0 : current + 1"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white text-teal-600 p-2 rounded-full shadow hover:bg-gray-100"
                >
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Dot Indicators -->
            <div class="flex justify-center mt-4 space-x-2">
                <template x-for="(img, index) in images" :key="index">
                    <div 
                        @click="current = index"
                        :class="current === index ? 'bg-teal-600' : 'bg-gray-300'"
                        class="w-3 h-3 rounded-full cursor-pointer transition"
                    ></div>
                </template>
            </div>
        </div>
    </div>
</section>








































<x-footer />
</x-layout>
