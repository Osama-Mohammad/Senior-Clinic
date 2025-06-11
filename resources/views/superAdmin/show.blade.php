<x-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r shadow-sm hidden md:block">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-blue-800">Super Admin</h2>
            </div>
            <nav class="mt-6 space-y-2 px-6">
                <a href="{{ route('superadmin.admin.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-100 rounded-lg">
                    🛠 Manage Admins
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Logo + Header -->
            <div class="bg-white shadow mb-6 rounded-xl p-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    {{-- <img src="{{ asset('images/logo.png') }}" alt="MediBook AI Logo" class="h-12 w-12 rounded-full shadow"> --}}
                    <h1 class="text-3xl font-bold text-blue-800 tracking-tight">MediBook Super Admin Dashboard</h1>
                </div>
                <span class="text-sm text-gray-500">Managing Healthcare, Powered by AI</span>
            </div>

            <!-- Dashboard Stats -->
            <div class="max-w-6xl mx-auto space-y-10 animate-fade-in">
                <div class="text-center space-y-4">
                    <h2 class="text-5xl font-extrabold text-teal-700 drop-shadow-md tracking-tight leading-snug">
                        Welcome, {{ $superAdmin->full_name }}
                    </h2>
                    <p class="text-gray-600 text-lg">
                        Welcome back, Super Admin. Your command center for smart medical operations.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
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
                        <div class="flex flex-col items-center bg-gradient-to-br from-white to-{{ $card['color'] }}-50 hover:from-{{ $card['color'] }}-100 hover:to-{{ $card['color'] }}-200 text-{{ $card['color'] }}-700 font-semibold p-6 rounded-2xl shadow-xl hover:shadow-2xl hover:scale-105 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($card['icon'] === 'heart')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.172 11.828a4 4 0 015.656 0L12 15l3.172-3.172a4 4 0 115.656 5.656L12 21l-8.828-8.828a4 4 0 010-5.656z"/>
                                @elseif($card['icon'] === 'stethoscope')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 14v3m-4 0h4m-2-8a2 2 0 110-4 2 2 0 010 4zm0 0v4m0 0a6 6 0 00-6 6v1a1 1 0 002 0v-1a4 4 0 018 0v1a1 1 0 002 0v-1a6 6 0 00-6-6z"/>
                                @elseif($card['icon'] === 'user-group')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V8a2 2 0 00-2-2h-4M6 20h5V8a2 2 0 00-2-2H5m8 14a4 4 0 100-8 4 4 0 000 8z"/>
                                @elseif($card['icon'] === 'calendar')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                @elseif($card['icon'] === 'calendar-plus')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v6m3-3H9"/>
                                @elseif($card['icon'] === 'calendar-x')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-6 6m6-6l-6-6"/>
                                @elseif($card['icon'] === 'check-circle')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                @endif
                            </svg>
                            <span class="text-3xl">{{ $card['value'] }}</span>
                            <span class="mt-1">{{ $card['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</x-layout>
