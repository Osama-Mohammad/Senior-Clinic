<header class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white shadow-md sticky top-0 z-50" x-data="{ open: false }">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <div class="w-full">
        <div class="flex items-center justify-between h-16 px-6 md:px-10">
            <!-- Left: Logo and Greeting -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('patient.edit', Auth::guard('patient')->user()->id) }}"
                    class="bg-white p-1 rounded-full hover:opacity-80 transition">
                    @if (Auth::guard('patient')->user()->image)
                        <img src="{{ asset('storage/' . Auth::guard('patient')->user()->image) }}"
                            class="w-10 h-10 object-cover rounded-full" alt="Profile">
                    @else
                        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                            class="w-10 h-10 object-cover rounded-full" alt="Default Profile">
                    @endif
                </a>
                <div class="text-xl font-bold tracking-wide">
                    Hello, {{ Auth::guard('patient')->user()->first_name ?? 'Guest' }}
                </div>
            </div>

            <!-- Right: Desktop Navigation -->
            <nav class="hidden md:flex space-x-6 text-sm items-center">
                @if (Auth::guard('admin')->check())
                    <a href="{{ route('admin.dashboard', Auth::guard('admin')->user()->id) }}"
                        class="flex items-center gap-2 hover:text-emerald-300 transition">
                        <i class="fas fa-home"></i> Home
                    </a>
                @elseif (Auth::guard('patient')->check())
                    <a href="#top" class="flex items-center gap-2 hover:text-emerald-300 transition">
                        <i class="fas fa-home"></i> Home

                        <a href="{{ route('patient.appointment.index') }}" class="flex items-center gap-2 hover:text-emerald-300 transition">
                            <i class="fas fa-home"></i> My Appointments
                        </a>
                    @elseif (Auth::guard('doctor')->check())
                        <a href="#top" class="flex items-center gap-2 hover:text-emerald-300 transition">
                            <i class="fas fa-home"></i> Home
                        </a>
                @endif

                <a href="#about" class="flex items-center gap-2 hover:text-emerald-300 transition">
                    <i class="fas fa-info-circle"></i> About Us
                </a>



                <a href="#clinics" class="flex items-center gap-2 hover:text-emerald-300 transition">
                    <i class="fas fa-hospital"></i> Clinics
                </a>
                <a href="#doctors" class="flex items-center gap-2 hover:text-emerald-300 transition">
                    <i class="fas fa-user-md"></i> Doctors
                </a>
                <a href="{{ route('patient.Ai.create') }}"
                    class="flex items-center gap-2 hover:text-emerald-300 transition">
                    <i class="fas fa-robot"></i> AI Test
                </a>

                <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 hover:text-red-400 transition">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>

            <!-- Mobile Toggle -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-white focus:outline-none">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown -->
        <div x-show="open" @click.outside="open = false" class="md:hidden px-4 mt-2 space-y-2 text-sm">
            <a href="#top" class="flex items-center gap-2 px-4 py-2 hover:bg-teal-700 rounded">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="#about" class="flex items-center gap-2 px-4 py-2 hover:bg-teal-700 rounded">
                <i class="fas fa-info-circle"></i> About Us
            </a>
            <a href="#clinics" class="flex items-center gap-2 px-4 py-2 hover:bg-teal-700 rounded">
                <i class="fas fa-hospital"></i> Clinics
            </a>
            <a href="#doctors" class="flex items-center gap-2 px-4 py-2 hover:bg-teal-700 rounded">
                <i class="fas fa-user-md"></i> Doctors
            </a>
            <a href="{{ route('patient.Ai.create') }}"
                class="flex items-center gap-2 px-4 py-2 hover:bg-teal-700 rounded">
                <i class="fas fa-robot"></i> AI Test
            </a>
            <a href="{{ route('patient.edit', Auth::guard('patient')->user()->id) }}"
                class="flex items-center gap-2 px-4 py-2 hover:bg-teal-700 rounded">
                <i class="fas fa-user-circle"></i> My Profile
            </a>
            <form action="{{ route('auth.logout') }}" method="POST" class="block">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 hover:bg-red-600 rounded">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
</header>
