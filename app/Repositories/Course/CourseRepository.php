<?php

namespace App\Repositories\Course;

use DB;
use App\Models\Course;
use App\Models\Subject;
use App\Http\Requests\Request;
use App\Repositories\BaseRepository;

class CourseRepository extends BaseRepository
{
    protected $trainee;
    protected $subject;
    protected $task;
    public $exportConfig;

    public function __construct(Course $course, Subject $subject)
    {
        $this->model = $course;
        $this->subject = $subject;
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
        try {
            DB::transaction(function () use ($data) {
                $course = $this->create($data);
                if ($data['subjectData']) {
                    $subjects = $data['subjectData'];
                    $course->subjects()->attach($subjects);
                }
            });
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    public function update($data = [], $subjects, $id)
    {
        try {
            DB::transaction(function () use ($data, $subjects, $id) {
                $this->updateById($data, $id);
                if (!empty($subjects)) {
                    $subjects = explode(',', $subjects);
                    $this->showById($id)->subjects()->sync($subjects);
                }
            });
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    public function destroy($id)
    {
        try {
            $course = $this->showById($id);
            DB::transaction(function () use ($course) {
                $subjects = $course->subjects()->get();
                if (!$subjects->isEmpty()) {
                    $ids = [];
                    foreach ($subjects as $subject) {
                        array_push($ids, $subject->id);
                    }
                    $course->subjects()->detach($ids);
                }
                $course->delete();
            });
        } catch (Exception $e) {
            return false;
        }

        return true;
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

}
