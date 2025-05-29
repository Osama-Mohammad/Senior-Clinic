<x-layout>
    <div class="bg-gradient-to-br from-gray-100 to-white min-h-screen py-10">
        <div class="container mx-auto p-6 md:w-2/3 lg:w-1/2">
            <div class="card shadow-lg rounded-lg bg-white border-l-4 border-blue-500">
                <div class="card-header p-4 bg-blue-50 border-b border-blue-100">
                    <h2 class="text-2xl font-bold text-blue-600 flex items-center">
                        <i class="fas fa-notes-medical text-red-500 mr-2"></i>
                        Patient History Log
                    </h2>
                </div>
                <form action="{{ route('appointments.logs.store', $appointment) }}" method="POST" enctype="multipart/form-data" class="card-body space-y-6 p-6">
                    @csrf
                    <div>
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea id="description" name="description" required class="form-control w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $appointment->log->description ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="attachments" class="block text-gray-700 font-semibold mb-2">Attachments</label>
                        <input type="file" id="attachments" name="attachments[]" multiple class="form-control file-input w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 w-full flex justify-center items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg">
                        <i class="fas fa-save mr-2"></i> Save History
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
