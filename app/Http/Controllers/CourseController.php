<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Course\CourseRepository;
use Mockery\CountValidator\Exception;
use App\Services\ExportUtils;
use App\Models\Course;

class CourseController extends Controller
{
    protected $courseRepository;
    protected $config;

    use ExportUtils;

    public function __construct(CourseRepository $courseRepository, Course $course)
    {
        $this->courseRepository = $courseRepository;
        $this->config = app()->make('stdClass');
        $this->config->model = $course;
        $this->middleware('auth');
    }

    public function exportExcel()
    {
        $this->buildExcel($this->courseRepository, route('admin.courses.index'));
    }

    public function exportCSV()
    {
        $this->buildCSV($this->courseRepository, route('admin.courses.index'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getCourseOfUser = $request->input('view_course_of_user');
        if (isset($getCourseOfUser)) {
            $courses = $this->courseRepository->getCourseOfUser();
            $trainees = [];
        } else {
            $entry = $request->input('entry');
            $entry = empty($entry) ? config('common.paginate_document_per_page') : $entry;
            $courses = $this->courseRepository->paginate($entry);
            $trainees = $this->courseRepository->getAllTrainees();
        }

        return view('suppervisor.course.index', ['courses' => $courses, 'trainees' => $trainees]);
    }

    /**
     * Show the form for creating a new resource.php
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->courseRepository->getAllSubject();


        return view('suppervisor.course.create', [
            'subjects' => $subjects,
            'course' => [],
            'subjectsOfCourse' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'description',
            'status',
            'start_date',
            'end_date',
            'image_url',
            'subjectData',
        ]);

        $data['subjectList'] = explode(',', $data['subjectData']);
        $result = $this->courseRepository->store($data);
        if ($result == false) {
            return redirect()->route('admin.courses.index')->withErrors($result);
        }

        return redirect()->route('admin.courses.index')
            ->withSuccess(trans('message.create_course_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = $this->courseRepository->showById($id);
        $subjects = $course->subjects()->get();
        $trainees = $this->courseRepository->getTraineesOfCourse(['course_id' => $id]);

        return view('suppervisor.course.show', [
            'course' => $course,
            'subjects' => $subjects,
            'trainees' => $trainees,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = $this->courseRepository->showById($id);
        $subjects = $this->courseRepository->getAllSubject();
        $subjectsOfCourse = $course->subjects()->get();
        $trainees = $this->courseRepository->getTraineesOfCourse(['course_id' => $id]);
        $allTrainees = $this->courseRepository->getAllTraineesWithoutCourse($trainees);

        return view('suppervisor.course.edit', [
            'course' => $course,
            'subjects' => $subjects,
            'subjectsOfCourse' => $subjectsOfCourse,
            'trainees' => $trainees,
            'allTrainees' => $allTrainees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'name',
            'description',
            'start_date',
            'status',
            'end_date',
            'image_url',
            'userInCourses',
        ]);
        $subjects = $request->input('subjectData');
        $subjects = explode(',', $subjects);
        $result = $this->courseRepository->update($data, $subjects, $id);
        if (!$result) {
            return redirect()->route('admin.courses.edit', ['courses' => $id])
                ->withErrors(trans('message.update_error'));
        }

        return redirect()->route('admin.courses.edit', ['courses' => $id])
            ->withSuccess(trans('message.update_course_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->courseRepository->destroy($id);
        if (!$result) {
            return redirect()->route('admin.courses.index')
                ->withErrors(trans('message.delete_error'));
        }

        return redirect()->route('admin.courses.index')
            ->withSuccess(trans('message.delete_course_successfully'));
    }

    public function search(Request $request)
    {
        $term = $request->input('term');
        $course = $this->courseRepository->search($term);

        return view('suppervisor.course.index', ['courses' => $course, 'search' => true]);
    }

    public function destroySelected(Request $request)
    {
        $ids = $request->input('ids');
        try {
            $this->courseRepository->destroySelected($ids);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function assignTrainee(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->only(['ids', 'course_id']);
            try {
                $result = $this->courseRepository->assignTraineeToCourse($data);
                if (!$result) {
                    return response()->json(['error' => 'Assign Trainee Error!']);
                }
            } catch (Exception $e) {
                return response()->json(['error' => 'Assign Trainee Error!']);
            }
        }

        return response()->json(['message' => 'Assign Trainee Successfully!']);
    }
}
