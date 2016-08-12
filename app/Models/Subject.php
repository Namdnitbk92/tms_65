<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function getUpdatedAtStatusAttribute()
    {
        $now = Carbon::now();
        $status = $this->updated_at->diffForHumans($now);

        return $status;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['updated_at_status'] = $this->updated_at_status;
        return $array;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function user_courses()
    {
        return $this->belongsToMany(UserCourse::class);
    }
}
