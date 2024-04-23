<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\Cast;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        "name",
        "email",
        "phone_no",
        'image',
        'time',
        'lat',
        'long',
        'location',
        'description',
        'services',
        'company_type',
        'status',
        'project_type',

    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'company_type' => 'array',
        'services' => 'array',
        'user_id' => 'string',
    ];

    protected $hidden = [
        'services',
        'company_type'
    ];
    // soft deleting User Data from other tables
    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($parent) {
            $parent->SaveProject()->delete();
            $parent->ongoingProjects()->delete();
            $parent->ProjectPayment()->delete();
            $parent->ProjectReviews()->delete();
        });
    }

    public function ongoingProjects(){
        return $this->hasMany(OngoingProject::class , 'project_id');
    }
    public function getServices(){
        return $this->hasMany(Service::class, 'id', 'services');
    }
    public function getCompanyType(){
        return $this->hasMany(CompanyType::class, 'id', 'company_type');
    }

    public function SaveProject()
    {
        return $this->hasMany(SavedProject::class, 'project_id');
    }
    public function ProjectPayment()
    {
        return $this->hasMany(ProjectPayment::class, 'project_id');
    }

    public function ProjectReviews()
    {
        return $this->hasMany(Review::class, 'project_id');
    }

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
    public function userInfo(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function company_types()
    {
        return $this->hasMany(ProjectCompanyType::class, 'project_id')->select('id', 'project_id', 'company_type_id', 'name');
    }
}
