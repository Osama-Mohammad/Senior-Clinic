<x-layout>
    <div class="min-h-screen bg-gradient-to-r from-cyan-100 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto bg-white shadow-2xl rounded-2xl p-8 space-y-8 animate-fade-in">

            <div class="text-center">
                <h2 class="text-4xl font-bold text-teal-700">Secretary Management</h2>
                <p class="text-gray-600">View and manage all registered secretaries.</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-md text-center font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-center font-semibold uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($secretaries as $secretary)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $secretary->id }}</td>
                                <td class="px-6 py-4">{{ $secretary->first_name }} {{ $secretary->last_name }}</td>
                                <td class="px-6 py-4">{{ $secretary->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.deleteSecretary', $secretary) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this secretary?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold text-xs transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">No secretaries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Optional animation -->
    <style>
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-layout>
