<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-cyan-100 via-blue-50 to-white min-h-screen">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-2xl border-r border-gray-100 px-6 py-8 flex flex-col justify-between">
            <div class="space-y-6">
                <!-- Logo or Avatar -->
                <div class="flex items-center justify-center">
                    <div class="text-3xl text-teal-600 font-bold tracking-wide">
                        🩺 MediBook AI
                    </div>
                </div>

                <!-- Welcome -->
                <div class="text-center">
                    <h2 class="text-xl font-semibold text-teal-700">Doctor Panel</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        Welcome, {{ Auth::guard('doctor')->user()->first_name }}
                    </p>
                </div>

                <!-- Navigation -->
                <nav class="flex flex-col space-y-3 text-sm font-medium">
                    <a href="{{ route('doctor.edit', Auth::guard('doctor')->user()) }}"
                        class="transition duration-300 bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-lg text-center shadow">
                        📝 Edit Profile
                    </a>

                    <a href="{{ route('doctor.secretary.index') }}"
                        class="transition duration-300 bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-lg text-center shadow">
                        🧑‍💼 Manage Secretaries
                    </a>

                    <a href="{{ route('doctor.appointments.index') }}"
                        class="transition duration-300 bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-lg text-center shadow">
                        📅 View Appointments
                    </a>

                    @php
                        $clinicName = Auth::guard('doctor')->user()->clinic->name ?? '';
                    @endphp

                    @if ($clinicName === 'HeartCare Cardiology Center')
                        <a href="{{ route('doctor.ai.test.form') }}"
                            class="transition duration-300 bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-lg text-center shadow">
                            🫀 Run Heart Failure AI Test
                        </a>
                    @elseif ($clinicName === 'NeuroLife Brain Clinic')
                        <a href="{{ route('doctor.stroke.test.form') }}"
                            class="transition duration-300 bg-purple-500 hover:bg-purple-600 text-white py-2 px-4 rounded-lg text-center shadow">
                            🧠 Run Stroke AI Test
                        </a>
                    @else
                        <p class="text-center text-sm text-red-400 mt-2">AI Test not allowed for your clinic.</p>
                    @endif
                </nav>
            </div>

            <!-- Logout -->
            <form action="{{ route('auth.logout') }}" method="POST" class="mt-10">
                @csrf
                <button type="submit"
                    class="transition duration-300 bg-red-500 hover:bg-red-600 text-white w-full py-2 px-4 rounded-lg text-center shadow">
                    🚪 Logout
                </button>
            </form>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 px-10 py-12 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>

</html>
