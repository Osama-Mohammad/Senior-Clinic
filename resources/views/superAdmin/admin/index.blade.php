<x-layout>
    <div class="max-w-6xl mx-auto p-6">
        <!-- Title -->
        <h2 class="text-3xl font-bold text-blue-800 mb-6">Manage Admins</h2>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-700 text-left text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">First Name</th>
                        <th class="px-6 py-3">Last Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    @foreach ($admins as $admin)
                        <tr>
                            <td class="px-6 py-4">{{ $admin->id }}</td>
                            <td class="px-6 py-4">{{ $admin->first_name }}</td>
                            <td class="px-6 py-4">{{ $admin->last_name }}</td>
                            <td class="px-6 py-4">{{ $admin->email }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <!-- Update -->
                                {{-- {{ route('superadmin.admins.edit', $admin->id) }} --}}
                                <a href="{{ route('superadmin.admin.edit', $admin) }}"
                                    class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                    Edits
                                </a>

                                <!-- Delete -->
                                {{-- {{ route('superadmin.admins.destroy', $admin->id) }} --}}
                                <form action="{{ route('superadmin.admin.delete', $admin) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this admin?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($admins->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">No admins found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if (session('success'))
                <p>{{ session('success') }}</p>
            @endif
        </div>
    </div>
</x-layout>
