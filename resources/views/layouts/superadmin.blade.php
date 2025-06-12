<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Admin</title>
    @vite('resources/css/app.css') <!-- or use your CSS -->
</head>
<body class="bg-blue-50 min-h-screen">

    <div class="flex">
        {{-- Sidebar --}}
        @include('superadmin.sidebar') <!-- THIS POINTS TO sidebar.blade.php -->

        {{-- Page content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
