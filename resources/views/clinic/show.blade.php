<x-layout>
    <x-navbar />

    <!-- 🏥 Clinic Header -->
    <section class="bg-teal-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="text-4xl sm:text-5xl font-bold">{{ $clinic->name }}</h1>
            <p class="mt-4 text-lg">{{ $clinic->address }}</p>
            <p class="mt-2 text-md"><i class="fas fa-phone mr-2"></i>{{ $clinic->phone_number }}</p>
        </div>
    </section>

    <!-- ✨ Clinic Info Card -->
    <section class="bg-gray-50 py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

                <!-- Clinic Image -->
                @if ($clinic->image)
                    <img src="{{ asset('storage/' . $clinic->image) }}" alt="{{ $clinic->name }}"
                        class="h-80 w-full object-cover">
                @endif

                <!-- Clinic Description -->
                <div class="p-8 flex flex-col justify-center">
                    <h2 class="text-2xl font-bold text-teal-700 mb-4">About Our Clinic</h2>
                    <p class="text-gray-700 leading-relaxed">
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
                        <div
                            class="bg-gray-100 rounded-lg shadow-md hover:shadow-lg transition p-6 flex flex-col items-center text-center">

                            <!-- Doctor Image -->
                            @if ($doctor->image)
                                <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->first_name }}"
                                    class="w-32 h-32 object-cover rounded-full mb-4">
                            @else
                                <div class="w-32 h-32 bg-gray-300 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-user-md text-gray-600 text-3xl"></i>
                                </div>
                            @endif

                            <h3 class="text-xl font-semibold text-gray-800">{{ $doctor->first_name }}
                                {{ $doctor->last_name }}</h3>

                            <p class="text-sm text-gray-600 mt-1">{{ $doctor->specialization }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-phone text-teal-500 mr-1"></i> {{ $doctor->phone_number }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-dollar-sign text-teal-500 mr-1"></i> ${{ $doctor->price }}
                            </p>

                            <a href="{{ route('patient.appointment.create', $doctor->id) }}"
                                class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-4 py-2 rounded-full transition">
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
