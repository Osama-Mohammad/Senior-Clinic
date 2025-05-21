<x-layout>
    <div
        class="min-h-screen bg-gradient-to-r from-cyan-50 to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full bg-white p-8 rounded-2xl shadow-2xl space-y-8 animate-fade-in">

            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-teal-700">Doctor Dashboard</h2>
                <p class="text-gray-600 text-sm mt-2">Welcome, {{ $doctor->first_name }} {{ $doctor->last_name }}!</p>
            </div>

            <!-- Profile Image -->
            <div class="flex justify-center">
                @if ($doctor->image)
                    <img src="{{ asset('storage/' . $doctor->image) }}" alt="Doctor Image"
                        class="w-32 h-32 object-cover rounded-full shadow-md border-2 border-teal-400">
                @else
                    <div
                        class="w-32 h-32 rounded-full flex items-center justify-center bg-gray-200 text-gray-500 shadow-md">
                        No Image
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="space-y-4 text-center">
                <a href="{{ route('doctor.edit', $doctor) }}"
                    class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                    Edit Profile
                </a>

                <a href="{{ route('doctor.secretary.create') }}"
                    class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                    Add Secretary
                </a>

                <form action="{{ route('auth.logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit"
                        class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="text-green-600 font-semibold text-center mt-4">
                    {{ session('success') }}
                </div>
            @endif

        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-layout>
