<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\File;
use App\Models\User;
use App\Models\LegalCase;
use App\Models\LegalCaseCategory;
use App\Notifications\CaseLogNotification;
use App\Notifications\CaseCloseNotification;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class LegalCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Mengatur query awal tanpa filter
        $query = LegalCase::with('team.leader', 'team.member2', 'team.member3', 'team.member4', 'team.member5')
            ->orderByDesc('created_at');

        // fitur filter
        if ($request->has('filter')) {
            if ($request->filter == 'selesai') {
                $query->where('status', 'Selesai');
            } elseif ($request->filter == 'belum_selesai') {
                $query->where('status', '!=', 'Selesai');
            }
        }

        $cases = $query->get();
        $categories = LegalCaseCategory::all();

        return view('kasus', compact('cases', 'categories', 'user'));
    }


    public function searchLegalCases(Request $request)
    {
        $query = $request->search;

        // Query untuk mencari berdasarkan judul kasus atau nama kategori
        $cases = LegalCase::join('legal_case_categories', 'legal_cases.category_id', '=', 'legal_case_categories.id')
            ->where('legal_cases.title', 'like', '%' . $query . '%')
            ->orWhere('legal_case_categories.case_categories_name', 'like', '%' . $query . '%')
            ->select('legal_cases.*')
            ->orderBy('legal_cases.title')
            ->paginate(10)
            ->withQueryString();

        $categories = LegalCaseCategory::all();

        return view('kasus', compact('cases', 'query', 'categories'));
    }


    /**
     * Show the form for creating a new resource.
     */


    public function create()
    {

        $categories = LegalCaseCategory::all();

        // Kemudian, kirim data kategori kasus ke view
        return view('admin.tambah-kasus', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judulKasus' => 'required|string|max:255',
            'kategoriKasus' => 'required|integer',
            'deskripsiKasus' => 'required|string',
            'namaDepan' => 'required|string|max:255',
            'namaBelakang' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'phone' => 'required|string|max:15',
            'nik' => 'required|string|max:20|unique:clients,nomor_induk_kependudukan',
            'alamat' => 'required|string',
            'negara' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kodePos' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        DB::beginTransaction();

        try {
            // Simpan data ke tabel Client terlebih dahulu
            $client = Client::create([
                'nama_depan' => $request->namaDepan,
                'nama_belakang' => $request->namaBelakang,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'nomor_induk_kependudukan' => $request->nik,
                'alamat_lengkap' => $request->alamat,
                'negara' => $request->negara,
                'kota_kabupaten' => $request->kota,
                'kode_pos' => $request->kodePos,
            ]);

            // Simpan data ke tabel LegalCase
            $legalCase = LegalCase::create([
                'id' => (string) Str::uuid(),
                'title' => $request->judulKasus,
                'category_id' => $request->kategoriKasus,
                'description' => $request->deskripsiKasus,
                'client_id' => $client->id,
            ]);

            // Catat log aktivitas
            $user = auth()->user();


            // Kirim notifikasi perubahan log (created) kepada admin atau master
            $usersToNotify = User::all();
            Notification::send($usersToNotify, new CaseLogNotification($user, $legalCase));

            DB::commit();

            Alert::success('Sukses', 'Kasus Berhasil ditambahkan!');
            return redirect()->route('kasus.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Gagal menambahkan kasus: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(LegalCase $legalCase)
    {
        // Ambil data kasus berdasarkan ID yang diberikan
        $legalCase = LegalCase::with('client')->findOrFail($legalCase->id);
        $notificationId = request('id');

        if ($notificationId) {
            $unreadNotifications = auth()->user()->unreadNotifications;
            if ($unreadNotifications) {
                $notification = $unreadNotifications->where('id', $notificationId)->first();
                if ($notification) {
                    $notification->markAsRead();
                }
            }
        }

        // Ambil activity logs untuk LegalCase
        $activityLogsLegalCase = Activity::where('subject_id', $legalCase->id)
            ->where('subject_type', LegalCase::class)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil activity logs untuk Client
        $activityLogsClient = Activity::where('subject_id', $legalCase->client->id)
            ->where('subject_type', Client::class)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil activity logs untuk Files
        // $fileIds = $legalCase->files_with_trashed->pluck('id');
        // dd($fileIds);

        $activityLogsFiles = Activity::where('properties->case_id', $legalCase->id)
            ->where('subject_type', File::class)
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($activityLogsFiles);


        // Gabungkan semua log menjadi satu array
        $activityLogs = $activityLogsLegalCase->merge($activityLogsClient)->merge($activityLogsFiles)->sortByDesc('created_at');;

        // Kemudian, kirim data kasus ke view 'detail-kasus' bersama dengan activityLogs
        return view('detail-kasus', compact('legalCase', 'activityLogs'));
    }

    public function tutupKasus(LegalCase $legalCase)
    {
        //cek role user
        if (
            Auth::check() && (Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Master')
            && $legalCase->status == 'Proses'
        ) {

            // Update status kasus
            $legalCase->update(['status' => 'Selesai']);

            // Catat log aktivitas
            $user = auth()->user();
            activity()
                ->causedBy($user)
                ->performedOn($legalCase)
                ->withProperties(['status' => 'Selesai'])
                ->log('Telah menutup kasus ini');

            // Kirim notifikasi
            $usersToNotify = User::all(); // Sesuaikan dengan user yang perlu dinotifikasi
            Notification::send($usersToNotify, new CaseCloseNotification($user, $legalCase));

            return redirect()->back()->with('success', 'Kasus berhasil ditutup.');
        }

        return redirect()->back()->with('error', 'Tidak dapat menutup kasus.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function editDeskripsiKasus($id)
    {
        $legalCase = DB::table('legal_cases')->where('id', $id)->first();
        $user = Auth::user();

        if (!$legalCase) {
            return redirect()->route('kasus.index')->with('error', 'Kasus tidak ditemukan.');
        }

        $userRole = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $user->id)
            ->select('roles.role_name')
            ->first();

        // Query untuk memeriksa apakah user merupakan anggota tim dari kasus terkait
        $isTeamMember = DB::table('teams')
            ->where('case_id', $legalCase->id)
            ->where(function ($query) use ($user) {
                $query->where('leader_id', $user->id)
                    ->orWhere('member2_id', $user->id)
                    ->orWhere('member3_id', $user->id)
                    ->orWhere('member4_id', $user->id)
                    ->orWhere('member5_id', $user->id);
            })
            ->exists();

        $isAdminOrMaster = in_array($userRole->role_name, ['Admin', 'Master']);
        if (!$isTeamMember && !$isAdminOrMaster) {
            return redirect()->route('kasus.show', $legalCase->id)->with('error', 'Anda tidak memiliki izin untuk mengedit kasus.');
        }

        // Mengarahkan ke halaman edit dengan data kasus
        return view('edit-kasus', compact('legalCase'));
    }

    public function updateDeskripsiKasus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'progress_tahapan' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            $legalCase = LegalCase::findOrFail($id);

            // Simpan data yang diubah
            $oldProgress = $legalCase->progress_tahapan;
            $oldDescription = $legalCase->description;

            // Nonaktifkan logging otomatis sementara
            $legalCase->disableLogging();

            $legalCase->progress_tahapan = $request->input('progress_tahapan', 'progress tahapan belum diisi');
            $legalCase->description = $request->description;
            $legalCase->save();

            // Aktifkan kembali logging otomatis
            $legalCase->enableLogging();

            $user = auth()->user();

            // Catat log aktivitas custom
            activity()
                ->causedBy($user)
                ->performedOn($legalCase)
                ->withProperties([
                    'progress_tahapan_lama' => $oldProgress,
                    'progress_tahapan_baru' => $legalCase->progress_tahapan,
                    'deskripsi_lama' => $oldDescription,
                    'deskripsi_baru' => $legalCase->description,
                ])
                ->log('Merubah deskripsi kasus ');

            Alert::success('Selamat!', 'Deskripsi Kasus Berhasil diperbarui!');
            return redirect()->route('kasus.show', $legalCase->id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kasus: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LegalCase $legalCase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LegalCase $legalCase)
    {
        //
    }
}
