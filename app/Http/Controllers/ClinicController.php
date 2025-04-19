<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clinics = Clinic::paginate();
        return view('admin.clinics.index', compact('clinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clinics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'address' => 'required',
            'phone_number' => 'required',
            'description' => 'required'
        ]);

        $clinic = new Clinic();
        $clinic->name = $validated['name'];
        $clinic->address = $validated['address'];
        $clinic->phone_number = $validated['phone_number'];
        $clinic->description = $validated['description'];

        $clinic->save();
        
        return redirect()->route('admin.manageClinics', Auth::guard('admin')->user())->with('success', 'created clinic successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clinic $clinic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clinic $clinic)
    {
        return view('admin.clinics.edit', compact('clinic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clinic $clinic)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:50',
            'address' => 'required',
            'phone_number' => 'required|unique:clinics,phone_number,' . $clinic->id,
            'description' => 'required'
        ]);

        $clinic->update($validated);

        return redirect()->route('admin.manageClinics', Auth::guard('admin')->user())->with('success', 'updated Clinic Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clinic $clinic)
    {
        $clinic->delete();
        return redirect()->route('admin.manageClinics', Auth::guard('admin')->user())->with('success', 'deleted Clinic Successfully');
    }
}
