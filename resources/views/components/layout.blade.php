<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- AlpineJS (only once) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome (only once) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Alpine cloak style -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- <script src="https://unpkg.com/alpinejs" defer></script> --}}
</head>

<body x-data="{ show: false }" x-init="show = true" class="overflow-x-hidden" id="top" class="scroll-smooth">
    <!-- Transition Wrapper -->
    <div x-show="show" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4">
        {{ $slot }}
    </div>

</body>

</html>
