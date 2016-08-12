<?php

namespace App\Repositories\Course;

use App\Models\UserSubject;
use DB;
use App\Services\Utils;
use App\Models\Course;
use App\Models\User;
use App\Models\Subject;
use App\Models\UserCourse;
use App\Http\Requests\Request;
use App\Repositories\BaseRepository;

class CourseRepository extends BaseRepository
{
    protected $trainee;
    protected $subject;
    protected $task;
    protected $user;
    public $exportConfig;

    use Utils;

    public function __construct(Course $course, Subject $subject, User $user)
    {
        $this->model = $course;
        $this->subject = $subject;
        $this->user = $user;
        $this->exportConfig = app()->make('stdClass');
        $this->exportConfig->name = trans('course.export.name');
        $this->exportConfig->creator = trans('course.export.creator');
        $this->exportConfig->company = trans('course.export.company');
        $this->exportConfig->fields = [
            trans('label.id'),
            trans('label.name'),
            trans('label.description'),
            trans('label.start_date'),
            trans('label.end_date'),
            trans('label.image'),
            trans('label.status'),
        ];
    }

    public function store($data)
    {
        $check = false;
        $course = collect([]);
        try {
            DB::beginTransaction();
            $course = $this->create($data);
            if ($data['subjectData']) {
                $subjects = $data['subjectData'];
                $subjects = explode(',', $subjects);
                $course->subjects()->attach($subjects);
            }
        } catch (Exception $e) {
            $check = true;
        } finally {
            if (!$check) {
                $this->logToActivity(
                    auth()->user()->id,
                    $course->id,
                    Course::class,
                    config('common.action_type.create')
                );
                DB::commit();
            } else {
                DB::rollBack();
                return false;
            }
        }

        return true;
    }

    public function update($data = [], $subjects, $id)
    {
        $check = false;
        $course = collect([]);
        $users = [];
        try {
            DB::beginTransaction();
            $course = $this->showById($id);
            $course->update($data);
            if (!empty($subjects)) {
                $course->subjects()->sync($subjects);
            }
            $users = $data['userInCourses'];
            if (count($users) > 0) {
                $users = explode(',', $users);
                $course->users()->sync($users);
            } else {
                $course->user_course()->delete();
            }

            $user_courses = $course->user_course()->get();
            if(intval($data['status']) === 2 && !empty($user_courses) && !empty($subjects)) {
                foreach ($user_courses as $user) {
                    $user->subjects()->sync($subjects);
                }
            }
        } catch (Exception $e) {
            $check = true;
        } finally {
            if (!$check) {
                $this->logToActivity(
                    auth()->user()->id,
                    $course->id,
                    Course::class,
                    config('common.action_type.update')
                );
                DB::commit();
            } else {
                DB::rollBack();
                return false;
            }
        }

        return true;
    }

    public function destroy($id)
    {
        $check = false;
        try {
            $course = $this->showById($id);
            DB::beginTransaction();
            $subjects = $course->subjects();
            $users = $course->users();
            if (count($subjects) > 0) {
                $subjects->detach();
            }
            if (count($users) > 0) {
                $users->detach();
            }

            \App\Models\Activity::where(['target_id' => $course->id])->delete();

            $course->delete();
        } catch (Exception $e) {
            $check = true;
        } finally {
            if (!$check) {
                $this->logToActivity(
                    auth()->user()->id,
                    $course->id,
                    Course::class,
                    config('common.action_type.delete')
                );
                DB::commit();
            } else {
                DB::rollBack();
                return false;
            }
        }
    }

    public function getAllSubject()
    {
        return $this->subject->all();
    }

    public function search($term)
    {
        return $this->model->where('id', 'LIKE', '%' . $term . '%')
            ->orWhere('name', 'LIKE', '%' . $term . '%')
            ->orWhere('status', 'LIKE', '%' . $term . '%')
            ->orWhere('start_date', 'LIKE', '%' . $term . '%')
            ->orWhere('end_date', 'LIKE', '%' . $term . '%')
            ->orWhere('description', 'LIKE', '%' . $term . '%')
            ->paginate(config('common.paginate_document_per_page'));
    }

    public function destroySelected($ids)
    {
        foreach ($ids as $id) {
            $this->destroy($id);
        }
    }

    public function getAllTrainees()
    {
        return $this->user->whereNotIn('id', [auth()->user()->id])->get();
    }

    public function assignTraineeToCourse($data)
    {
        $ids = $data['ids'];
        $course_id = $data['course_id'];
        $course = $this->showById($course_id);
        if (isset($ids) && isset($course_id)) {
            $traineesOfCourse = $course->user_course()->get();
            foreach ($ids as $key => $id) {
                foreach ($traineesOfCourse as $trainee) {
                    if ($trainee->user_id == $id) {
                        unset($ids[$key]);
                    } else continue;
                }
            }
            if (!empty($ids)) {
                try {
                    $course->users()->attach($ids);
                } catch (Exception $e) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getTraineesOfCourse($filter = null)
    {
        $trainees = [];
        if ($filter['course_id']) {
            $course = $this->showById($filter['course_id']);
            $trainees = $course->users()->get();
        }

        return $trainees;
    }

    public function getAllTraineesWithoutCourse($trainees = [])
    {
        $ids = $trainees->map(function ($trainee) {
            return $trainee->id;
        });

        return $this->user->whereNotIn('id', $ids)->where('role', 0)->get();
    }

    public function getCourseOfUser()
    {
        $user = auth()->user();
        $courses = $user->courses()->get();
        return $courses;
    }

    public function finishSubject($id)
    {
        try {
            $user_subject = UserSubject::findOrFail($id);
            $val = explode('/',$user_subject->progress);
            if(sizeof($val) == 2) {
                $percent = $val[0] / $val[1];
            } else {
                $percent = 0;
            }
            if($percent < 1) {
                return false;
            }
            $user_subject->status = 4;//set status to finish
            $user_subject->save();

            $this->logToActivity(
                auth()->user()->id,
                $user_subject->id,
                UserSubject::class,
                config('common.action_type.finish')
            );
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function getSubjects($limit = null)
    {
        $subjects = [];
        if ($limit !== null) {
            $subjects = $this->subject->paginate($limit);
        } else {
            $subjects = $this->subject->all();
        }

        return $subjects;
    }

    public function getSubjectsOfUser()
    {
        $user = auth()->user() ;
        if ($user == null) {
            return;
        }
        $user_subjects = $user->user_subjects()->get();

        $subjects = $user_subjects->map(function ($user_subject) {
            $subject = $user_subject->subject()->first();
            if (isExists($subject)) {
                $temp = app()->make('stdClass');
                $temp->id = $user_subject->id;
                $temp->user_course_id = $user_subject->user_course_id;
                $temp->course_id = UserCourse::find($user_subject->user_course_id)->course_id;
                $temp->subject_id = $user_subject->subject_id;
                $temp->start_date = $user_subject->start_date;
                $temp->end_date = $user_subject->end_date;
                $temp->status = $user_subject->status;
                $temp->progress = $user_subject->progress;
                $temp->subject_name = $subject->name;
                $temp->description = $subject->description;

                return $temp;
            } 

            return collect([]);
        });

        return $subjects;
    }

}
