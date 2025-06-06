<header class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white shadow-md sticky top-0 z-50" x-data="{ open: false }">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <div class="w-full px-4 md:px-8">
        @auth
            @php $patient = Auth::guard('patient')->user(); @endphp
            <div class="flex items-center justify-between h-16">
                <!-- Left: Avatar + Name -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('patient.edit', $patient->id) }}">
                        <img src="{{ $patient->image ? asset('storage/' . $patient->image) : 'https://cdn-icons-png.flaticon.com/512/847/847969.png' }}"
                             class="w-10 h-10 rounded-full object-cover border-2 border-white hover:opacity-90 transition" alt="Profile">
                    </a>
                    <span class="text-lg font-semibold">
                        Hello, {{ $patient->first_name ?? 'User' }}
                    </span>
                </div>

                <!-- Spacer -->
                <div class="flex-1"></div>

                <!-- Right: Desktop Nav Links -->
                <div class="hidden md:flex space-x-6 text-sm items-center justify-end">
                    @if (Auth::guard('admin')->check())
                        <a href="{{ route('admin.dashboard', Auth::guard('admin')->user()->id) }}" class="flex items-center gap-2 hover:text-emerald-300 transition">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    @elseif (Auth::guard('patient')->check())
                        <a href="{{ route('patient.show', $patient) }}" class="flex items-center gap-2 hover:text-emerald-300 transition">
                            <i class="fas fa-home"></i> Home
                        </a>
                        <a href="{{ route('patient.appointment.index') }}" class="flex items-center gap-2 hover:text-emerald-300 transition">
                            <i class="fas fa-calendar-check"></i> My Appointments
                        </a>
                    @elseif (Auth::guard('doctor')->check())
                        <a href="{{ route('doctor.dashboard') }}" class="flex items-center gap-2 hover:text-emerald-300 transition">
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
                    <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 hover:text-red-400 transition">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>

                <!-- Right: Mobile Menu Toggle -->
                <div class="md:hidden">
                    <button @click="open = !open" class="focus:outline-none">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav Links -->
            <div x-show="open" @click.outside="open = false" class="md:hidden bg-teal-700 px-4 pt-2 pb-4 space-y-2 text-sm">
                @if (Auth::guard('admin')->check())
                    <a href="{{ route('admin.dashboard', Auth::guard('admin')->user()->id) }}" class="block px-3 py-2 hover:bg-teal-600 rounded">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                @elseif (Auth::guard('patient')->check())
                    <a href="{{ route('patient.show', $patient) }}" class="block px-3 py-2 hover:bg-teal-600 rounded">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="{{ route('patient.appointment.index') }}" class="block px-3 py-2 hover:bg-teal-600 rounded">
                        <i class="fas fa-calendar-check"></i> My Appointments
                    </a>
                @elseif (Auth::guard('doctor')->check())
                    <a href="{{ route('doctor.dashboard') }}" class="block px-3 py-2 hover:bg-teal-600 rounded">
                        <i class="fas fa-home"></i> Home
                    </a>
                @endif
                <a href="#about" class="block px-3 py-2 hover:bg-teal-600 rounded">
                    <i class="fas fa-info-circle"></i> About Us
                </a>
                <a href="#clinics" class="block px-3 py-2 hover:bg-teal-600 rounded">
                    <i class="fas fa-hospital"></i> Clinics
                </a>
                <a href="#doctors" class="block px-3 py-2 hover:bg-teal-600 rounded">
                    <i class="fas fa-user-md"></i> Doctors
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 hover:bg-red-600 rounded">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        @endauth

        @guest
            <div class="flex items-center justify-between h-16">
                <!-- Left: Branding -->
                <a href="/" class="flex items-center space-x-2">
                    <i class="fas fa-stethoscope text-2xl"></i>
                    <span class="text-2xl font-bold tracking-wide">MEDIBOOK</span>
                </a>

                <!-- Right: Guest Links -->
                <nav class="hidden md:flex space-x-6 text-sm items-center">
                    <a href="#top" class="hover:text-emerald-300 transition flex items-center gap-2">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="#about" class="hover:text-emerald-300 transition flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> About Us
                    </a>
                    <a href="#clinics" class="hover:text-emerald-300 transition flex items-center gap-2">
                        <i class="fas fa-hospital"></i> Clinics
                    </a>
                    <a href="#doctors" class="hover:text-emerald-300 transition flex items-center gap-2">
                        <i class="fas fa-user-md"></i> Doctors
                    </a>
                    <a href="{{ route('auth.loginPage') }}" class="bg-white text-teal-600 font-semibold px-4 py-2 rounded-md hover:bg-gray-100 transition flex items-center gap-2">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </a>
                    <a href="{{ route('patient.create') }}" class="bg-teal-800 hover:bg-teal-900 font-semibold px-4 py-2 rounded-md transition flex items-center gap-2">
                        <i class="fas fa-user-plus"></i> Sign Up
                    </a>
                </nav>

                <!-- Right: Mobile Toggle -->
                <div class="md:hidden">
                    <button @click="open = !open" class="focus:outline-none">
                        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav for Guests -->
            <div x-show="open" @click.outside="open = false" class="md:hidden bg-teal-700 px-4 pt-2 pb-4 space-y-2 text-sm">
                <a href="#top" class="block px-3 py-2 hover:bg-teal-600 rounded">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="#about" class="block px-3 py-2 hover:bg-teal-600 rounded">
                    <i class="fas fa-info-circle"></i> About Us
                </a>
                <a href="#clinics" class="block px-3 py-2 hover:bg-teal-600 rounded">
                    <i class="fas fa-hospital"></i> Clinics
                </a>
                <a href="#doctors" class="block px-3 py-2 hover:bg-teal-600 rounded">
                    <i class="fas fa-user-md"></i> Doctors
                </a>
                <a href="{{ route('auth.loginPage') }}" class="block px-3 py-2 bg-white text-teal-600 rounded hover:bg-gray-100 transition">
                    <i class="fas fa-sign-in-alt"></i> Log In
                </a>
                <a href="{{ route('patient.create') }}" class="block px-3 py-2 bg-teal-800 hover:bg-teal-900 rounded text-white transition">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
            </div>
        @endguest
    </div>
</header>
