<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_percentage',
        'user_limit',
        'member_limit',
    ];

    public function gymPlans()
    {
        return $this->hasMany(GymPlan::class);
    }
}
