<x-layout>
     <x-navbar />
    <form action="{{ route('patient.update', $patient) }}" method="POST" enctype="multipart/form-data">
        <x-PatientUpdateForm :cities="$cities" :patient="$patient" />
    </form>
    <form action="{{ route('patient.delete', $patient) }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
</x-layout>
