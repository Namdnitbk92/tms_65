<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'start_date',
        'end_date',
        'image_url',
        'status',
    ];

    public function getColumn()
    {
        return $this->fillable;
    }

    public function course_subjects()
    {
        return $this->hasMany(CourseSubject::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
