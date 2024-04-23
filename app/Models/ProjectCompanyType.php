<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCompanyType extends Model
{
    use HasFactory;
    protected $fillable=[
        'project_id',
        'company_type_id',
        'name',
    ];

    public function services()
    {
        return $this->hasMany(ProjectCompanyService::class, 'project_company_type_id')->select('id','project_company_type_id', 'service_id', 'name', 'description', 'status');
    }
}
