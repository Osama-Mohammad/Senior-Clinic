<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PatientController extends Controller
{
    use AuthorizesRequests;

    public $cities = [
        "Beirut",         // Capital and largest city
        "Tripoli",        // Second-largest city, in the north
        "Sidon (Saida)",  // Major southern coastal city
        "Tyre (Sour)",    // Historic coastal city in the south
        "Byblos (Jbeil)", // One of the oldest continuously inhabited cities
        "Zahle",          // Major city in the Bekaa Valley
        "Nabatieh",       // Important city in southern Lebanon
        "Jounieh",        // Coastal city north of Beirut
        "Baalbek",        // Famous for its Roman ruins
        "Aley",           // Mountain town near Beirut
        "Batroun",        // Coastal city north of Byblos
        "Bint Jbeil",     // Southern town near the Israeli border
        "Chouf (Deir el Qamar)", // Historical Druze center
        "Hermel",         // Northern city in the Bekaa region
        "Jbeil (Byblos)", // Alternative name for Byblos
        "Jezzine",        // Scenic mountain town
        "Rashaya",        // Known for its historic castle
        "Zgharta",        // Northern city near Tripoli
        "Anjar",          // Known for its Umayyad ruins
        "Marjayoun"       // Southern town with historical significance
    ];

    public function managePatients(Admin $admin)
    {
        $this->authorize('view', $admin);
        $patients = Patient::paginate();
        return view('admin.patients.index', compact('patients'));
    }


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
        $cities = $this->cities;
        return view('admin.patients.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:patients',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:M,F',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $patient = new Patient();
        $patient->first_name = $validated['first_name'];
        $patient->last_name = $validated['last_name'];
        $patient->email = $validated['email'];
        $patient->password = $validated['password'];
        $patient->phone_number = $validated['phone_number'];
        $patient->address = $validated['address'];
        $patient->date_of_birth = $validated['date_of_birth'];
        $patient->gender = $validated['gender'];

        $patient->save();

        return redirect()->route("admin.managePatients", Auth::guard('admin')->user())->with('success', 'Patient updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $cities = $this->cities;
        return view('admin.patients.edit', compact('patient', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $patientId = $patient->id;

        $validated  = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:patients,email,' . $patientId,
            // 'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:M,F',
        ]);

        // $validated['password'] = Hash::make($validated['password']);

        $patient->update($validated);

        return redirect()->route("admin.managePatients", Auth::guard('admin')->user())->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return back()->with('success', 'deleted patient successfully');
    }
}
