<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Secretary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecretaryController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        $secretaries = Secretary::where('doctor_id', $doctor->id)->get();
        return view('doctor.secretary.index', compact('secretaries', 'doctor'));
    }

    public function create()
    {
        return view('doctor.secretary.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:2|max:50',
            'email' => 'required|email|unique:secretaries,email|unique:doctors,email|unique:patients,email',
            'password' => 'required|confirmed|min:8',
            'phone_number' => 'required|min:8'
        ]);

        $validated['doctor_id'] = Auth::guard('doctor')->user()->id;
        $validated['password'] = Hash::make($validated['password']);

        $secretary = new Secretary();
        $secretary->doctor_id = $validated['doctor_id'];
        $secretary->first_name = $validated['first_name'];
        $secretary->last_name = $validated['last_name'];
        $secretary->email = $validated['email'];
        $secretary->password = $validated['password'];
        $secretary->phone_number = $validated['phone_number'];

        $secretary->save();

        return redirect()->route('doctor.secretary.index')->with('success', 'Created Secretary' . $secretary->first_name . ' successfully');
    }
    public function destroy(Secretary $secretary)
    {
        if (!$secretary) {
            return back()->with('error', 'Secretary Not Found');
        }
        $secretary->delete();
        return back()->with('success', 'Delete Secretary Successfully');
    }
}
