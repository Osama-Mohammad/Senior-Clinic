<x-layout>
    <h2>Create New Clinic</h2>
    <form action="{{ route('admin.storeClinic') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="">Name</label>
        <input type="text" name="name" id="name">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        {{-- <label for="">Address</label>
        <input type="text" name="address" id="address">
        @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br> --}}

        <label for="">Image</label>
        <input type="file" name="image" id="image">
        @error('image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>


        <label for="">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number">
        @error('phone_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Description</label>
        <input type="text" name="description" id="description">
        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <button type="submit">Create Clinic</button>
    </form>
</x-layout>
