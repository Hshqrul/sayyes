<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $fillable = [
        'name',
        'attendence',
        'no_of_pax',
    ];

    /**
     * Get the RSVP's name.
     */
    public function getNameAttribute($value)
    {
        return $value ?: 'Anonymous';
    }

    /**
     * Scope a query to only include RSVPs that are attending.
     */
    public function scopeAttending($query)
    {
        return $query->where('attendence', true);
    }
}
