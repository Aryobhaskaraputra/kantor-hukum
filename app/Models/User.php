<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    protected $fillable = [
        'id',
        'profile_photo_url',
        'nama_depan',
        'nama_belakang',
        'email',
        'phone_number',
        'nomor_induk_anggota',
        'nomor_induk_kependudukan',
        'alamat_lengkap',
        'negara',
        'kota_kabupaten',
        'kode_pos',
        'role_id',
        'password',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded();
        // Chain fluent methods for configuration options
    }

    public function team()
    {
        return $this->hasMany(Team::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function generateUniqueId()
    {
        do {
            $id = 'KH' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('id', $id)->exists());

        return $id;
    }

    public function isTeamMember(LegalCase $legalCase)
    {
        $caseId = $legalCase->id;
        $userId = $this->id;

        // Mengambil role_id pengguna
        $userRoleId = $this->role_id;

        // Cek apakah pengguna adalah anggota tim pada kasus tertentu
        $isTeamMember = Team::where('case_id', $caseId)
            ->where(function ($query) use ($userId) {
                $query->where('leader_id', $userId)
                    ->orWhere('member2_id', $userId)
                    ->orWhere('member3_id', $userId)
                    ->orWhere('member4_id', $userId)
                    ->orWhere('member5_id', $userId);
            })
            ->exists();

        // Jika pengguna adalah anggota tim, atau memiliki role_id 1 atau 2, kembalikan true
        if ($isTeamMember || $userRoleId == 1 || $userRoleId == 2) {
            return true;
        }

        return false;
    }

    /**
     * Change user's password.
     *
     * @param string $newPassword
     * @return void
     */
    public function changePassword(string $newPassword)
    {
        $this->password = Hash::make($newPassword);
        $this->save();
    }
}
