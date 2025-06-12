@extends('layouts.superadmin')

@section('content')
    <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <div class="bg-white shadow-lg mb-10 rounded-3xl p-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/logo.png') }}" alt="MediBook AI Logo"
                         class="h-12 w-12 rounded-full shadow-md">
                    <h1 class="text-3xl font-extrabold text-blue-800 tracking-tight">MediBook Super Admin Dashboard</h1>
                </div>
                <span class="text-sm text-gray-500 italic">Managing Healthcare, Powered by AI</span>
            </div>

            <!-- Welcome -->
            <div class="text-center mb-12 animate-fade-in">
                <h2 class="text-5xl font-extrabold text-teal-700 drop-shadow tracking-tight leading-tight">
                    Welcome, {{ $superAdmin->full_name }}
                </h2>
                <p class="text-gray-600 text-lg mt-3">Your command center for smart medical operations.</p>
            </div>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 animate-fade-in">
                @php
                    $cards = [
                        ['label' => 'Total Patients', 'value' => $stats['patients'], 'color' => 'blue', 'icon' => 'heart'],
                        ['label' => 'Total Doctors', 'value' => $stats['doctors'], 'color' => 'purple', 'icon' => 'stethoscope'],
                        ['label' => 'Total Secretaries', 'value' => $stats['secretaries'], 'color' => 'green', 'icon' => 'user-group'],
                        ['label' => 'Total Appointments', 'value' => $stats['appointments'], 'color' => 'yellow', 'icon' => 'calendar'],
                        ['label' => 'Booked Appointments', 'value' => $stats['booked'], 'color' => 'indigo', 'icon' => 'calendar-plus'],
                        ['label' => 'Canceled Appointments', 'value' => $stats['canceled'], 'color' => 'red', 'icon' => 'calendar-x'],
                        ['label' => 'Completed Appointments', 'value' => $stats['completed'], 'color' => 'teal', 'icon' => 'check-circle'],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="flex flex-col items-center bg-white/70 backdrop-blur-md border border-gray-200 shadow-xl hover:shadow-2xl hover:scale-[1.03] transition-all duration-300 rounded-2xl p-6 text-{{ $card['color'] }}-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            @if($card['icon'] === 'heart')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3.172 11.828a4 4 0 015.656 0L12 15l3.172-3.172a4 4 0 115.656 5.656L12 21l-8.828-8.828a4 4 0 010-5.656z"/>
                            @elseif($card['icon'] === 'stethoscope')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 14v3m-4 0h4m-2-8a2 2 0 110-4 2 2 0 010 4zm0 0v4m0 0a6 6 0 00-6 6v1a1 1 0 002 0v-1a4 4 0 018 0v1a1 1 0 002 0v-1a6 6 0 00-6-6z"/>
                            @elseif($card['icon'] === 'user-group')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5V8a2 2 0 00-2-2h-4M6 20h5V8a2 2 0 00-2-2H5m8 14a4 4 0 100-8 4 4 0 000 8z"/>
                            @elseif($card['icon'] === 'calendar')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            @elseif($card['icon'] === 'calendar-plus')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 11v6m3-3H9"/>
                            @elseif($card['icon'] === 'calendar-x')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12l-6 6m6-6l-6-6"/>
                            @elseif($card['icon'] === 'check-circle')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4"/>
                            @endif
                        </svg>
                        <div class="text-4xl font-bold">{{ $card['value'] }}</div>
                        <div class="text-md mt-2">{{ $card['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.7s ease-out both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
