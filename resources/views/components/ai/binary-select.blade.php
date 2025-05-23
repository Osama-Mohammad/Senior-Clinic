@props(['label', 'name'])

<div>
    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <select name="{{ $name }}" required class="w-full rounded border-gray-300">
        <option value="">-- Select --</option>
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>
</div>
