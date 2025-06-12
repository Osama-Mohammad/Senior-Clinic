@extends('layouts.superadmin')

@section('content')
    <div class="max-w-xl mx-auto p-6 bg-white shadow-2xl rounded-2xl mt-10 animate-fade-in">
        <!-- Title -->
        <h2 class="text-3xl font-extrabold text-teal-700 mb-8 text-center tracking-tight">
            Edit Admin
        </h2>

        <!-- Edit Form -->
        <form method="POST" action="{{ route('superadmin.admin.update', $admin->id) }}">
            @csrf
            @method('PUT')

            <!-- First Name -->
            <div class="mb-5">
                <label for="first_name" class="block text-gray-700 font-semibold mb-2">First Name</label>
                <input type="text" name="first_name" id="first_name"
                    value="{{ old('first_name', $admin->first_name) }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                    required>
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-5">
                <label for="last_name" class="block text-gray-700 font-semibold mb-2">Last Name</label>
                <input type="text" name="last_name" id="last_name"
                    value="{{ old('last_name', $admin->last_name) }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                    required>
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" id="email"
                    value="{{ old('email', $admin->email) }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                    required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold mb-2">
                    New Password <span class="text-gray-500 text-sm">(leave blank to keep current)</span>
                </label>
                <input type="password" name="password" id="password"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">

                <label for="password_confirmation" class="block mt-4 text-gray-700 font-semibold mb-2">
                    Confirm New Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition-transform hover:scale-105">
                    ✅ Update Admin
                </button>
            </div>
        </form>
    </div>

    <!-- Optional Animation -->
    <style>
        .animate-fade-in {
            animation: fadeIn 0.7s ease-out both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
