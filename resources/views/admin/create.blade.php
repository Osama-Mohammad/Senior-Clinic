<x-layout>
    <div class="min-h-screen bg-gradient-to-r from-cyan-100 to-blue-100 flex items-center justify-center py-12 px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8 p-8 bg-white rounded-2xl shadow-2xl animate-fade-in">

            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-teal-700">Create New Admin</h2>
                <p class="mt-2 text-gray-500 text-sm">Fill the details carefully to add a new admin.</p>
            </div>

            <form class="space-y-6" action="{{ route('admin.store') }}" method="POST">
                @csrf

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('first_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('last_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition">
                        Create Admin
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-layout>
