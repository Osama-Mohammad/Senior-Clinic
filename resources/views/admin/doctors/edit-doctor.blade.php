<x-layout>
    <h2>Edit Info Of Doctor : {{ $doctor->first_name }} {{ $doctor->last_name }}</h2>
    <form action="{{ route('admin.updateDoctor', $doctor) }}" method="POST" enctype="multipart/form-data">
        @csrf

        @method('PUT')

        <label for="">First Name </label>
        <input type="text" name="first_name" id="first_name" value="{{ $doctor->first_name }}">
        @error('first_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Last Name </label>
        <input type="text" name="last_name" id="last_name" value="{{ $doctor->last_name }}">
        @error('last_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Email</label>
        <input type="email" name="email" id="email" value="{{ $doctor->email }}">
        @error('email')
        @enderror
        <br>



        <label for="">Phone Number </label>
        <input type="text" name="phone_number" id="phone_number" value="{{ $doctor->phone_number }}">
        @error('phone_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Image</label>
        <input type="file" name="image" id="image">
        @error('image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Price</label>
        <input type="text" name="price" id="price" value="{{ $doctor->price }}">
        @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="">Max Daily Appointments</label>
        <input type="text" name="max_daily_appointments" id="max_daily_appointments"
            value="{{ $doctor->max_daily_appointments }}">
        @error('max_daily_appointments')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>

        <label for="available_days">Available Days</label>
        <select name="available_days[]" id="available_days" multiple>
            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <option value="{{ $day }}" {{ in_array($day, $available_days ?? []) ? 'selected' : '' }}>
                    {{ $day }}
                </option>
            @endforeach
        </select>

        <label for="available_hours">Available Work Hours</label>
        <select name="available_hours[]" id="available_hours" multiple>
            @foreach (['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'] as $hour)
                <option value="{{ $hour }}" {{ in_array($hour, $available_hours ?? []) ? 'selected' : '' }}>
                    {{ $hour }}
                </option>
            @endforeach
        </select>
        <br>

        <button type="submit">Update Doctor</button>
    </form>
</x-layout>
