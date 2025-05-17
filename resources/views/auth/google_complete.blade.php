{{-- resources/views/auth/google_complete.blade.php --}}
<x-layout>
    <div class="max-w-md mx-auto my-12">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            {{-- Header with avatar & name/email --}}
            <div class="flex items-center p-6 border-b">
                <img src="{{ $g['avatar_url'] }}" alt="Avatar" class="w-16 h-16 rounded-full border mr-4">

                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Almost done!</h2>
                    <p class="text-gray-600">
                        {{ $g['first_name'] }} {{ $g['last_name'] }}<br>
                        <span class="text-sm">{{ $g['email'] }}</span>
                    </p>
                </div>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('auth.google.complete.submit') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-4">
                    {{-- Phone --}}
                    <div>
                        <label class="block text-gray-700 mb-1">Phone Number</label>
                        <input name="phone_number" value="{{ old('phone_number') }}" placeholder="e.g. +1 555 123 4567"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />
                        @error('phone_number')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div>
                        <label class="block text-gray-700 mb-1">City</label>
                        <select name="address"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <option value="">Select your city</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}" {{ old('address') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                        @error('address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date of Birth --}}
                    <div>
                        <label class="block text-gray-700 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />
                        @error('date_of_birth')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label class="block text-gray-700 mb-1">Gender</label>
                        <select name="gender"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <option value="">Choose…</option>
                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" placeholder="At least 8 characters"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" />
                    </div>
                </div>

                {{-- Submit button --}}
                <button type="submit"
                    class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                    Create My Account
                </button>
            </form>
        </div>
    </div>
</x-layout>
