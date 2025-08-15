<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'subject',
        'text',
        'read',
        'labels',
    ];

    protected $casts = [
        'labels' => 'array',
        'read' => 'boolean',
        'created_at' => 'datetime:Y-m-d\TH:i:s',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
