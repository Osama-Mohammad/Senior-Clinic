@extends('layouts.superadmin')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <!-- Title -->
        <h2 class="text-4xl font-extrabold text-teal-700 mb-8 tracking-tight">Manage Admins</h2>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 px-6 py-4 bg-green-100 text-green-800 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-2xl rounded-2xl">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">First Name</th>
                        <th class="px-6 py-3 text-left">Last Name</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($admins as $admin)
                        <tr class="hover:bg-teal-50 transition">
                            <td class="px-6 py-4 font-medium">{{ $admin->id }}</td>
                            <td class="px-6 py-4">{{ $admin->first_name }}</td>
                            <td class="px-6 py-4">{{ $admin->last_name }}</td>
                            <td class="px-6 py-4">{{ $admin->email }}</td>
                            <td class="px-6 py-4 space-x-2 whitespace-nowrap">
                                <a href="{{ route('superadmin.admin.edit', $admin) }}"
                                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('superadmin.admin.delete', $admin) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this admin?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium shadow">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-6 text-gray-500">No admins found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
