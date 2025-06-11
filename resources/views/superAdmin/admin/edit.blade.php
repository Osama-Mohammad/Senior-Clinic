<x-layout>
    <div class="max-w-xl mx-auto p-6 bg-white shadow-xl rounded-xl mt-10">
        <!-- Title -->
        <h2 class="text-2xl font-bold text-blue-800 mb-6 text-center">Edit Admin</h2>

        <!-- Edit Form -->
        <form method="POST" action="{{ route('superadmin.admin.update', $admin->id) }}">
            @csrf
            @method('PUT')

            <!-- First Name -->
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 font-semibold mb-1">First Name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $admin->first_name) }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 font-semibold mb-1">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $admin->last_name) }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (optional) -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold mb-1">New Password (leave blank to keep
                    current)</label>
                <input type="password" name="password" id="password"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <label for="password_confirmation">Password Confirmation</label>
                <input type="password_confirmation" name="password_confirmation" id="password_confirmation"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Update Admin
                </button>
            </div>
        </form>
    </div>
</x-layout>
