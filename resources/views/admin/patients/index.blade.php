<x-admin-layout>

    <div class="min-h-screen bg-gradient-to-r from-cyan-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto bg-white p-8 rounded-2xl shadow-xl animate-fade-in space-y-8">

            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-teal-700">Patient Management</h2>
                    <p class="text-gray-500 mt-1 text-sm">Manage all registered patients efficiently.</p>
                </div>
                <a href="{{ route('admin.createPatient') }}"
                    class="inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold px-6 py-3 rounded-md shadow transition transform hover:scale-105">
                    + Add New Patient
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-teal-500 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left text-sm font-semibold">ID</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Name</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Email</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Phone</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Address</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">DOB</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Gender</th>
                            <th class="py-3 px-6 text-center text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($patients as $patient)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-3 px-6">{{ $patient->id }}</td>
                                <td class="py-3 px-6">{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                <td class="py-3 px-6">{{ $patient->email }}</td>
                                <td class="py-3 px-6">{{ $patient->phone_number }}</td>
                                <td class="py-3 px-6">{{ $patient->address }}</td>
                                <td class="py-3 px-6">{{ $patient->date_of_birth }}</td>
                                <td class="py-3 px-6">
                                    {{ $patient->gender == 'M' ? 'Male' : 'Female' }}
                                </td>
                                <td class="py-3 px-6 flex justify-center gap-2">
                                    <a href="{{ route('admin.editPatient', $patient) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-md shadow">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.deletePatient', $patient) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-md shadow">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-4 text-center text-gray-500">No patients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (session('success'))
                <div class="text-green-600 text-center font-semibold mt-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Pagination -->
            <div class="mt-6">
                {{ $patients->links() }}
            </div>

        </div>
    </div>

    <!-- Animation -->
    <style>
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-admin-layout>

