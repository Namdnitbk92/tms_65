<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const ROLE_ADMIN = 1;
    const ROLE_USER = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'sex',
        'birthday',
        'phone',
        'avatar',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function socialNetworks()
    {
        return $this->hasMany(SocialNetwork::class);
    }

    public function user_course()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function user_subjects()
    {
        return $this->hasManyThrough(UserSubject::class, UserCourse::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function isAdmin()
    {
        return $this->role;
    }
    
    public function userSubjects()
    {
        return $this->hasManyThrough(UserSubject::class, UserCourse::class);
    }

    public function userTasks()
    {
        return $this->hasManyThrough(UserTask::class, UserCourse::class);
    }
}
