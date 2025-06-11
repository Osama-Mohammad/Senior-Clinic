<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Secretary;
use App\Models\SuperAdmin;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function show()
    {
        // dd($superAdmin->id);
        $superAdmin = Auth::guard('superadmin')->user();
        $stats = [
            'patients'    => Patient::count(),
            'secretaries' => Secretary::count(),
            'doctors'     => Doctor::count(),
            'appointments' => Appointment::count(),
        ];


        $stats['booked']    = Appointment::where('status', 'Booked')->count();
        $stats['canceled']  = Appointment::where('status', 'Canceled')->count();
        $stats['completed'] = Appointment::where('status', 'Completed')->count();

        return view('superAdmin.show', compact('superAdmin','stats'));
    }
    
}
