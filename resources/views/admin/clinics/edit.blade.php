<x-admin-layout>
    <div class="min-h-screen bg-gradient-to-r from-cyan-100 to-blue-100 flex flex-col items-center justify-start py-12 px-6 lg:px-8">

        <div class="max-w-4xl w-full bg-white shadow-2xl rounded-2xl p-10 space-y-8 animate-fade-in">

            <!-- Title -->
            <div class="text-center">
                <h2 class="text-4xl font-bold text-teal-700 mb-2">Update Clinic</h2>
                <p class="text-gray-500">Edit the clinic details below</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.updateClinic', $clinic) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Clinic Name -->
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $clinic->name) }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-400 focus:outline-none shadow-sm">
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Clinic Image -->
                <div>
                    <label for="image" class="block text-gray-700 font-semibold mb-2">Clinic Image</label>
                    <input type="file" name="image" id="image"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-400 focus:outline-none shadow-sm bg-gray-50">
                    @error('image')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                    @if ($clinic->image)
                        <div class="mt-3">
                            <p class="text-sm text-gray-600 mb-1">Current Image:</p>
                            <img src="{{ asset('storage/' . $clinic->image) }}" class="w-32 h-32 object-cover rounded-md shadow-md" alt="Clinic Image">
                        </div>
                    @endif
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $clinic->phone_number) }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-400 focus:outline-none shadow-sm">
                    @error('phone_number')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-400 focus:outline-none shadow-sm">{{ old('description', $clinic->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center pt-6">
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-10 rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105">
                        Update Clinic
                    </button>
                </div>

            </form>
        </div>

    </div>

    <!-- Smooth Fade In Animation -->
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
