<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Cloudder;
use App\Repositories\BaseRepositoryInterface;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(BaseRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('home');
    }

    public function show()
    {
        //
    }

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

        if ($request->hasFile('avatar')) {
            $filename = $request->avatar;
            try {
                Cloudder::upload($filename, config('common.path_cloud_avatar')."$user->name");
                $user->avatar = Cloudder::getResult()['url'];
            } catch (Exception $ex) {
                return redirect()->route('users.edit')->withError(trans('message.upload_error'));
            }
        }

        $user->name = $request->get('name', '');
        $user->address = $request->get('address', '');
        $user->phone = $request->get('phone', '');
        $user->email = $request->get('email', '');

        $user->save();

        return redirect('home');
    }
}
