<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Subject\SubjectRepository;
use Illuminate\Http\Request;
use Response;

class SubjectController extends Controller
{
    protected $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key = $request->input('search');
        $subjects = $this->subjectRepository->search($key);

        return view('admin.subjects.index', ['listSubjects' => $subjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'name' => 'required|max:255',
//        ]);

        try {
            $subject = $request->only(['name', 'description']);
            $this->subjectRepository->create($subject);
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage())->withInput();
        }

        return redirect(route('admin.subjects.index'))->withSuccess(trans('message.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $subject = $this->subjectRepository->showById($id);
            $tasks = $subject->tasks;
        } catch (\Exception $e) {
            return redirect(route('admin.subjects.index'))->withError($e->getMessage());
        }

        return view('admin.subjects.detail', ['subject' => $subject, 'listTasks' => $tasks]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $subject = $this->subjectRepository->showById($id);
        } catch (\Exception $e) {
            return redirect(route('admin.subjects.index'))->withError($e->getMessage());
        }

        return view('admin.subjects.edit', ['subjects' => $subject]);
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
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        try {
            $subject = $request->only(['name', 'description']);
            $this->subjectRepository->updateById($subject, $id);
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage())->withInput();
        }

        return redirect(route('admin.subjects.index'))->withSucces(trans('message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->subjectRepository->deleteById($id);
        } catch (\Exception $e) {
            return redirect(route('admin.subjects.index'))->withError($e->getMessage());
        }

        return redirect(route('admin.subjects.index'))->withSucces(trans('message.delete_success'));
    }

//    delete multi
    public function deleteMulti(Request $request)
    {
        $ids = $request->all();
        $this->subjectRepository->deleteMulti($ids);
        $subject = $this->subjectRepository->paginate(config('common.pagination.per_page_subject'));
        $view = view('admin.partials.list_subject', ['listSubjects' => $subject])->render();

        return Response::json([
            'view' => $view,
        ]);
    }
}
