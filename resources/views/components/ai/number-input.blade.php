@props(['label', 'name'])

<div>
    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input type="number" step="0.01" name="{{ $name }}" required
        class="w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-teal-500">
</div>
