<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-cyan-50 to-blue-50 min-h-screen">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-teal-700">Doctor Panel</h2>
            <p class="text-gray-600 text-sm">
                Welcome, {{ Auth::guard('doctor')->user()->first_name }}
            </p>

            <nav class="flex flex-col space-y-3">
                <a href="{{ route('doctor.edit', Auth::guard('doctor')->user()) }}"
                   class="bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded shadow text-center">
                    Edit Profile
                </a>

                <a href="{{ route('doctor.secretary.index') }}"
                   class="bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded shadow text-center">
                    Manage Secretaries
                </a>

                <a href="{{ route('doctor.appointments.index') }}"
                   class="bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded shadow text-center">
                    View Appointments
                </a>

                <a href="{{ route('doctor.ai.test.form') }}"
                   class="bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded shadow text-center">
                    🧠 Run AI Test
                </a>

                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded shadow w-full text-center">
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-10">
            @yield('content')
        </div>
    </div>

</body>
</html>
