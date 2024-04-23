<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRequest extends Model
{
    use HasFactory;


    protected $fillable = [
        'company_id', 
        "project_id",
        "service_id",
        "company_type_id",
        "status",
    ];
}
