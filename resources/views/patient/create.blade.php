<x-layout>
    <div class="flex h-screen w-screen">
        <!-- Left Form Side -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center bg-white p-10 overflow-y-auto">
            <div class="w-full max-w-md" x-data="{ showPassword: false, showConfirm: false }">
                <!-- Form -->
                <form method="POST" action="{{ route('patient.store') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">First Name</label>
                            <input name="first_name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Last Name</label>
                            <input name="last_name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Email</label>
                        <input name="email" type="email" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Password Field -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700">Password</label>
                            <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-3 text-gray-500 text-sm">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5
                                          c4.477 0 8.268 2.943 9.542 7
                                          -1.274 4.057-5.065 7-9.542 7
                                          -4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19
                                          c-4.477 0-8.268-2.943-9.542-7
                                          a9.956 9.956 0 012.091-3.368
                                          M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-3 text-gray-500 text-sm">
                                <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5
                                          s8.268 2.943 9.542 7
                                          c-1.274 4.057-5.065 7-9.542 7
                                          s-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19
                                          c-4.477 0-8.268-2.943-9.542-7
                                          a9.956 9.956 0 012.091-3.368
                                          M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">City</label>
                        <select name="address" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option selected disabled>Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Phone Number</label>
                        <input name="phone_number" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Date of Birth</label>
                            <input name="date_of_birth" type="date" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Gender</label>
                            <select name="gender" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled selected>Select</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Sign Up
                    </button>
                </form>

                <p class="mt-6 text-sm text-gray-600 text-center">
                    Already have an account?
                    <a href="{{ route('auth.login') }}"
                       @click.prevent="show = false; setTimeout(() => window.location.href='{{ route('auth.login') }}', 300)"
                       class="text-blue-600 hover:underline transition duration-300">
                        Login here
                    </a>
                </p>
            </div>
        </div>

        <!-- Right Image Side -->
        <div class="relative w-1/2 hidden md:block h-screen">
            <img src="{{ asset('photos/login_background.jpg') }}" alt="Login Background"
                 class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-l from-black/40 to-transparent"></div>
        </div>
    </div>
</x-layout>
