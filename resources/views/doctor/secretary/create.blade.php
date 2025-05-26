@extends('layouts.doctor-layout')

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Add New Secretary</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctor.secretary.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1" for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" class="w-full border border-gray-300 rounded p-2"
                    value="{{ old('first_name') }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1" for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="w-full border border-gray-300 rounded p-2"
                    value="{{ old('last_name') }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1" for="email">Email</label>
                <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded p-2"
                    value="{{ old('email') }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1" for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded p-2"
                    required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1" for="password">Password Confirmation</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1" for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number"
                    class="w-full border border-gray-300 rounded p-2" value="{{ old('phone_number') }}" required>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Create
                    Secretary</button>
            </div>
        </form>
    </div>
@endsection
