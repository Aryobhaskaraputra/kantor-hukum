<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\LegalCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cases = LegalCase::all();

        return view('form-dokumen', compact('cases'));
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
        // Validasi input
        $request->validate([
            'file_name' => 'required|string|max:255',
            'kasusDropdown' => 'required|exists:legal_cases,id',
            'document' => 'required|file|max:2048',
        ]);

        $legalCase = LegalCase::findOrFail($request->kasusDropdown);
        $user = Auth::user();

        // Periksa apakah pengguna merupakan anggota tim yang terkait dengan kasus menggunakan query
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

        // Periksa apakah pengguna adalah Admin atau Master
        $isAdminOrMaster = in_array($user->role->role_name, ['Admin', 'Master']);

        // Jika pengguna bukan anggota tim dan bukan Admin/Master, kembalikan pesan error
        if (!$isTeamMember && !$isAdminOrMaster) {
            Alert::error('Gagal!', 'Anda tidak memiliki izin untuk mengunggah file untuk kasus ini.')->persistent(true);
            return redirect()->back()->withInput();
        }

        try {
            $file = $request->file('document');
            $fileName = $request->file_name; // Menggunakan nama file yang diinput pengguna
            $fileExtension = $file->getClientOriginalExtension();

            // Validasi ekstensi file
            if (!in_array($fileExtension, ['pdf', 'png', 'docx'])) {
                Alert::error('Gagal!', 'File harus berupa PDF, PNG, DOCX.')->persistent(true);
                return redirect()->back()->withInput();
            }

            // Simpan file ke storage
            $filePath = $request->file('document')->store('documents', 'public');

            // Simpan informasi file ke database
            $uploadedFile = File::create([
                'file_name' => $fileName,
                'file_path' => $filePath,
                'case_id' => $request->kasusDropdown,
                'uploaded_by' => auth()->id(),
                'file_extension' => $fileExtension,
            ]);

            // Catat log aktivitas
            activity()
                ->causedBy($user)
                ->performedOn($uploadedFile)
                ->withProperties(['file_name' => $fileName, 'case_id' => $request->kasusDropdown])
                ->log('Mengunggah dokumen ' . $uploadedFile->file_name);

            // Redirect dengan pesan sukses
            Alert::success('Sukses!', 'Dokumen berhasil di-upload');
            return redirect()->route('kasus.show', $request->kasusDropdown);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($case_id)
    {
        $files = File::where('case_id', $case_id)->get();

        // Kirim data ke view
        return view('detail-kasus', compact('files'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $file = File::find($id);
        if (!$file) {
            return redirect()->back()->with('error', 'Dokumen tidak dapat ditemukan.');
        }
        $case = LegalCase::find($file->case_id);

        $user = Auth::user();

        // Query untuk memeriksa role dari akun yang sedang login
        $userRole = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $user->id)
            ->select('roles.role_name')
            ->first();

        // Query untuk memeriksa apakah pengguna merupakan anggota tim dari kasus terkait
        $isTeamMember = DB::table('teams')
            ->where('case_id', $file->case_id)
            ->where(function ($query) use ($user) {
                $query->where('leader_id', $user->id)
                    ->orWhere('member2_id', $user->id)
                    ->orWhere('member3_id', $user->id)
                    ->orWhere('member4_id', $user->id)
                    ->orWhere('member5_id', $user->id);
            })
            ->exists();

        // Memeriksa apakah pengguna adalah Admin atau Master
        $isAdminOrMaster = in_array($userRole->role_name, ['Admin', 'Master']);

        // Jika pengguna bukan anggota tim dan bukan Admin/Master, kembalikan pesan error
        if (!$isTeamMember && !$isAdminOrMaster) {
            Alert::error('Gagal!', 'Anda tidak memiliki izin untuk mengedit dokumen ini.')->persistent(true);
            return redirect()->back();
        }

        // Kirim data file ke view untuk diedit
        return view('edit-dokumen', compact('file', 'case'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'file_name' => 'nullable|string|max:255',
            'case_id' => 'nullable|exists:legal_cases,id',
            'document' => 'nullable|file|max:2048|mimes:pdf,png,docx',
        ], [
            'file_name.max' => 'Nama dokumen tidak boleh lebih dari :max karakter.',
            'case_id.exists' => 'Kasus yang dipilih tidak valid.',
            'document.file' => 'Dokumen yang diunggah harus berupa file.',
            'document.max' => 'Ukuran dokumen tidak boleh lebih dari 2mb.',
            'document.mimes' => 'Dokumen harus dalam format PDF, PNG, atau DOCX.',
        ]);

        $file = File::find($id);

        if (!$file) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        $user = Auth::user();

        // Query untuk memeriksa role dari akun yang sedang login
        $userRole = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $user->id)
            ->select('roles.role_name')
            ->first();

        // Query untuk memeriksa apakah pengguna merupakan anggota tim dari kasus terkait
        $isTeamMember = DB::table('teams')
            ->where('case_id', $file->case_id)
            ->where(function ($query) use ($user) {
                $query->where('leader_id', $user->id)
                    ->orWhere('member2_id', $user->id)
                    ->orWhere('member3_id', $user->id)
                    ->orWhere('member4_id', $user->id)
                    ->orWhere('member5_id', $user->id);
            })
            ->exists();

        // Memeriksa apakah pengguna adalah Admin atau Master
        $isAdminOrMaster = in_array($userRole->role_name, ['Admin', 'Master']);

        // Jika pengguna bukan anggota tim dan bukan Admin/Master, kembalikan pesan error
        if (!$isTeamMember && !$isAdminOrMaster) {
            Alert::error('Gagal!', 'Anda tidak memiliki izin untuk mengedit dokumen ini.')->persistent(true);
            return redirect()->back();
        }

        // Update informasi file sesuai input yang diberikan
        $oldFileName = $file->file_name;
        $oldFilePath = $file->file_path;
        $oldFileExtension = $file->file_extension;

        if ($request->filled('file_name')) {
            $file->file_name = $request->file_name;
        }

        if ($request->filled('case_id')) {
            $file->case_id = $request->case_id;
        }

        // Jika ada file dokumen baru diunggah, simpan dan hapus file lama
        if ($request->hasFile('document')) {
            // Hapus file lama
            Storage::disk('public')->delete($file->file_path);

            // Simpan file baru
            $fileExtension = $request->file('document')->getClientOriginalExtension();
            $filePath = $request->file('document')->store('documents', 'public');
            $file->file_path = $filePath;
            $file->file_extension = $fileExtension;
        }

        // Simpan perubahan
        $file->save();

        // Catat log aktivitas
        activity()
            ->causedBy($user)
            ->performedOn($file)
            ->withProperties([

                'case_id' => $file->case_id,
                'file_name' => $file->file_name,
                'file_path' => $file->file_path,
                'file_extension' => $file->file_extension,
            ])
            ->log('Melakukan perubahan pada dokumen ' . $file->file_name);

        // Redirect dengan pesan sukses
        Alert::success('Sukses!', 'Dokumen berhasil diperbarui.');
        return redirect()->route('kasus.show', $file->case_id);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        // Query untuk memeriksa role dari akun yang sedang login
        // $userRole = auth()->user()->role_name;

        $userRole = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', Auth::id())
            ->select('roles.role_name')
            ->first();

        // Memeriksa apakah peran pengguna adalah 'Admin' atau 'Master'
        if ($userRole->role_name !== 'Admin' && $userRole->role_name !== 'Master') {
            return redirect()->back()->with('error', 'Anda tidak mendapat izin akses ke halaman ini.');
        }

        // Ambil informasi file sebelum dihapus untuk keperluan log
        $oldFileName = $file->file_name;
        $oldFilePath = $file->file_path;
        $oldFileExtension = $file->file_extension;
        $oldCaseId = $file->case_id;

        // Hapus file
        $file->delete();
        $user = auth()->user();
        // Catat log aktivitas
        activity()
            ->causedBy($user)
            ->performedOn($file)
            ->withProperties([
                'file_name' => $oldFileName,
                'file_path' => $oldFilePath,
                'file_extension' => $oldFileExtension,
                'case_id' => $oldCaseId,
            ])
            ->log('Menghapus dokumen ' . $file->file_name);

        return redirect()->back()->with('berhasil', 'Dokumen berhasil dihapus.');
    }
}
