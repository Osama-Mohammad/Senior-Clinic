<x-layout>
    <div class="min-h-screen w-full bg-gradient-to-br from-white via-blue-50 to-blue-100 flex items-center justify-center overflow-hidden">
        <div class="w-full max-w-lg bg-white p-8 rounded-2xl shadow-2xl" x-data="{ showPassword: false, showConfirm: false }">
            <h2 class="text-3xl font-bold text-blue-800 mb-6 text-center">Register New Patient</h2>

            <form method="POST" action="{{ route('secretary.patient.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First Name</label>
                        <input name="first_name" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        @error('first_name')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input name="last_name" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        @error('last_name')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                    @error('email')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Password -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input :type="showPassword ? 'text' : 'password'" name="password"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute top-8 right-4 text-gray-500 hover:text-blue-500">
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        c4.477 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.065 7-9.542 7
                                        -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                            </svg>
                        </button>
                        @error('password')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute top-8 right-4 text-gray-500 hover:text-blue-500">
                            <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        s8.268 2.943 9.542 7
                                        c-1.274 4.057-5.065 7-9.542 7
                                        s-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                            </svg>
                        </button>
                        @error('password_confirmation')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">City</label>
                    <select name="address" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500">
                        <option selected disabled>Select City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                    @error('address')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input name="phone_number"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                    @error('phone_number')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        @error('date_of_birth')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                        @error('gender')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold shadow-lg transition duration-200">
                    ➕ Create Patient
                </button>
            </form>
        </div>
    </div>
</x-layout>
