<x-layout>
    <table>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
        @forelse ($secretaries as $secretary)
            <tr>
                <td>{{ $secretary->id }}</td>
                <td>{{ $secretary->first_name }} {{ $secretary->last_name }}</td>
                <td>{{ $secretary->email }}</td>
                <td>
                    <form action="{{ route('admin.deleteSecretary', $secretary) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
        @endforelse
    </table>
    @if (session('sucess'))
        {{ session('success') }}
    @endif
</x-layout>
