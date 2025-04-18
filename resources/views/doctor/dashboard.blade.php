<x-layout>
    <h2>Doctor Dashboard</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Welcome, {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
            <p class="card-text">You are logged in as a doctor.</p>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        </div>
    </div>
    <a href="{{ route('doctor.edit', $doctor) }}">Edit Profile</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</x-layout>
