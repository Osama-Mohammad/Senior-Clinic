@props(['cities', 'patient' => null])

@csrf

@method('PUT')

<label for="">First Name </label>
<input type="text" name="first_name" id="first_name" value="{{ $patient->first_name }}">
@error('first_name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>

<label for="">Last Name </label>
<input type="text" name="last_name" id="last_name" value="{{ $patient->last_name }}">
@error('last_name')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>

<label for="">Email</label>
<input type="email" name="email" id="email" value="{{ $patient->email }}">
@error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>

{{-- <label for="">Password</label>
<input type="password" name="password" id="password" value="{{ decrypt($patient->password) }}">
@error('password')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br> --}}

<label for="">Address</label>
<select name="address" id="address">
    @foreach ($cities as $city)
        <option value="{{ $city }}" {{ $patient->address == $city ? 'selected' : '' }}>
            {{ $city }}
        </option>
    @endforeach
</select>
@error('address')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>

<label for="">Phone Number</label>
<input type="text" name="phone_number" id="phone_number" value="{{ $patient->phone_number }}">
@error('phone_number')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>

<label for="">Date of Birth</label>
<input type="date" name="date_of_birth" id="date_of_birth" value="{{ $patient->date_of_birth }}">
@error('date_of_birth')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>

<label for="">Gender</label>
<select name="gender" id="gender">
    <option value="M" {{ $patient->gender == 'M' ? 'selected' : '' }}>Male</option>
    <option value="F" {{ $patient->gender == 'F' ? 'selected' : '' }}>Female</option>
</select>
@error('gender')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<br>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
