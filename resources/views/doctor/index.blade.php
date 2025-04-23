<x-layout>
    <x-navbar />
    @foreach ($doctors as $doctor)
        <p>{{ $doctor->first_name }}</p>
    @endforeach
</x-layout>
