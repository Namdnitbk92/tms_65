<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubject extends Model
{
    protected $table = 'subject_user_course';

    protected $fillable = [
        'user_course_id',
        'subject_id',
        'start_date',
        'end_date',
        'status',
        'progress',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function userCourse()
    {
        return $this->belongsTo(UserCourse::class);
    }
}
