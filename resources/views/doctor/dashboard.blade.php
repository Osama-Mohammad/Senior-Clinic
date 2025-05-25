@extends('layouts.doctor-layout')

@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-2xl space-y-8 animate-fade-in max-w-3xl mx-auto">

        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-teal-700">Doctor Dashboard</h2>
            <p class="text-gray-600 text-sm mt-2">
                Welcome, {{ $doctor->first_name }} {{ $doctor->last_name }}!
            </p>
        </div>

        <!-- Profile Image -->
        <div class="flex justify-center">
            @if ($doctor->image)
                <img src="{{ asset('storage/' . $doctor->image) }}" alt="Doctor Image"
                     class="w-32 h-32 object-cover rounded-full shadow-md border-2 border-teal-400">
            @else
                <div class="w-32 h-32 rounded-full flex items-center justify-center bg-gray-200 text-gray-500 shadow-md">
                    No Image
                </div>
            @endif
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="text-green-600 font-semibold text-center">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-center text-gray-500">Select an option from the sidebar to continue.</p>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out both;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection

