<x-layout>
    <h2>Patient Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Name: {{ $patient->first_name }} {{ $patient->last_name }}</h5>
            <p class="card-text">Email: {{ $patient->email }}</p>
            <p class="card-text">Phone: {{ $patient->phone_number }}</p>
            <p class="card-text">Address: {{ $patient->address }}</p>
            <a href="#" class="btn btn-primary">Back to Patients</a>
            {{-- {{ route('patients.index') }} --}}
        </div>
    </div>
</x-layout>
