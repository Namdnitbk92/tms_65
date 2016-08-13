<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSubject extends Model
{

    protected $table = 'course_subject';

    protected $fillable = [
        'course_id',
        'subject_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
