<x-layout>
    <form action="{{ route('patient.store') }}" method="POST">
        <x-PatientStoreForm :cities="$cities" />
        <button type="submit">Create Patient</button>
    </form>
    <a href="{{ route('auth.login') }}">Already have an account ?</a>
</x-layout>
