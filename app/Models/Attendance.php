<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'member_id',
        'gym_id',
        'check_in',
        'check_out',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }
}
