<x-layout>
    <form action="{{ route('patient.update', $patient) }}" method="POST" enctype="multipart/form-data">
        <x-PatientUpdateForm :cities="$cities" :patient="$patient" />
        <button type="submit">Update Patient : {{ $patient->first_name }}</button>
    </form>
    <form action="{{ route('patient.delete', $patient) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete patient</button>
    </form>
</x-layout>
