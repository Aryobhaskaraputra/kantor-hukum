<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.ubah-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|string|min:8|confirmed',
        ], [
            'oldPassword.required' => 'Kata sandi lama harus diisi',
            'newPassword.required' => 'Kata sandi baru harus diisi',
            'newPassword.min' => 'Kata sandi baru minimal terdiri dari :min karakter',
            'newPassword.confirmed' => 'Konfirmasi kata sandi baru tidak cocok'
        ]);

        $user = Auth::user();

        // Check if the old password matches
        if (!Hash::check($request->oldPassword, $user->password)) {
            return redirect()->back()->withInput()->withErrors(['oldPassword' => 'Kata sandi lama tidak sesuai']);
        }

        // Update the user's password using raw SQL query
        $newPassword = Hash::make($request->newPassword);

        DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => $newPassword]);

        return redirect()->route('profile.index', ['id' => $user->id])
            ->with('toast_success', 'Kata sandi berhasil diubah');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $messages = [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
        ];

        $request->validate(['email' => 'required|email'], $messages);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => 'Link perubahan kata sandi sudah dikirim melalui email anda.']);
        } else {
            return back()->withErrors(['email' => 'Email yang anda masukan salah atau tidak terdaftar. Mohon periksa penulisan email kembali.']);
        }
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'token.required' => 'Token reset password diperlukan.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi baru harus diisi.',
            'password.min' => 'Kata sandi baru minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Kata sandi Anda telah diatur ulang!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
