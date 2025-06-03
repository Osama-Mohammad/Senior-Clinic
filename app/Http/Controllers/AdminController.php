<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Secretary;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rules\Can;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Admin::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('admin.dashboard', Auth::guard('admin')->user())->with('success', 'Admin created successfully');
    }

    public function dashboard(Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();

        if (!$currentAdmin) {
            return redirect()->route('auth.login')->with('error', 'Please login first');
        }
        $this->authorize('view', $admin);

        // Instead of loading every record (Patient::all()), just grab the counts:
        $stats = [
            'patients'    => Patient::count(),
            'secretaries' => Secretary::count(),
            'doctors'     => Doctor::count(),
            'appointments' => Appointment::count(),
            // (You can add more aggregates here: e.g. 'todayAppointments' => Appointment::whereDate('created_at', today())->count(), etc.)
        ];

        // 2) Calculate status‐specific counts (adjust status strings if needed)
        $stats['booked']    = Appointment::where('status', 'Booked')->count();
        $stats['canceled']  = Appointment::where('status', 'Canceled')->count();
        $stats['completed'] = Appointment::where('status', 'Completed')->count();

        // Pass the $stats array (and the $admin) to the view
        return view('admin.dashboard', compact('admin', 'stats'));
    }
}
