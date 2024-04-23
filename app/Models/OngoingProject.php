<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngoingProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        "project_id",
        "service_id",
        "status",
    ];
    public function projectInfo(){
        return $this->belongsTo(Project::class, 'project_id');
    }
}
