<x-layout>
    <h2>clinic Management</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Clinics List</h5>
            <a href="{{ route('admin.createClinic') }}">Add a new Clinic</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clinics as $clinic)
                        <tr>
                            <td>{{ $clinic->id }}</td>
                            <td>{{ $clinic->name }} </td>
                            <td>{{ $clinic->phone_number }}</td>
                            <td>{{ $clinic->description }}</td>
                            <td>
                                @if ($clinic->image)
                                <img src="{{ asset('storage/' . $clinic->image) }}" alt="Clinic Image" width="100" class="img-thumbnail">

                                @else
                                    No Image Found For This Clinic
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.editClinic', $clinic) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('admin.deleteClinic', $clinic) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No clinics found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if (session('success'))
                {{ session('success') }}
            @endif
            {{-- Pagination links --}}
            {{ $clinics->links() }}
        </div>
</x-layout>
