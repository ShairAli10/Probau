<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectServices extends Model
{
    use HasFactory;
    protected $fillable = [ 
        "project_id",
        "service_id",
        'description',
        "status",
    ];

    protected $casts = [
        'service_id' => 'string',
        'project_id' => 'string',
        'status' => 'string',
    ];
}
