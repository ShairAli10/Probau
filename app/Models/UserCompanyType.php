<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompanyType extends Model
{
    use HasFactory;
    protected $fillable=[
        'company_id',
        'company_type_id',
        'name',
    ];

    public function services()
    {
        return $this->hasMany(UserCompanyServices::class, 'user_company_type_id')->select('id','user_company_type_id', 'service_id', 'name');
    }
}
