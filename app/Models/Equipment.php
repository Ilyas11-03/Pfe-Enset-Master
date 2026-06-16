<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'description',
        'image',
        'quantity',
        'amount',
        'purchase_date',
        'condition',
        'maintenance_date',
        'serial_number',
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
}
