<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserRegistrationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showRegistrationForm()
    {

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nomor_induk_anggota' => 'required|string|max:25|unique:users',
        ], [
            'nama_depan.required' => 'Nama depan wajib diisi.',
            'nama_depan.string' => 'Nama depan harus berupa teks.',
            'nama_depan.max' => 'Nama depan tidak boleh lebih dari 255 karakter.',
            'nama_belakang.required' => 'Nama belakang wajib diisi.',
            'nama_belakang.string' => 'Nama belakang harus berupa teks.',
            'nama_belakang.max' => 'Nama belakang tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'nomor_induk_anggota.required' => 'Nomor induk anggota wajib diisi.',
            'nomor_induk_anggota.string' => 'Nomor induk anggota harus berupa teks.',
            'nomor_induk_anggota.max' => 'Nomor induk anggota tidak boleh lebih dari 25 karakter.',
            'nomor_induk_anggota.unique' => 'Nomor induk anggota sudah terdaftar.',
        ]);

        $defaultPassword = 'password123';

        DB::beginTransaction();
        try {
            $userRegist = User::create([
                'id' => User::generateUniqueId(),
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email' => $request->email,
                'nomor_induk_anggota' => $request->nomor_induk_anggota,
                'password' => bcrypt($defaultPassword),
            ]);

            // Send notification to admins or master users
            $userIsAdminOrMaster = User::whereIn('role_id', [1, 2])->get();
            Notification::send($userIsAdminOrMaster, new UserRegistrationNotification($userRegist));

            // Log the activity
            activity()
                ->causedBy($userRegist) // Set the causer_id
                ->performedOn($userRegist) // Set the subject_id and subject_type
                ->withProperties(['action' => 'user_registered']) // Example properties
                ->log('User registered');

            DB::commit();

            Alert::success('Sukses', 'Registrasi berhasil, menunggu persetujuan admin.');
            return redirect()->route('login');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Registrasi Gagal', $th->getMessage());
            return back();
        }
    }
}
