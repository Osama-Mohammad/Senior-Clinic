<!-- resources/views/components/adminsidebar.blade.php -->

<div class="w-64 bg-gradient-to-b from-teal-500 to-cyan-500 text-white flex flex-col p-6 space-y-6 min-h-screen">
    <!-- Admin Title -->
    <div class="text-2xl font-bold mb-10">
        Admin Panel
    </div>

    <!-- Navigation Links -->
    <nav class="flex flex-col space-y-4">
        <a href="{{ route('admin.dashboard', $admin ?? auth()->user()) }}" class="hover:bg-teal-600 p-3 rounded-md transition">Dashboard</a>
        <a href="{{ route('admin.manageDoctors', $admin ?? auth()->user()) }}" class="hover:bg-teal-600 p-3 rounded-md transition">Manage Doctors</a>
        <a href="{{ route('admin.managePatients', $admin ?? auth()->user()) }}" class="hover:bg-teal-600 p-3 rounded-md transition">Manage Patients</a>
        <a href="{{ route('admin.manageClinics', $admin ?? auth()->user()) }}" class="hover:bg-teal-600 p-3 rounded-md transition">Manage Clinics</a>
        <a href="{{ route('admin.manage-secretary', $admin ?? auth()->user()) }}" class="hover:bg-teal-600 p-3 rounded-md transition">Manage Secretaries</a>

    </nav>

    @auth

    
    @endguest
    <!-- Logout -->
    <form action="{{ route('auth.logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-md font-bold transition">
            Logout
        </button>
    </form>
</div>
