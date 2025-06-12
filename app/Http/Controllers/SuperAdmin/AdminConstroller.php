<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminConstroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();
        return view('superAdmin.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superAdmin.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email|unique:patients,email|unique:doctors,email',
            'password' => 'required|confirmed|min:8|string'
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $admin = new Admin();
        $admin->first_name = $validated['first_name'];
        $admin->last_name = $validated['last_name'];
        $admin->email = $validated['email'];
        $admin->password = $validated['password'];

        $admin->save();
        return redirect()->route('superadmin.admin.index')->with('success', 'Created Admin Successfully');
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
    public function edit(Admin $admin)
    {
        return view('superAdmin.admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'first_name' => "required|string|max:250",
            'last_name' => "required|string|max:250",
            'email' => 'required|email|max:150|unique:patients,email|unique:secretaries,email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:8|string|confirmed'
        ]);
        if (isset($validated)) {
            $admin->password = Hash::make($validated['password']);
            $admin->save();
        }
        $admin->update(Arr::except($validated, ['password']));

        return redirect()->route('superadmin.admin.index')->with('success', 'Updated Admin Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return back()->with('success', 'Deleted Admin Successfully');
    }
}
