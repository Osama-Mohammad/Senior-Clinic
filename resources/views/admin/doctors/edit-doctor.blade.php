<x-layout>
    <div class="min-h-screen bg-gradient-to-r from-cyan-100 to-blue-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full bg-white p-10 rounded-2xl shadow-2xl space-y-10 animate-fade-in">

            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-teal-700">Edit Doctor: {{ $doctor->first_name }} {{ $doctor->last_name }}</h2>
                <p class="text-gray-600 text-sm mt-2">Update the doctor's information below.</p>
            </div>

            <form action="{{ route('admin.updateDoctor', $doctor) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $doctor->first_name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $doctor->last_name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ $doctor->email }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="md:col-span-2">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ $doctor->phone_number }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        @error('phone_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" name="image" id="image"
                            class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                                   file:rounded-full file:border-0 file:text-sm file:font-semibold
                                   file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="text" name="price" id="price" value="{{ $doctor->price }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Daily Appointments -->
                    <div>
                        <label for="max_daily_appointments" class="block text-sm font-medium text-gray-700">Max Daily Appointments</label>
                        <input type="text" name="max_daily_appointments" id="max_daily_appointments" value="{{ $doctor->max_daily_appointments }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        @error('max_daily_appointments')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Available Days -->
                    <div class="md:col-span-1">
                        <label for="available_days" class="block text-sm font-medium text-gray-700">Available Days</label>
                        <select name="available_days[]" id="available_days" multiple
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}" {{ in_array($day, $available_days ?? []) ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Available Hours -->
                    <div class="md:col-span-1">
                        <label for="available_hours" class="block text-sm font-medium text-gray-700">Available Hours</label>
                        <select name="available_hours[]" id="available_hours" multiple
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                            @foreach (['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'] as $hour)
                                <option value="{{ $hour }}" {{ in_array($hour, $available_hours ?? []) ? 'selected' : '' }}>
                                    {{ $hour }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit"
                        class="w-full md:w-auto px-8 py-3 bg-teal-500 hover:bg-teal-600 text-red font-bold rounded-md shadow-lg transition transform hover:scale-105">
                        Update Doctor
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Smooth Fade In Animation -->
    <style>
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-layout>
