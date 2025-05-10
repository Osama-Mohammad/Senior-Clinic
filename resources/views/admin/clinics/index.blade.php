<x-admin-layout>
    <div class="min-h-screen bg-gradient-to-r from-cyan-100 to-blue-100 py-12 px-6 lg:px-8">

        <!-- Container -->
        <div class="max-w-7xl w-full bg-white shadow-2xl rounded-2xl p-10 space-y-8 animate-fade-in mx-auto">

            <!-- Title and Add New Button -->
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-4xl font-bold text-teal-700 mb-2">Clinic Management</h2>
                    <p class="text-gray-600">Manage your clinics easily below.</p>
                </div>
                <a href="{{ route('admin.createClinic') }}"
                   class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm px-6 py-3 rounded-lg shadow transition transform hover:scale-105">
                    + Add New Clinic
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg shadow-md">
                <table class="min-w-full bg-white">
                    <thead class="bg-gradient-to-r from-teal-500 to-cyan-500 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($clinics as $clinic)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $clinic->id }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $clinic->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $clinic->phone_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $clinic->description }}</td>
                                <td class="px-6 py-4">
                                    @if ($clinic->image)
                                        <img src="{{ asset('storage/' . $clinic->image) }}" alt="Clinic Image"
                                             class="w-20 h-20 object-cover rounded-md shadow-sm">
                                    @else
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.editClinic', $clinic) }}"
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-xs font-bold shadow transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.deleteClinic', $clinic) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-xs font-bold shadow transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400 text-sm">No clinics found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $clinics->links() }}
            </div>

        </div>

    </div>

    <!-- Optional Smooth Animation -->
    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-admin-layout>
