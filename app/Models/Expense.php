<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'description',
        'amount',
        'expense_date',
        'category',
        'receipt'
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
