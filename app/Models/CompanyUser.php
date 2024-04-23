<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'phone_no',
        'image',
        'email',
        'designation',
        'joining_date',
    ];

    protected $casts = [
        'company_id' => 'string',
    ];

     /**
     * Get the value of the soft-deleted column.
     *
     * @param  mixed  $value
     * @return string
     */
    public function getDeletedAtAttribute($value)
    {
        return $value !== null ? $value : '';
    }
}
