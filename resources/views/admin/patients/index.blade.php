<x-layout>
    <h2>patient Management</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">patients List</h5>
            <a href="{{ route('admin.createPatient') }}">Add a new Patient</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Date Of Birth</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ $patient->email }}</td>
                            <td>{{ $patient->phone_number }}</td>
                            <td>{{ $patient->address }}</td>
                            <td>{{ $patient->date_of_birth }}</td>
                            <td>
                                {{ $patient->gender == 'M' ? 'Male' : 'Female' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.editPatient', $patient) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.deletePatient', $patient) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if (session('success'))
                {{ session('success') }}
            @endif
            {{-- Pagination links --}}
            {{ $patients->links() }}
        </div>
</x-layout>
