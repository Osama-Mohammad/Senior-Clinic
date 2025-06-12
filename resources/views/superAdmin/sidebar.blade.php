<aside class="w-64 bg-gradient-to-b from-white to-blue-50 shadow-xl hidden md:block rounded-tr-3xl rounded-br-3xl border-r border-blue-100">
    <div class="p-6 border-b border-blue-100">
        <h2 class="text-2xl font-extrabold text-teal-700 tracking-tight">Super Admin</h2>
        <p class="text-sm text-gray-500 mt-1">Control Panel</p>
    </div>

    <nav class="mt-8 space-y-3 px-6 text-[16px] font-medium">
        <a href="{{ route('superadmin.admin.index') }}"
           class="flex items-center gap-2 px-4 py-2 text-gray-700 bg-white hover:bg-teal-100 rounded-xl transition duration-200 shadow-sm hover:shadow-md">
            <span>🛠</span> Manage Admins
        </a>

        {{-- Add more links here as needed --}}
        {{-- Example: --}}
        {{-- <a href="#" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-teal-100 rounded-xl transition duration-200">
            <span>📊</span> Dashboard Stats
        </a> --}}
    </nav>

    <div class="mt-10 px-6 text-xs text-gray-400">
        © {{ date('Y') }} MediBook AI
    </div>
</aside>
