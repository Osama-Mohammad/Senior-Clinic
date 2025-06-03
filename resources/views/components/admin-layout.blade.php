<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- Tailwind Setup -->
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Correct usage -->
    <!-- AlpineJS for dynamic interactions -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


</head>

<body class="min-h-screen flex">

    <!-- Sidebar -->
    @include('components.adminsidebar')

    <!-- Main Content -->
    <div class="flex-1 bg-gradient-to-r from-teal-100 to-cyan-100 p-10 overflow-y-auto">
        {{ $slot }}
    </div>

</body>
</html>
