<x-layout>
    <div class="min-h-screen bg-gradient-to-r from-teal-100 to-cyan-100 flex flex-col items-center justify-center py-12 px-6 lg:px-8">
        <div class="max-w-5xl w-full bg-white shadow-2xl rounded-2xl p-10 space-y-10 animate-fade-in">

            <!-- Welcome Section -->
            <div class="text-center space-y-4">
                <h2 class="text-5xl font-extrabold text-teal-700 drop-shadow-lg">
                    Welcome, {{ $admin->first_name }} {{ $admin->last_name }}
                </h2>
                <p class="text-gray-600 text-lg">
                    You are logged in as Admin. Manage your healthcare platform with ease.
                </p>
            </div>

            <!-- Management Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                <a href="{{ route('admin.manageDoctors', $admin) }}"
                   class="flex flex-col items-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition transform duration-300">
                    <i class="fas fa-user-md fa-2x mb-2"></i>
                    Manage Doctors
                </a>

                <a href="{{ route('admin.managePatients', $admin) }}"
                   class="flex flex-col items-center bg-green-100 hover:bg-green-200 text-green-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition transform duration-300">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    Manage Patients
                </a>

                <a href="{{ route('admin.manageClinics', $admin) }}"
                   class="flex flex-col items-center bg-purple-100 hover:bg-purple-200 text-purple-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition transform duration-300">
                    <i class="fas fa-hospital fa-2x mb-2"></i>
                    Manage Clinics
                </a>
            </div>

            <!-- Logout Button -->
            <div class="text-center pt-6">
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white font-bold px-8 py-4 rounded-xl shadow-xl hover:scale-105 transition transform duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- ✨ Smooth Fade In Animation (only if you want it) -->
    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-layout>
