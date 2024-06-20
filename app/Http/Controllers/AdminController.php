<?php

namespace App\Http\Controllers;

use App\Mail\NewUserWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $users = User::where('status', 'request')->get();

    //     // Check if 'id' parameter exists in the request
    //     if ($request->has('id')) {
    //         $notificationId = $request->id;

    //         // Find the notification by id in unread notifications of the authenticated user
    //         $notification = Auth::user()->unreadNotifications
    //             ->where('id', $notificationId)
    //             ->first();

    //         // If notification found, mark it as read
    //         if ($notification) {
    //             $notification->markAsRead();
    //             // Redirect back to the same route after marking as read
    //             return redirect()->route('admin.list-pendaftar');
    //         }
    //     }

    //     return view('admin.list-pendaftar', compact('users'));
    // }
    public function index(Request $request)
    {
        // Mengambil data user dengan status 'request' dan menggunakan paginasi dengan 10 item per halaman
        $users = User::where('status', 'request')->paginate(10);

        // Check jika ada parameter 'id' dalam request untuk menandai notifikasi sebagai sudah dibaca
        if ($request->has('id')) {
            $notificationId = $request->id;

            // Cari notifikasi berdasarkan id dalam notifikasi yang belum dibaca oleh user yang terautentikasi
            $notification = Auth::user()->unreadNotifications
                ->where('id', $notificationId)
                ->first();

            // Jika notifikasi ditemukan, tandai sebagai sudah dibaca
            if ($notification) {
                $notification->markAsRead();
                // Redirect kembali ke route yang sama setelah menandai sebagai sudah dibaca
                return redirect()->route('admin.list-pendaftar');
            }
        }

        // Mengirim data users ke view 'admin.list-pendaftar' dengan menggunakan paginasi
        return view('admin.list-pendaftar', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function store($id)
    {
        $user = User::findOrFail($id);

        // Update the user's status
        $user->update(['status' => 'accepted']);

        $defaultPassword = 'password123';

        Mail::to($user->email)->send(new NewUserWelcomeMail($user, $defaultPassword));

        Alert::success('Sukses', 'Status berhasil dirubah dan email telah dikirim.');
        return redirect()->route('admin.list-pendaftar');
    }

    /**
     * Store a newly created resource in storage.
     */


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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
