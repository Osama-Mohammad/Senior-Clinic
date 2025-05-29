<form action="{{ route('appointments.logs.store', $appointment) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <textarea name="description" required class="w-full p-2 border">{{ old('description', $appointment->log->description ?? '') }}</textarea>
    <input type="file" name="attachments[]" multiple>
    <button type="submit" class="btn-primary mt-4">Save History</button>
</form>
