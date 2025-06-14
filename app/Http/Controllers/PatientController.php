<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
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
    public function create()
    {
        $cities = $this->cities;
        return view('patient.create', compact('cities'));
    }

    public function store(StorePatientRequest $request)
    {
        $validated = $request->validated();
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

        return back()->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        $this->authorize('view', $patient);

        // now clinics listens on ?clinics_page=…
        $clinics = Clinic::paginate(3, ['*'], 'clinics_page');

        // doctors listens on ?doctors_page=…
        $doctors = Doctor::paginate(3, ['*'], 'doctors_page');

        return view('patient.show', compact('patient', 'clinics', 'doctors'));
    }


    public function edit(Patient $patient)
    {
        $cities = $this->cities;
        return view('patient.edit', compact('patient', 'cities'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:patients,email,' . $patient->id,
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:M,F',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Include in validation
            'password' => 'nullable|confirmed|min:8'
        ]);

        // Handle image if uploaded
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('patient_images', 'public');
        }

        if (isset($validated['password'])) {
            $patient->password = Hash::make($validated['password']);
            $patient->save();
        }

        $patient->update(Arr::except($validated, ['password']));
        Auth::guard('patient')->login($patient);

        return redirect()->route('patient.show', $patient->id)->with('success', 'Patient updated successfully.');
    }



    public function destroy(Patient $patient)
    {
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }

        $patient->delete();

        return redirect()->route('patient.create')->with('success', 'Patient deleted successfully.');
    }
}
