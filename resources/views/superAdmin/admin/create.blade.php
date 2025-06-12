<x-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-6">Create New Admin</h2>

        <form action="{{ route('superadmin.admin.store') }}" method="POST">
            @csrf

            {{-- First Name --}}
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 font-medium mb-2">First Name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400"
                    maxlength="100" required>
                @error('first_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Last Name --}}
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 font-medium mb-2">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400"
                    maxlength="100" required>
                @error('last_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400"
                    maxlength="150" required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400"
                    minlength="8" required>

                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400"
                    minlength="8" required>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-teal-600 text-white font-semibold py-2 rounded-lg hover:bg-teal-700 transition-colors">
                Create Admin
            </button>
        </form>
    </div>
</x-layout>
