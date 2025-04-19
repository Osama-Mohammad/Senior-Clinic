<x-layout>
    <!-- Background Image (full page) -->
    <div class="min-h-screen w-full bg-cover bg-center bg-no-repeat fixed" style="background-image: url('{{ asset('photos/login_background.jpg') }}');">
        <!-- Semi-transparent dark overlay for readability -->
        <div class="min-h-screen w-full bg-black/30 flex items-center justify-end px-6 sm:px-12">

            <!-- Login Form -->
            <div class="w-full max-w-md sm:max-w-sm bg-white/80 backdrop-blur-sm border border-white/20 rounded-xl p-8 shadow-lg">
                <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Login to Medical Center</h2>

                <form action="{{ route('auth.login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-800">Email</label>
                        <input type="text" name="email" id="email"
                               class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-800">Password</label>
                        <input type="password" name="password" id="password"
                               class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                            Login
                        </button>
                    </div>

                    <!-- Session Messages -->
                    @if (session('error'))
                        <p class="text-red-600 text-sm">{{ session('error') }}</p>
                    @endif
                    @if (session('success'))
                        <p class="text-green-600 text-sm">{{ session('success') }}</p>
                    @endif

                    <!-- Register Link -->
                    <div class="text-sm text-gray-800 text-center">
                        Don’t have an account?
                        <a href="{{ route('patient.create') }}" class="text-blue-600 hover:underline">Register</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layout>
