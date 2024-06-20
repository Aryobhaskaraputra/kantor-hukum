<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            session(['user' => $user]);

            return redirect()->route('dashboard')->with('toast_success', 'Login Berhasil!');
        }

        // Check if the user exists
        $user = User::where('email', $request->email)->first();
        if ($user) {
            // User exists, so the password is incorrect
            $error = 'Password yang Anda masukkan salah!';
        } else {
            // User does not exist
            $error = 'Email yang Anda masukkan tidak terdaftar!';
        }

        return redirect()->back()->with('error', $error)->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('toast_success', 'Berhasil Keluar!');
    }
}
