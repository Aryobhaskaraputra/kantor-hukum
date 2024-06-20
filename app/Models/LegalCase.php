<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LegalCase extends Model
{
    use HasFactory, LogsActivity, Notifiable;

    protected static function boot()
    {
        parent::boot();

        // Automatically generate a UUID for the id attribute
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // Set the primary key type to string
    protected $keyType = 'string';

    // Disable auto-incrementing since we're using UUIDs
    public $incrementing = false;

    protected $fillable = [
        'team_id',
        'title',
        'description',
        'category_id',
        'client_id',
        'status',
        'deleted_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnly(['team_id', 'title', 'description', 'category_id', 'client_id', 'status']);
    }

    public function category()
    {
        return $this->belongsTo(LegalCaseCategory::class, 'category_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function files()
    {
        return $this->hasMany(File::class, 'case_id');
    }

    public function files_with_trashed()
    {
        return $this->hasMany(File::class, 'case_id')->withTrashed();
    }


    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'case_id');
    }
}
