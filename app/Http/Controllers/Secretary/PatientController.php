<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
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
        return view('secretary.patient.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:patients,email,|unique:doctors,email|unique:admins,email',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:M,F',
            'password' => 'required|min:8|confirmed'
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

        return redirect()->route('secretary.dashboard')->with('success', 'Patient created successfully.');
    }

    public function search(Request $request)
    {
        $q = $request->get('query', '');
        $patients = Patient::where('first_name', 'like', "%{$q}%")
            ->orWhere('last_name', 'like', "%{$q}%")
            ->get();

        return response()->json(['patients' => $patients]);
    }
}
