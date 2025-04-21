<x-layout>

    <div class="flex flex-col md:flex-row h-screen">

        <!-- Left Side: Image with gradient overlay -->
        <div class="relative w-full md:w-1/2 h-64 md:h-full">
            <img src="{{ asset('photos/login_background.jpg') }}" alt="Login Background"
                 class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-black/40 to-transparent"></div>
        </div>

        <!-- Right Side: Login Form Full Height -->
        <div class="w-full md:w-1/2 h-full flex items-center justify-center p-6 sm:p-12 bg-gray-50">
            <div class="w-full max-w-md sm:max-w-sm space-y-6">
                <!-- Optional Logo -->
                <!--<div class="flex justify-center">
                    <img src="{{ asset('photos/logo1.jpg') }}" alt="Logo"
                         class="w-16 h-16 rounded-full shadow-md" />
                </div>-->

                <!-- Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 text-center">Login to Medical Center</h2>

                <!-- Form -->
                <form action="{{ route('auth.login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                 d="M16 12H8m8 0H8m8 0H8m2-6h4a2 2 0 012 2v12a2 2 0 01-2 2h-4a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                        </span>
                        <input type="text" name="email" id="email" placeholder="Email"
                               class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
<div class="relative">
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
        <!-- Lock Icon -->
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
             d="M12 11c1.104 0 2-.896 2-2V7a2 2 0 00-4 0v2c0 1.104.896 2 2 2z"/><path stroke-linecap="round" stroke-linejoin="round"
             d="M17 11V7a5 5 0 00-10 0v4m2 4h6a2 2 0 012 2v2a2 2 0 01-2 2H9a2 2 0 01-2-2v-2a2 2 0 012-2z"/></svg>
    </span>

        <!-- Password Input -->
        <input type="password" name="password" id="password"
            class="pl-10 pr-10 w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Password">

        <!-- Eye Icon -->
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword()">
            <svg id="eyeIcon" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </span>

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
                        <a href="{{ route('patient.create') }}"
                        @click.prevent="show = false; setTimeout(() => window.location.href='{{ route('patient.create') }}', 300)"
                        class="text-blue-600 hover:underline transition duration-300">
                        Register
                     </a>
                     

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
    
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
                          a9.956 9.956 0 012.091-3.368m2.548-2.404A9.956 9.956 0 0112 5
                          c4.477 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.154 5.136
                          M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7
                          c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z"/>`;
            }
        }
    </script>
    
</x-layout>
