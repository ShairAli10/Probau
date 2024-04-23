<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'plan_id',
        'charges_id',
        'start_date',
        'end_date',
        'status',
        'payment_method',
        'payment_id'
    ];
}
