<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'address',
        'phone',
        'operating_hours',
        'city',
        'region',
        'status',
        'image',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
    public function sports()
    {
        return $this->hasMany(Sport::class);
    }


    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function gymPlans()
    {
        return $this->hasMany(GymPlan::class)->orderBy('created_at', 'desc');
    }

    public function currentPlan()
    {
        return $this->hasOne(GymPlan::class)->active()->latestOfMany();
    }
    public function latestPlan()
    {
        return $this->hasOne(GymPlan::class)->latestOfMany();
    }
}
