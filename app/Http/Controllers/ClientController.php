<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\LegalCase;
use App\Models\User;
use App\Notifications\ChangeClientDataNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, $client_id)
    {
        // Temukan data kasus hukum berdasarkan ID
        $legalCase = LegalCase::findOrFail($id);

        // Temukan data klien berdasarkan ID
        $client = Client::findOrFail($client_id);

        // Kembalikan view dengan data kasus hukum dan klien
        return view('detail-klien', compact('legalCase', 'client'));
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
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($legal_case_id, $client_id)
    {
        $legalCase = LegalCase::findOrFail($legal_case_id);
        $client = Client::findOrFail($client_id);

        return view('edit-klien', compact('legalCase', 'client'));
    }



    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $user = Auth::user();

    //     // Fetch legal case
    //     $legalCase = LegalCase::find($id);

    //     // if (!$legalCase) {
    //     //     return redirect()->back()->with('error', 'Kasus tidak ditemukan.');
    //     // }

    //     $data = $request->validate([
    //         'nama_depan' => 'nullable|string|max:255',
    //         'nama_belakang' => 'nullable|string|max:255',
    //         'email' => 'nullable|string|email|max:255',
    //         'phone_number' => 'nullable|string|max:15',
    //         'nomor_induk_kependudukan' => 'nullable|string|max:20',
    //         'alamat_lengkap' => 'nullable|string|max:255',
    //         'negara' => 'nullable|string|max:255',
    //         'kota_kabupaten' => 'nullable|string|max:255',
    //         'kode_pos' => 'nullable|string|max:10',
    //     ]);


    //     $client = Client::findOrFail($id);

    //     if (!empty($data)) {
    //         try {
    //             // Update client data
    //             $client->update($data);

    //             // Log activity
    //             activity()
    //                 ->causedBy($user)
    //                 ->performedOn($client)
    //                 ->withProperties(['attributes' => $client->getAttributes()])
    //                 ->log('Updated client data.');

    //             // Determine users to notify based on case_id presence
    //             if ($legalCase->case_id) {
    //                 // Notify team members and admins/masters
    //                 $usersToNotify = User::whereIn('role_id', function ($query) {
    //                     $query->select('id')
    //                           ->from('roles')
    //                           ->whereIn('role_name', ['Admin', 'Master']);
    //                 })
    //                 ->orWhereIn('id', [
    //                     $legalCase->leader_id,
    //                     $legalCase->member2_id,
    //                     $legalCase->member3_id,
    //                     $legalCase->member4_id,
    //                     $legalCase->member5_id,
    //                 ])
    //                 ->get();
    //             } else {
    //                 // Notify only admins/masters
    //                 $usersToNotify = User::whereIn('role_id', function ($query) {
    //                     $query->select('id')
    //                           ->from('roles')
    //                           ->whereIn('role_name', ['Admin', 'Master']);
    //                 })
    //                 ->get();
    //             }

    //             // Send notification to each user in $usersToNotify array
    //             foreach ($usersToNotify as $userToNotify) {
    //                 Notification::send($userToNotify, new ChangeClientDataNotification($client, $legalCase));
    //             }

    //             Alert::success('Berhasil', 'Data Klien berhasil diperbarui');
    //             return redirect()->route('client.index', ['id' => $request->input('id'), 'client_id' => $client->id]);
    //         } catch (\Throwable $th) {
    //             return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data klien: ' . $th->getMessage());
    //         }
    //     } else {
    //         Alert::info('Tidak ada perubahan', 'Tidak ada perubahan yang dilakukan pada profil');
    //         return redirect()->route('client.index', ['id' => $request->input('id'), 'client_id' => $client->id]);
    //     }
    // }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_depan' => 'nullable|string|max:255',
            'nama_belakang' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone_number' => 'nullable|string|max:15',
            'nomor_induk_kependudukan' => 'nullable|string|max:20',
            'alamat_lengkap' => 'nullable|string|max:255',
            'negara' => 'nullable|string|max:255',
            'kota_kabupaten' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
        ]);

        $client = Client::findOrFail($id);
        if (!empty($data)) {
            try {
                // Perbarui data klien
                DB::table('clients')->where('id', $id)->update($data);

                $user = auth()->user();
                activity()
                    ->causedBy($user)
                    ->performedOn($client)
                    ->withProperties(['attributes' => $client->getAttributes()])
                    ->createdAt(now())
                    ->log('Merubah data klien.');

                Alert::success('Berhasil', 'Profile Klien berhasil diperbarui');
                return redirect()->route('client.index', ['id' => $request->input('id'), 'client_id' => $client->id]);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kasus: ' . $th->getMessage());
            }
        } else {
            Alert::info('Tidak ada perubahan', 'Tidak ada perubahan yang dilakukan pada profil');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
