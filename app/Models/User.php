<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_pic',
        'status',
        'user_type',
        'services',
        'company_type',
        'description',
        'company_tax',
        'no_employee',
        'lat',
        'long',
        'location',
        'device_id',
        'firebase_id',
        'g_token',
        'a_code',
        'range_for_user_project',
        'range_for_company_projects',
        'range_for_nearby_projects',
        'range_for_recommended_companies',
        'range_for_nearby_companies'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'services'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'services' => 'array',
        'company_type' => 'array',
        'email_verified' => 'string'
    ];

    // soft deleting User Data from other tables
    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($parent) {
            $parent->CompanyUsers()->delete();
            $parent->Projects()->delete();
            $parent->SaveCompany()->delete();
            $parent->Subscriptions()->delete();
            $parent->OnGoingProjects()->delete();
            $parent->SaveCompanyUser()->delete();
            $parent->SaveProjects()->delete();
            $parent->SaveProjectsUser()->delete();
            $parent->ProjectPayment()->delete();
            $parent->Reviews()->delete();
            $parent->ProjectRequest()->delete();
        });
    }

    public function CompanyUsers()
    {
        return $this->hasMany(CompanyUser::class, 'company_id');
    }

    public function Subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function OnGoingProjects()
    {
        return $this->hasMany(OngoingProject::class, 'company_id');
    }

    public function Projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function SaveCompany()
    {
        return $this->hasMany(SavedCompany::class, 'company_id');
    }
    public function SaveCompanyUser()
    {
        return $this->hasMany(SavedCompany::class, 'user_id');
    }

    public function SaveProjects()
    {
        return $this->hasMany(SavedProject::class, 'project_id');
    }
    public function SaveProjectsUser()
    {
        return $this->hasMany(SavedProject::class, 'user_id');
    }

    public function Reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function ProjectPayment()
    {
        return $this->hasMany(ProjectPayment::class, 'user_id');
    }

    public function ProjectRequest()
    {
        return $this->hasMany(ProjectRequest::class, 'company_id');
    }

    public function getDeletedAtAttribute($value)
    {
        return $value !== null ? $value : '';
    }
    public function projectInfo()
    {
        return $this->belongsTo(Project::class);
    }
    public function getServices()
    {
        return $this->hasMany(Service::class, 'id', 'services');
    }

    public function getCompanyTypes()
    {
        return $this->hasOne(CompanyType::class, 'id', 'company_type');
    }

    public function company_type()
    {
        return $this->hasMany(UserCompanyType::class, 'company_id')->select('id', 'company_id', 'company_type_id', 'name');
    }

    public function company_types()
    {
        return $this->hasMany(UserCompanyType::class, 'company_id')->select('id', 'company_id', 'company_type_id', 'name');
    }
}
