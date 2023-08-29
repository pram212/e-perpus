<?php

namespace App\Http\Controllers;

use App\Models\Setting\CompanyProfile;
use App\Http\Requests\StoreCompanyProfileRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = CompanyProfile::first();

        return Inertia::render('CompanyProfile/IndexCompanyProfile', compact('profile'));
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
    public function store(StoreCompanyProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyProfile $companyProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyProfile $companyProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyProfileRequest $request, CompanyProfile $companyProfile)
    {

        $logo_path = $companyProfile->logo_path;

        if ($request->file('logo_path')) {

            Storage::delete($companyProfile->logo_path);

            $extention = $request->file('logo_path')->extension();

            $path = $request->file('logo_path')->storeAs('/public/logo.' . $extention);

            $logo_path = Str::replace('public', 'storage', $path);
        }
        
        $companyProfile->update([
            'name' => $request->name,
            'address' => $request->address,
            'logo_path' => $logo_path,
        ]);

        $notification = [
            'type' => 'success',
            'message' => 'profil berhasil diubah'
        ];

        return Redirect::back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyProfile $companyProfile)
    {
        //
    }
}
