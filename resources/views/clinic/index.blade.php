<x-layout>
    <x-navbar />
    @foreach ($clinics as $clinic)
        {{ $clinic->name }}
    @endforeach
</x-layout>
