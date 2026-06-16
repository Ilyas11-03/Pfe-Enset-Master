<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'gym_id',
        'check_in',
        'check_out',
        'duration',
        'created_by',
        'updated_by',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessor for checking if the member is currently checked in
    public function getIsCheckedInAttribute()
    {
        return is_null($this->check_out);
    }

    // Mutator for setting the duration
    public function setDurationAttribute()
    {
        if ($this->check_in && $this->check_out) {
            $this->attributes['duration'] = $this->check_out->diffInMinutes($this->check_in);
        }
    }
}
