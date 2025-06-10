@extends('layouts.doctor-layout')

@section('content')
    <div class="max-w-xl mx-auto py-12">
        <h2 class="text-2xl font-bold text-teal-700 mb-6">Edit Secretary</h2>

        <form action="{{ route('doctor.secretary.update', $secretary) }}" method="POST"
            class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $secretary->first_name) }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-teal-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $secretary->last_name) }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-teal-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $secretary->email) }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-teal-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Phone Number</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $secretary->phone_number) }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-teal-500">
            </div>
            <!-- Change Password Section -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-teal-700 mb-2">🔐 Change Password</h3>
                <p class="text-sm text-gray-500 mb-4">Leave this blank if you don’t want to change the password.</p>

                <!-- New Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-teal-500">
                    @error('password')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('doctor.secretary.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">Cancel</a>
                <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-md font-semibold">Update</button>
            </div>
        </form>
    </div>
@endsection
