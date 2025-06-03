<x-admin-layout>
    <div class="max-w-6xl mx-auto space-y-10 animate-fade-in">
        <div class="text-center space-y-4">
            <h2 class="text-5xl font-extrabold text-teal-700 drop-shadow-lg">
                Welcome, {{ $admin->first_name }} {{ $admin->last_name }}
            </h2>
            <p class="text-gray-600 text-lg">
                You are logged in as Admin. Manage your healthcare platform with ease.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            {{-- Total Patients --}}
            <div
                class="flex flex-col items-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <!-- Big icon: user-group -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5V4a2 2 0 00-2-2H4a2 2 0 00-2 2v16h5m4-16v4m0 0v4m0-4h4m-4 0H7"/>
                </svg>

                <!-- Number with a little heart icon -->
                <span class="text-3xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3.172 11.828a4 4 0 015.656 0L12 15l3.172-3.172a4 4 0 115.656 5.656L12 21l-8.828-8.828a4 4 0 010-5.656z"/>
                    </svg>
                    {{ $stats['patients'] }}
                </span>

                <!-- Label with a small building-hospital icon -->
                <span class="mt-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M4 2a1 1 0 00-1 1v14l4-2 4 2 4-2 4 2V3a1 1 0 00-1-1H4zm7 9H5V8h6v3zm0 4H5v-3h6v3zm2-4h6v3h-6V9zm0 4h6v-3h-6v3z"
                              clip-rule="evenodd"/>
                    </svg>
                    Total Patients
                </span>
            </div>

            {{-- Total Doctors --}}
            <div
                class="flex flex-col items-center bg-purple-100 hover:bg-purple-200 text-purple-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <!-- Big icon: user -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z"/>
                </svg>

                <!-- Number with a stethoscope icon -->
                <span class="text-3xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 14v3m-4 0h4m-2-8a2 2 0 110-4 2 2 0 010 4zm0 0v4m0 0a6 6 0 00-6 6v1a1 1 0 002 0v-1a4 4 0 018 0v1a1 1 0 002 0v-1a6 6 0 00-6-6z"/>
                    </svg>
                    {{ $stats['doctors'] }}
                </span>

                <!-- Label with a small badge-check icon -->
                <span class="mt-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m4 4v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6m16-4H3m7 0V4m0 4h.01"/>
                    </svg>
                    Total Doctors
                </span>
            </div>

            {{-- Total Secretaries --}}
            <div
                class="flex flex-col items-center bg-green-100 hover:bg-green-200 text-green-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <!-- Big icon: users -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5V8a2 2 0 00-2-2h-4M6 20h5V8a2 2 0 00-2-2H5m8 14a4 4 0 100-8 4 4 0 000 8zm0-14a4 4 0 014 4v1a4 4 0 11-8 0V6a4 4 0 014-4z"/>
                </svg>

                <!-- Number with a user-tie icon -->
                <span class="text-3xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 01.883 7.857M12 12v8m0 0l-3-3m3 3l3-3m-3-9a4 4 0 10-3.528 6.885"/>
                    </svg>
                    {{ $stats['secretaries'] }}
                </span>

                <!-- Label with a user-group icon -->
                <span class="mt-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5V8a2 2 0 00-2-2h-4M6 20h5V8a2 2 0 00-2-2H5m8 14a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                    Total Secretaries
                </span>
            </div>

            {{-- Total Appointments --}}
            <div
                class="flex flex-col items-center bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <!-- Big icon: calendar -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>

                <!-- Number with a clock icon -->
                <span class="text-3xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3M12 2a10 10 0 1010 10A10 10 0 0012 2z"/>
                    </svg>
                    {{ $stats['appointments'] }}
                </span>

                <!-- Label with a calendar-alt icon -->
                <span class="mt-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-1" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path d="M6 2a1 1 0 012 0v1h4V2a1 1 0 012 0v1h1a2 2 0 012 2v2H3V5a2 2 0 012-2h1V2z"/>
                        <path fill-rule="evenodd"
                              d="M3 9h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V9zm2 2v3h3v-3H5z"
                              clip-rule="evenodd"/>
                    </svg>
                    Total Appointments
                </span>
            </div>

            {{-- Booked Appointments --}}
            <div
                class="flex flex-col items-center bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <!-- Big icon: calendar with plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 11v6m3-3H9"/>
                </svg>

                <!-- Number with a plus icon -->
                <span class="text-3xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ $stats['booked'] }}
                </span>

                <!-- Label with a small calendar-plus icon -->
                <span class="mt-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 11v6m3-3H9"/>
                    </svg>
                    Booked Appointments
                </span>
            </div>

            {{-- Canceled Appointments --}}
            <div
                class="flex flex-col items-center bg-red-100 hover:bg-red-200 text-red-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <!-- Big icon: calendar with x -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12l-6 6m6-6l-6-6"/>
                </svg>

                <!-- Number with an x-circle icon -->
                <span class="text-3xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $stats['canceled'] }}
                </span>

                <!-- Label with a small x-circle icon -->
                <span class="mt-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12l-6 6m6-6l-6-6"/>
                    </svg>
                    Canceled Appointments
                </span>
            </div>

            {{-- Completed Appointments --}}
            <div
                class="flex flex-col items-center bg-teal-100 hover:bg-teal-200 text-teal-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <!-- Big icon: calendar with check -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4"/>
                </svg>

                <!-- Number with a check-circle icon -->
                <span class="text-3xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4"/>
                    </svg>
                    {{ $stats['completed'] }}
                </span>

                <!-- Label with a small check-circle icon -->
                <span class="mt-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4"/>
                    </svg>
                    Completed Appointments
                </span>
            </div>
        </div>
    </div>
</x-admin-layout>
