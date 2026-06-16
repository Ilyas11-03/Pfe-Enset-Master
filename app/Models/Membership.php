<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'description',
        'duration',
        'price',
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

    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class);
    }
}
