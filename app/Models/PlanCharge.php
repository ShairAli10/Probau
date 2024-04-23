<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'name',
        'price',
        'validity',
        'description'
    ];
}
