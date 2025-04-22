<x-layout>
    <h2>Create New Admin</h2>
    <form action="{{ route('admin.store') }}" method="POST">
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
        <button>Create Admin</button>
    </form>
</x-layout>
