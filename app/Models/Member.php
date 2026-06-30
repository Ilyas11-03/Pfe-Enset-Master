<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'join_date',
        'status',
        'profile_image',
        'created_by',
        'updated_by',
    ];

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

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function currentPlan()
    {
        return $this->hasOne(Payment::class)->active()->latestOfMany();
    }

    public function latestPlan()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function isExpired()
    {
        $currentPlan = $this->currentPlan;

        if ($currentPlan) {
            return Carbon::now()->greaterThan($currentPlan->end_date);
        }

        return true; // No active plan means the membership is expired
    }

    public function getIsExpiredAttribute()
    {
        return $this->isExpired();
    }
}
