<?php

namespace App\Http\Controllers\User;

use App\Repositories\User\UserRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tasks = [];
        $user = $this->userRepository->showById($id);
        if (count($user->userTasks) > 0) {
            $tasks = $user->userTasks;
        }
      
        return view('users.tasks.index', ['tasks' => $tasks]);
    }

    public function showReport($id)
    {
        $tasks = $this->userRepository->getTaskOfUser($id);

        return view('users.tasks.report', ['listTasks' => $tasks]);
    }

    public function finishTask($id, $taskId, $subjectId, $userCourseId, $status)
    {
        try {
            if ($status == 1) {
                $this->userRepository->createUserTask($taskId, $userCourseId);
                $this->userRepository->updateSubjectProgess($subjectId, $userCourseId);
            }
        } catch (\Exception $e) {
            return redirect(route('report', [$id]))->withErrors(trans('message.finish_error'));
        }

        return redirect(route('report', [$id]));
    }
}
