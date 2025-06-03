<x-admin-layout>
    <!-- Only the main content! -->

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
            <!-- Management Buttons -->
            <a href="{{ route('admin.manageDoctors', $admin) }}" class="flex flex-col items-center bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <i class="fas fa-user-md fa-2x mb-2"></i>
                Manage Doctors
            </a>
            <a href="{{ route('admin.managePatients', $admin) }}" class="flex flex-col items-center bg-green-100 hover:bg-green-200 text-green-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <i class="fas fa-users fa-2x mb-2"></i>
                Manage Patients
            </a>
            <a href="{{ route('admin.manageClinics', $admin) }}" class="flex flex-col items-center bg-purple-100 hover:bg-purple-200 text-purple-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <i class="fas fa-hospital fa-2x mb-2"></i>
                Manage Clinics
            </a>

            <a href="{{ route('admin.manage-secretary', $admin) }}" class="flex flex-col items-center bg-purple-100 hover:bg-purple-200 text-purple-700 font-semibold p-6 rounded-xl shadow-lg hover:scale-105 transition duration-300">
                <i class="fas fa-hospital fa-2x mb-2"></i>
                Manage Secretaries
            </a>
        </div>

    </div>
</x-admin-layout>
