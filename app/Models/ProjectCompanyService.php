<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCompanyService extends Model
{
    use HasFactory;

    protected $fillable=[
        'project_company_type_id',
        'service_id',
        'name',
        'description',
        'status',
    ];

    protected $casts = [

        'status' => 'string'
    ];
}
