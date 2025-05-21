<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Secretary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecretaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
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

        return redirect()->route('doctor.dashboard')->with('success', 'Created Secretary' . $secretary->first_name . ' successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Secretary $secretary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secretary $secretary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secretary $secretary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secretary $secretary)
    {
        //
    }


    public function dashboard()
    {
        $patients = Patient::paginate(10);
        return view('secretary.dashboard', compact('patients'));
    }
}
