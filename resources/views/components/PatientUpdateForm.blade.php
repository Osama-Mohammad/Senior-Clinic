<x-layout>
    <div class="min-h-screen bg-gray-100 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden p-8">

            <!-- Header -->
            <div class="flex flex-col items-center text-center mb-8">
                <div class="relative w-32 h-32">
                    @if ($patient->image)
                        <img src="{{ asset('storage/' . $patient->image) }}"
                             class="w-32 h-32 object-cover rounded-full border-4 border-teal-500" alt="Profile Image">
                    @else
                        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                             class="w-32 h-32 object-cover rounded-full border-4 border-teal-500" alt="Default Avatar">
                    @endif
                </div>
                <h2 class="text-2xl font-bold mt-4 text-gray-700">
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </h2>
                <p class="text-sm text-gray-500">Patient Profile</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Edit Form -->
            <form action="{{ route('patient.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" value="{{ $patient->first_name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('first_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" value="{{ $patient->last_name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('last_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ $patient->email }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone_number" value="{{ $patient->phone_number }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('phone_number') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ $patient->date_of_birth }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('date_of_birth') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="M" {{ $patient->gender == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ $patient->gender == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">City / Address</label>
                        <select name="address"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @foreach ($cities as $city)
                                <option value="{{ $city }}" {{ $patient->address == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                        @error('address') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Change Profile Image</label>

                        <input type="file" name="image" id="image"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                   file:border-0 file:bg-teal-600 file:text-white file:rounded-md hover:file:bg-teal-700" />

                        @error('image')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-center pt-4">
                    <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-6 rounded-full transition">
                        Update Info
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
