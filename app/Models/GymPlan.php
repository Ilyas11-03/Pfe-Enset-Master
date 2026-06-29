<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'plan_id',
        'start_date',
        'end_date',
        'duration',
        'total_amount',
        'amount_paid',
        'due_amount',
        'discount_amount',
        'payment_status',
        'payment_method',
        'due_date',
        'status',
        'auto_renew',
        'notes',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getStatusAttribute()
    {
        return $this->end_date < Carbon::now() ? 'Expired' : 'Active';
    }

    public function scopeActive($query)
    {
        return $query->where('end_date', '>=', Carbon::now());
    }
}
