<x-layout>
    <h2>Admin Dashboard</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Welcome, {{ $admin->first_name }} {{ $admin->last_name }}</h5>
            <p class="card-text">You are logged in as an admin.</p>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        </div>
    </div>
    <a href="{{ route('admin.manageDoctors', $admin) }}">Manage Doctors</a>
    <a href="{{ route('admin.managePatients', $admin) }}">Manage Patients</a>
    <a href="{{ route('admin.manageClinics', $admin) }}">Manage Clinics</a>
</x-layout>
