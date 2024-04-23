<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'image',
        'description',
    ];

    protected $casts = [
        'company_id' => 'string',
    ];

    public function project_sub_images()
    {
        return $this->hasMany(CompanyProjectImage::class, 'project_id');
    }

}
