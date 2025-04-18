<x-layout>
    <h2>Login Page</h2>
    <form action="{{ route('auth.login') }}" method="POST">
        @csrf
        <label for="">Email</label>
        <input type="text" name="email" id="email">
        @error('email')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
        <br>
        <label for="">Password</label>
        <input type="text" name="password" id="password">
        @error('password')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
        <br>
        <button type="submit">Login</button>
    </form>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div>
        don't have an account? <a href="{{ route('patient.create') }}">Register</a>
    </div>
</x-layout>
