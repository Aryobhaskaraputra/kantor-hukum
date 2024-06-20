<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\LegalCaseCategory;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $cases = LegalCase::with('client')
            ->where('status', 'Proses')
            ->orderByDesc('created_at')
            ->take(2)
            ->get();
        $categories = LegalCaseCategory::all();

        $ongoingCase = $this->ongoingCases();
        $completedCasesCount = $this->completedCasesCount();

        $team = Team::all();
        return view('home', compact('cases', 'categories', 'team', 'ongoingCase', 'completedCasesCount'));
    }

    public function ongoingCases()
    {
        // Ambil user saat ini yang sedang login
        $user = Auth::user();

        // Ambil semua tim yang terkait dengan user saat ini
        $teams = Team::where(function ($query) use ($user) {
            $query->where('leader_id', $user->id)
                ->orWhere('member2_id', $user->id)
                ->orWhere('member3_id', $user->id)
                ->orWhere('member4_id', $user->id)
                ->orWhere('member5_id', $user->id);
        })
            ->get();

        // Ambil case_id dari setiap tim yang user tersebut terdaftar
        $caseIds = $teams->pluck('case_id')->toArray();

        // Ambil kasus yang memiliki status "Proses" dan terkait dengan case_id dari tim user
        $ongoingCase = LegalCase::with('client')
            ->whereIn('id', $caseIds)
            ->where('status', 'Proses')
            ->orderByDesc('created_at')
            ->take(2)
            ->get();

        return $ongoingCase;
    }

    public function completedCasesCount()
    {
        // Ambil user saat ini yang sedang login
        $user = Auth::user();

        // Ambil semua tim yang terkait dengan user saat ini
        $teams = Team::where(function ($query) use ($user) {
            $query->where('leader_id', $user->id)
                ->orWhere('member2_id', $user->id)
                ->orWhere('member3_id', $user->id)
                ->orWhere('member4_id', $user->id)
                ->orWhere('member5_id', $user->id);
        })
            ->get();

        // Ambil case_id dari setiap tim yang user tersebut terdaftar
        $caseIds = $teams->pluck('case_id')->toArray();

        // Ambil jumlah kasus yang telah selesai (misalnya berdasarkan status 'Selesai')
        $completedCasesCount = LegalCase::whereIn('id', $caseIds)
            ->where('status', 'Selesai')
            ->count();

        return ['count' => $completedCasesCount]; // Returning as an array
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
