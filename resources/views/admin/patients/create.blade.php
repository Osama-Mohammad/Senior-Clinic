<x-layout>
    <h2>Create Patient</h2>
    <form action="{{ route('admin.storePatient') }}" method="POST">
        @csrf
        <label for="">First Name </label>
        <input type="text" name="first_name" id="first_name">
        @error('first_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Last Name </label>
        <input type="text" name="last_name" id="last_name">
        @error('last_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Email</label>
        <input type="email" name="email" id="email">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Password</label>
        <input type="password" name="password" id="password">
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        @error('password_confirmation')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Address</label>
        <select name="address" id="address">
            <option value="" disabled {{ old('address', $patient->address ?? '') ? '' : 'selected' }}>Select a
                City
            </option>
            @foreach ($cities as $city)
                <option value="{{ $city }}"
                    {{ old('address', $patient->address ?? '') == $city ? 'selected' : '' }}>
                    {{ $city }}
                </option>
            @endforeach
        </select>
        @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number"
            value="{{ old('phone_number', $patient->phone_number ?? '') }}">
        @error('phone_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Date of Birth</label>
        <input type="date" name="date_of_birth" id="date_of_birth"
            value="{{ old('date_of_birth', $patient->date_of_birth ?? '') }}">
        @error('date_of_birth')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Gender</label>
        <select name="gender" id="gender">
            <option value="" disabled {{ old('gender', $patient->gender ?? '') ? '' : 'selected' }}>Select a
                Gender
            </option>
            <option value="M" {{ old('gender', $patient->gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
            <option value="F" {{ old('gender', $patient->gender ?? '') == 'F' ? 'selected' : '' }}>Female</option>
        </select>
        @error('gender')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <button type="submit">Create Patient</button>
    </form>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

</x-layout>
