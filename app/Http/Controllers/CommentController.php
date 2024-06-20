<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\LegalCase;
use App\Models\User;
use App\Notifications\CommentAddedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    // public function store(Request $request, $id)
    // {
    //     $request->validate([
    //         'content' => 'required',
    //     ]);

    //     Comment::create([
    //         'content' => $request->content,
    //         'case_id' => $id,
    //         'user_id' => Auth::id(),
    //     ]);

    //     Alert::success('Sukses!', 'Komentar anda berhasil ditambahkan.');
    //     return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    // }

    public function store(Request $request, $id)
{
    $request->validate([
        'content' => 'required',
    ]);

    $user = Auth::user();

    // Find the related legal case
    $legalCase = LegalCase::find($id);

    if (!$legalCase) {
        return redirect()->back()->with('error', 'Kasus tidak ditemukan.');
    }

    // Create a new comment
    $comment = new Comment();
    $comment->content = $request->content;
    $comment->case_id = $id; // Ensure case_id is set correctly
    $comment->user_id = $user->id;
    $comment->save();

    // Notify users about the new comment
    $usersToNotify = User::whereIn('role_id', function ($query) {
        $query->select('id')
            ->from('roles')
            ->whereIn('role_name', ['Admin', 'Master']);
    })
    ->orWhere(function ($query) use ($legalCase) {
        $query->whereIn('id', [
            $legalCase->leader_id,
            $legalCase->member2_id,
            $legalCase->member3_id,
            $legalCase->member4_id,
            $legalCase->member5_id,
        ]);
    })
    ->get();

    foreach ($usersToNotify as $userToNotify) {
        $userToNotify->notify(new CommentAddedNotification($comment, $user, $legalCase));
    }

    return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
