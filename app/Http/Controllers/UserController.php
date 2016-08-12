<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Course\CourseRepository;
use  App\Repositories\BaseRepositoryInterface;

class UserController extends Controller
{
    private $userRepository;
    private $courseRepository;

    public function __construct(BaseRepositoryInterface $userRepository, CourseRepository $courseRepository)
    {
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $view_subject_of_user = $request->input('view_subject_of_user');
        if (isset($view_subject_of_user)) {
            $subjects = $this->courseRepository->getSubjectsOfUser();
        } else {
            $entry = $request->input('entry');
            $entry = empty($entry) ? config('common.paginate_document_per_page') : $entry;
            $subjects = $this->courseRepository->getSubjects($entry);
        }

        return view('suppervisor.trainee.subject.index', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (isset($id))
             return view($id);
        $data = $this->courseRepository->getSubjectsOfUser(); dd($data);
        $subjects = collect([]);
        if(data !== null) {
            foreach ($data as $element) {
                if ($element->subject_id === intval($id)) {
                    $subjects->push($element);
                    break;
                }
            }
        }

        return view('layouts.user.subject.show', ['subject' => $subjects->first()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->showById($id);

        return view('suppervisor.profile', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->userRepository->showById($id);
        } catch (Exception $ex) {
            return redirect()->route('users.edit')->withError($ex->getMessage());
        }


    }

    public function finishSubject(Request $request)
    {
        $msg = '';
        if (!$request->has('id')) {
            $msg = 'Can"t finish subject without id';
        } else {
            $id = $request->input('id');
            $msg = 'Finish Subject Id : ' . $id . 'successfully';
            if ($request->ajax()) {
                $result = $this->courseRepository->finishSubject($id);
                if (!$result) {
                    $msg = 'Finish subject id' . $id . 'errors';
                }
            }
        }

        return response()->json(['messsage' => $msg]);
    }

}