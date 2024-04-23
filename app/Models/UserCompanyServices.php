<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompanyServices extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_company_type_id',
        'service_id',
        'name'
    ];
}
