<x-layout>
    <x-navbar />

    <!-- 🏥 Clinic Header with Gradient and Icon -->
    <section class="relative py-20 bg-gradient-to-r from-teal-600 to-cyan-600 text-white text-center">
        <div class="max-w-3xl mx-auto px-4 z-10 relative">
            <div class="mb-4">
                <i class="fas fa-clinic-medical text-5xl text-white"></i>
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold">{{ $clinic->name }}</h1>
            <p class="mt-2 text-lg">{{ $clinic->address }}</p>
            <p class="mt-1 text-md"><i class="fas fa-phone mr-2"></i>{{ $clinic->phone_number }}</p>
        </div>
        <div class="absolute inset-0 opacity-10 bg-[url('/photos/home.jpg')] bg-cover bg-center"></div>
    </section>

    <!-- ✨ Clinic Info Card -->
    <section class="bg-gray-50 py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden md:flex">
                @if ($clinic->image)
                    <img src="{{ asset('storage/' . $clinic->image) }}"
                        alt="{{ $clinic->name }}"
                        class="w-full md:w-1/2 h-80 object-cover">
                @endif

                <div class="p-8">
                    <h2 class="text-2xl font-bold text-teal-700 mb-4">About Our Clinic</h2>
                    <p class="text-gray-700 leading-relaxed text-md">
                        {{ $clinic->description }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 🌟 Doctors Section -->
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-teal-700 mb-10 text-center">Meet Our Doctors</h2>

            @if ($clinic->doctors->isEmpty())
                <p class="text-center text-gray-500">No doctors are available at this clinic yet.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach ($clinic->doctors as $doctor)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-center space-y-3">

                            <!-- Doctor Image -->
                            @if ($doctor->image)
                                <img src="{{ asset('storage/' . $doctor->image) }}"
                                    class="w-28 h-28 object-cover rounded-full mx-auto border-4 border-teal-500 shadow-sm">
                            @else
                                <div class="w-28 h-28 bg-gray-200 rounded-full flex items-center justify-center mx-auto">
                                    <i class="fas fa-user-md text-3xl text-gray-500"></i>
                                </div>
                            @endif

                            <h3 class="text-xl font-semibold text-gray-800">
                                {{ $doctor->first_name }} {{ $doctor->last_name }}
                            </h3>

                            <div class="text-sm text-gray-600">
                                {{ $doctor->specialization }}
                            </div>

                            <div class="flex justify-center gap-3 text-sm text-gray-500">
                                <div><i class="fas fa-phone text-teal-500 mr-1"></i>{{ $doctor->phone_number }}</div>
                                <div><i class="fas fa-dollar-sign text-teal-500 mr-1"></i>${{ $doctor->price }}</div>
                            </div>

                            <a href="{{ route('patient.appointment.create', $doctor->id) }}"
                                class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-5 py-2 rounded-full transition shadow-md hover:shadow-lg">
                                Book Now
                            </a>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-footer />
</x-layout>
