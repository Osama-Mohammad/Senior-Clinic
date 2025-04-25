<x-layout>
    <h2>Doctor Management</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Doctors List</h5>
            <a href="{{ route('admin.createDoctor') }}">Add a new Doctor</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Image</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->id }}</td>
                            <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                            <td>{{ $doctor->email }}</td>
                            <td>{{ $doctor->phone_number }}</td>
                            <td>{{ $doctor->image }}</td>
                            <td>
                                <a href="{{ route('admin.editDoctor', $doctor) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.deleteDoctor', $doctor) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No doctors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if (session('success'))
                {{ session('success') }}
            @endif
            {{-- Pagination links --}}
            {{ $doctors->links() }}
        </div>
</x-layout>
