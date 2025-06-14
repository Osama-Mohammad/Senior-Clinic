<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Secretary;
use Illuminate\Http\Request;
use Illuminate\Support\Composer;
use App\Http\Controllers\Controller;
use Illuminate\Console\View\Components\Secret;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SecretaryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Admin $admin)
    {
        $this->authorize('view', $admin);
        $secretaries = Secretary::all();
        return view('admin.secretaries.index', compact("secretaries"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $secretary->delete();
        return back()->with('success', 'deleted secretary successfully');
    }
}
