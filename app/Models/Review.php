<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 
        "company_id",
        "rating",
        "message",
        "user_id",
        "service_id",
    ];
}