<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public $cities = [
        "Beirut",         // Capital and largest address
        "Tripoli",        // Second-largest address, in the north
        "Sidon (Saida)",  // Major southern coastal address
        "Tyre (Sour)",    // Historic coastal address in the south
        "Byblos (Jbeil)", // One of the oldest continuously inhabited cities
        "Zahle",          // Major address in the Bekaa Valley
        "Nabatieh",       // Important address in southern Lebanon
        "Jounieh",        // Coastal address north of Beirut
        "Baalbek",        // Famous for its Roman ruins
        "Aley",           // Mountain town near Beirut
        "Batroun",        // Coastal address north of Byblos
        "Bint Jbeil",     // Southern town near the Israeli border
        "Chouf (Deir el Qamar)", // Historical Druze center
        "Hermel",         // Northern address in the Bekaa region
        "Jbeil (Byblos)", // Alternative name for Byblos
        "Jezzine",        // Scenic mountain town
        "Rashaya",        // Known for its historic castle
        "Zgharta",        // Northern address near Tripoli
        "Anjar",          // Known for its Umayyad ruins
        "Marjayoun"       // Southern town with historical significance
    ];

    public function registerPage()
    {
        return view('auth.register');
    }


    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::guard('patient')->attempt($validated)) {
            Auth::login(Auth::guard('patient')->user());
            return redirect()->route('patient.show', Auth::guard('patient')->user())->with('success', 'Login successful');
        } elseif (Auth::guard('admin')->attempt($validated)) {
            Auth::login(Auth::guard('admin')->user());
            return redirect()->route('admin.dashboard', Auth::guard('admin')->user())->with('success', 'Login successful');
        } elseif (Auth::guard('doctor')->attempt($validated)) {
            Auth::login(Auth::guard('doctor')->user());
            return redirect()->route('doctor.dashboard', Auth::guard('doctor')->user())->with('success', 'Login successful');
        } elseif (Auth::guard('secretary')->attempt($validated)) {
            Auth::login(Auth::guard('secretary')->user());
            return redirect()->route('secretary.dashboard', Auth::guard('secretary')->user())->with('success', 'Login successful');
        } else {
            return back()->with('error', 'Invalid Credentials');
        }
    }

    public function logout()
    {
        Auth::guard('patient')->logout();
        Auth::guard('admin')->logout();
        Auth::guard('doctor')->logout();
        Auth::guard('secretary')->logout();

        return redirect()->route('auth.loginPage')->with('success', 'Logout successful');
    }

    // redirect to google
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $google = Socialite::driver('google')->user();

        // if patient exist
        if ($patient = Patient::where('email', $google->getEmail())->first()) {
            Auth::guard('patient')->login($patient);
            return redirect()->route('patient.show', $patient);
        }

        // 2️⃣ New: break out names
        [$first, $last] = array_pad(explode(' ', $google->getName(), 2), 2, ' ');

        // 3️⃣ Store minimal info in session
        session([
            'google_user' => [
                'google_id'   => $google->getId(),
                'email'       => $google->getEmail(),
                'first_name'  => $first,
                'last_name'   => $last,
                'avatar_url' => $google->getAvatar(),
            ],
        ]);
        return redirect()->route('auth.google.complete');
    }

    public function showGoogleCompleteForm()
    {
        $cities = $this->cities;

        if (! session()->has('google_user')) {
            return redirect()->route('auth.loginPage')
                ->with('error', 'Please start the Google login again.');
        }
        $g = session('google_user');
        return view('auth.google_complete', compact('g', 'cities'));
    }

    public function completeGoogleRegistration(Request $req)
    {
        $g = session('google_user');
        if (! $g) {
            return redirect()->route('auth.loginPage')
                ->with('error', 'Session expired.');
        }

        // 1️⃣ Validate the rest of the profile fields
        $data = $req->validate([
            'phone_number'   => 'required|string|max:20|unique:patients',
            'address'        => 'required|string|max:255',
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|in:M,F',
            'password'       => 'required|string|min:8|confirmed',
        ]);

        // 2️⃣ Download their Google avatar
        $response = Http::get($g['avatar_url'] . '?sz=300');
        $filename = Str::random(40) . '.jpg';
        $folder   = 'patient_images';

        Storage::disk('public')->put("$folder/$filename", $response->body());

        // 3️⃣ Create the patient, including the image path
        $patient = Patient::create([
            'google_id'     => $g['google_id'],
            'email'         => $g['email'],
            'first_name'    => $g['first_name'],
            'last_name'     => $g['last_name'],
            'phone_number'  => $data['phone_number'],
            'address'       => $data['address'],
            'date_of_birth' => $data['date_of_birth'],
            'gender'        => $data['gender'],
            'password'      => bcrypt($data['password']),
            'image'         => "$folder/$filename",
        ]);

        // 4️⃣ Clean up and log them in
        session()->forget('google_user');
        Auth::guard('patient')->login($patient);

        return redirect()->route('patient.show', $patient)
            ->with('success', 'Welcome aboard!');
    }
}
