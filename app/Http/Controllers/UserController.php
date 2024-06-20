<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function userManagementIndex(Request $request)
    {

        $filter = $request->query('filter');


        $query = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.role_name');


        if ($filter) {
            $query->where('roles.role_name', $filter);
        }

        $users = $query->get();

        return view('master.user-management', compact('users'));
    }

    public function searchUsers(Request $request)
    {
        $query = $request->search;

        $users = User::query()
            ->where('nama_depan', 'like', '%' . $query . '%')
            ->orWhere('nama_belakang', 'like', '%' . $query . '%')
            ->orWhere('id', $query)
            ->orWhere('email', 'like', '%' . $query . '%')
            ->orWhereHas('role', function ($q) use ($query) {
                $q->where('role_name', 'like', '%' . $query . '%');
            })
            ->get();

        return view('master.user-management', compact('users', 'query'));
    }

    public function show($id)
    {
        // Fetch the user by their ID
        $user = User::findOrFail($id);
        $roles = Role::all();

        // Return a view to show the user's profile
        return view('master.profile-master', compact('user', 'roles'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('master.edit-profile-master', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_depan' => 'nullable|string|max:255',
            'nama_belakang' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:20',
            'nomor_induk_anggota' => 'nullable|string|max:255',
            'nomor_induk_kependudukan' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'negara' => 'nullable|string|max:255',
            'kota_kabupaten' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:20',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->nama_depan = $request->nama_depan;
        $user->nama_belakang = $request->nama_belakang;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->nomor_induk_anggota = $request->nomor_induk_anggota;
        $user->nomor_induk_kependudukan = $request->nomor_induk_kependudukan;
        $user->alamat_lengkap = $request->alamat_lengkap;
        $user->negara = $request->negara;
        $user->kota_kabupaten = $request->kota_kabupaten;
        $user->kode_pos = $request->kode_pos;
        $user->role_id = $request->role_id;
        $user->save();

        // Redirect back with success message
        Alert::success('Success', 'Profil pengguna berhasil diperbarui!');
        return redirect()->route('master.user.profile', $id);
    }
}
