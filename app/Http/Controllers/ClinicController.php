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
        $clinics = Clinic::paginate(6);
        return view('clinic.index', compact('clinics'));
    }


    /**
     * Ajax search by clinic name
     */
    public function search(Request $request)
    {
        $q = $request->get('query', '');
        $clinics = Clinic::where('name', 'like', "%{$q}%")->get();

        return response()->json(['clinics' => $clinics]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Clinic $clinic)
    {
        $clinic = $clinic->load('doctors');
        return view('clinic.show', compact('clinic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clinic $clinic) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clinic $clinic) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clinic $clinic) {}
}
