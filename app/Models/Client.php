<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use HasFactory ,LogsActivity, Notifiable;

    protected $table = 'clients';

    protected $fillable = [
        'id',
        'nama_depan',
        'nama_belakang',
        'email',
        'phone_number',
        'nomor_induk_kependudukan',
        'alamat_lengkap',
        'negara',
        'kota_kabupaten',
        'kode_pos'
    ];

    protected static $logAttributes = ['nama_depan', 'nama_belakang', 'phone_number', 'email'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(static::$logAttributes);
    }


}

