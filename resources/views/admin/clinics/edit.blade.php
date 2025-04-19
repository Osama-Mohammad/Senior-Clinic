<x-layout>
    <h2>Update Clinic</h2>
    <form action="{{ route('admin.updateClinic', $clinic) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="">Name</label>
        <input type="text" name="name" id="name" value="{{ $clinic->name }}">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Address</label>
        <input type="text" name="address" id="address" value="{{ $clinic->address }}">
        @error('address')
            <div class="alert alert-danger">{{ $message }}
            </div>
        @enderror
        <br>

        <label for="">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" value="{{ $clinic->phone_number }}">
        @error('phone_number')
            <div class="alert
        alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Description</label>
        <input type="text" name="description" id="description" value="{{ $clinic->description }}">
        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <button type="submit">Update</button>
    </form>
</x-layout>
