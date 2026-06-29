<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
        'payment_date',
        'member_id',
        'membership_id',
        'sport_id',
        'start_date',
        'end_date',
        'amount',
        'total_amount',
        'amount_paid',
        'due_amount',
        'payment_status',
        'auto_renew',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusAttribute()
    {
        return $this->end_date < Carbon::now() ? 'Expired' : 'Active';
    }

    // Accessor for auto_renew
    public function getAutoRenewAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }

    public function scopeActive($query)
    {
        return $query->where('end_date', '>=', Carbon::now());
    }
}
