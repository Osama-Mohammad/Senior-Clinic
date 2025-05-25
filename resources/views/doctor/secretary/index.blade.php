<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-blue-900">Manage Secretaries</h1>
            <a href="{{ route('doctor.secretary.create') }}"
                class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-5 py-3 rounded-lg shadow-md transition">
                ➕ Add Secretary
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-800 text-sm px-6 py-4 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-300 text-red-800 text-sm px-6 py-4 rounded-lg shadow">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-100 text-blue-800 text-left text-sm font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Full Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Phone Number</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($secretaries as $secretary)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $secretary->first_name }} {{ $secretary->last_name }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $secretary->email }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $secretary->phone_number }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('doctor.secretary.delete', $secretary) }}" method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this secretary?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-sm transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-8 text-gray-500">
                                No secretaries assigned to Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
