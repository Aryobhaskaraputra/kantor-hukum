<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;;

use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        $roles = Role::all();
        return view('profile', compact('user', 'roles'));
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
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('edit-profile', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
            'nama_depan' => 'nullable|string|max:255',
            'nama_belakang' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone_number' => 'nullable|string|max:15',
            'nomor_induk_anggota' => 'nullable|string|max:20',
            'nomor_induk_kependudukan' => 'nullable|string|max:20',
            'alamat_lengkap' => 'nullable|string|max:255',
            'negara' => 'nullable|string|max:255',
            'kota_kabupaten' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
        ]);

        $data = $request->only([
            'nama_depan',
            'nama_belakang',
            'email',
            'phone_number',
            'nomor_induk_anggota',
            'nomor_induk_kependudukan',
            'alamat_lengkap',
            'negara',
            'kota_kabupaten',
            'kode_pos'
        ]);


        $user = User::find($id);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            $profilePhotoPath = $profilePhoto->store('profile_photos', 'public');
            $data['profile_photo_url'] = $profilePhotoPath;

            // Optionally, delete the old photo if it exists
            if ($user->profile_photo_url) {
                Storage::disk('public')->delete($user->profile_photo_url);
            }
        } else {
            Log::info('No profile photo uploaded.');
        }

        // Remove null values from the data array
        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });

        // Check if there is at least one field to update
        if (!empty($data)) {
            DB::table('users')->where('id', $id)->update($data);
            Alert::success('Berhasil', 'Profil berhasil diperbarui');
        } else {
            Alert::info('Tidak ada perubahan', 'Tidak ada perubahan yang dilakukan pada profil');
        }

        return redirect()->route('profile.index', ['id' => Auth::user()->id]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
