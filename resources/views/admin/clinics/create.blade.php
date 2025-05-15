<x-admin-layout>
    <div class="min-h-screen bg-gradient-to-r from-teal-100 to-cyan-100 py-12 px-6 lg:px-8">
        <div class="max-w-6xl mx-auto bg-white shadow-2xl rounded-2xl p-10 space-y-8 animate-fade-in">

            <!-- Title -->
            <div class="text-center">
                <h2 class="text-4xl font-extrabold text-teal-700 mb-2">Create New Clinic</h2>
                <p class="text-gray-600">Fill out the details below to add a new clinic to the platform.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.storeClinic') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Clinic Name</label>
                    <input type="text" name="name" id="name"
                           class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-teal-400 focus:outline-none">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Clinic Image</label>
                    <input type="file" name="image" id="image"
                           class="w-full border border-gray-300 rounded-md p-2 bg-gray-50">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number"
                           class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-teal-400 focus:outline-none">
                    @error('phone_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-teal-400 focus:outline-none"></textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-4">
                    <button type="submit"
                            class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold px-8 py-3 rounded-xl shadow-lg hover:scale-105 transition transform duration-300">
                        Create Clinic
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Smooth fade-in animation (optional) -->
    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-admin-layout>
