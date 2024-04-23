<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatestProjectRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_owner', 
        'service_provider',
        "project_id"
    ];
}
