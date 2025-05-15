<x-layout>
    <div class="min-h-screen bg-gradient-to-r from-cyan-100 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto bg-white shadow-2xl rounded-2xl p-8 animate-fade-in space-y-8">

            <div class="text-center">
                <h2 class="text-4xl font-bold text-teal-700 mb-2">Doctor Management</h2>
                <p class="text-gray-600">Manage and edit doctor profiles easily.</p>
            </div>

            <!-- Add New Doctor -->
            <div class="flex justify-end">
                <a href="{{ route('admin.createDoctor') }}"
                    class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition transform hover:scale-105">
                    + Add New Doctor
                </a>
            </div>

            <!-- Doctors Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-center font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($doctors as $doctor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->phone_number ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($doctor->image)
                                        <img src="{{ asset('storage/' . $doctor->image) }}" alt="Doctor Image" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                    <a href="{{ route('admin.editDoctor', $doctor) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-xs font-semibold transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.deleteDoctor', $doctor) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this doctor?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-xs font-semibold transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">No doctors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $doctors->links() }}
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mt-6 text-center text-green-600 font-bold">
                    {{ session('success') }}
                </div>
            @endif

        </div>
    </div>

    <!-- Smooth Fade In Animation -->
    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-layout>
