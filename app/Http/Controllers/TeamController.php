<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter');

        // Base query to get the teams
        $query = LegalCase::query()->whereNotNull('team_id');

        // Apply filter based on the status of the legal case
        if ($filter === 'selesai') {
            $query->where('status', 'Selesai');
        } elseif ($filter === 'belum_selesai') {
            $query->where('status', 'Proses');
        } elseif ($filter) {
            $query->where('title', 'like', "%$filter%");
        }

        // If user is not admin or master, restrict team visibility
        if (!in_array($user->role->role_name, ['Admin', 'Master'])) {
            // Filter teams where the user is a member
            $query->whereHas('team', function ($q) use ($user) {
                $q->where('leader_id', $user->id)
                  ->orWhere('member2_id', $user->id)
                  ->orWhere('member3_id', $user->id)
                  ->orWhere('member4_id', $user->id)
                  ->orWhere('member5_id', $user->id);
            });
        }

        // Execute the query and get the paginated results
        $teams = $query->paginate(10);

        // Load members with the query
        $cases = $query->with(['team.member2', 'team.member3', 'team.member4', 'team.member5'])->get();

        // Count all teams related to the user, without filtering
        $teamCount = Team::where(function ($query) use ($user) {
            $query->where('leader_id', $user->id)
                ->orWhere('member2_id', $user->id)
                ->orWhere('member3_id', $user->id)
                ->orWhere('member4_id', $user->id)
                ->orWhere('member5_id', $user->id);
        })->count();

        $users = User::all();

        return view('team', compact('teams', 'user', 'users', 'cases', 'teamCount', 'filter'));
    }


    public function searchTeam(Request $request)
    {
        $user = Auth::user();
        $query = $request->search;

        // Query for searching based on case title
        $teams = Team::join('legal_cases', 'teams.case_id', '=', 'legal_cases.id')
            ->where('legal_cases.title', 'like', '%' . $query . '%')
            ->select('teams.*') // Pilih kolom-kolom dari tabel teams
            ->with(['legalCase', 'creator']) // Load relasi legalCase dan creator
            ->orderBy('legal_cases.title') // Urutkan berdasarkan judul kasus
            ->paginate(10) // Paginasi hasil pencarian
            ->withQueryString(); // Pertahankan parameter pencarian dalam query string

        // Hitung jumlah tim yang terkait dengan pengguna yang telah diautentikasi
        $teamCount = Team::where('leader_id', $user->id)
            ->orWhere('member2_id', $user->id)
            ->orWhere('member3_id', $user->id)
            ->orWhere('member4_id', $user->id)
            ->orWhere('member5_id', $user->id)
            ->count();

        return view('team', compact('teams', 'user', 'teamCount', 'query'));
    }

    public function getUserNames()
    {
        $cases = LegalCase::all();
        $users = User::all();
        return view('admin.create-team', compact('cases', 'users'));
    }


    public function createTeam(Request $request, Team $team)
    {

        $request->validate([
            'kasus' => 'required|string',
            'ketua_team' => 'required|string',
            'anggota2' => 'required|string',
            'anggota3' => 'required|string',
            'anggota4' => 'nullable|string',
            'anggota5' => 'nullable|string',
        ]);

        $newTeam = Team::create([
            'case_id' => $request->input('kasus'),
            'leader_id' => $request->input('ketua_team'),
            'member2_id' => $request->input('anggota2'),
            'member3_id' => $request->input('anggota3'),
            'member4_id' => $request->input('anggota4'),
            'member5_id' => $request->input('anggota5'),
            'created_by' => Auth::id(),
            'created_at' => now(),
        ]);

        $legalCase = LegalCase::find($request->input('kasus'));

        if ($legalCase) {
            // Update the legal case with the team ID
            $legalCase->update(['team_id' => $newTeam->id]);

            Alert::success('Sukses', 'Team telah dibuat');
            return redirect()->route('team.index');
        } else {

            return redirect()->back()->with('error', 'Legal case not found');
        }
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
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        // Fetch users and cases for dropdowns
        $users = User::all();
        $cases = LegalCase::all();


        return view('admin.edit-team', compact('team', 'users', 'cases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'kasus' => 'required|string',
            'ketua_team' => 'required|string',
            'anggota2' => 'required|string',
            'anggota3' => 'required|string',
            'anggota4' => 'nullable|string',
            'anggota5' => 'nullable|string',
        ]);



        // Update team data
        $team->case_id = $request->input('kasus');
        $team->leader_id = $request->input('ketua_team');
        $team->member2_id = $request->input('anggota2');
        $team->member3_id = $request->input('anggota3');
        $team->member4_id = $request->input('anggota4');
        $team->member5_id = $request->input('anggota5');
        $team->save();

        Alert::success('Success', 'Team updated successfully');
        return redirect()->route('team.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
