<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\UserSubject;
use App\Models\UserTask;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;

class UserRepository extends BaseRepository
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getTaskOfUser($id)
    {
        $results = [];
        try {
            $user = User::find($id);
            $subjects = $user->userSubjects->where('status', 2);
            $userTasks = $user->userTasks;

            foreach ($subjects as $subject) {
                $tasks = $subject->subject->tasks;

                foreach ($tasks as $task) {
                    $listTasks['id'] = $task->id;
                    $listTasks['task'] = $task->name;
                    $listTasks['subject'] = $subject->subject->name;
                    $listTasks['course'] = $subject->userCourse->course->name;
                    $listTasks['subject_id'] = $subject->subject_id;
                    $listTasks['user_course_id'] = $subject->user_course_id;
                    $listTasks['task_status'] = 1;
                    foreach ($userTasks as $userTask) {
                        if ($userTask->task_id === $task->id) {
                            $listTasks['task_status'] = $userTask->status;
                        }
                    }
                    $results[] = $listTasks;
                }
            }
        } catch (\Exception $e) {
            abort(500);
        }
        return $results;
    }

    public function createUserTask($taskId, $userCourseId)
    {
        try {
            UserTask::create([
                'task_id' => $taskId,
                'user_course_id' => $userCourseId,
                'status' => config('common.status.finish'),
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()
            ]);
        } catch (\Exception $e) {
            abort(500);
        }
    }

    public function updateSubjectProgess($subjectId, $userCourseId)
    {
        try {
            DB::beginTransaction();
            $subject = UserSubject::where('subject_id', $subjectId)->where('user_course_id', $userCourseId)->first();
            $tasks = $subject->subject->tasks;
            $total = count($tasks);
            $ids = [];

            foreach ($tasks as $task) {
                $id = $task->id;
                $ids[] = $id;
            }

            $userTasks = UserTask::where('user_course_id', $userCourseId)->whereIn('task_id', $ids)->get();
            $finish = count($userTasks);

            UserSubject::where('subject_id', $subjectId)->where('user_course_id', $userCourseId)
                ->update([
                    'progress' => $finish . '/' . $total
                ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500);
        }
    }
}
