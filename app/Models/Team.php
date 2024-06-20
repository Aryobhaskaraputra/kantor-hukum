<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'case_id',
        'leader_id',
        'member2_id',
        'member3_id',
        'member4_id',
        'member5_id',
        'created_by',
    ];

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function member2()
    {
        return $this->belongsTo(User::class, 'member2_id');
    }

    public function member3()
    {
        return $this->belongsTo(User::class, 'member3_id');
    }

    public function member4()
    {
        return $this->belongsTo(User::class, 'member4_id');
    }

    public function member5()
    {
        return $this->belongsTo(User::class, 'member5_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function member($position)
    {
        return $this->belongsTo(User::class, $position);
    }
}
