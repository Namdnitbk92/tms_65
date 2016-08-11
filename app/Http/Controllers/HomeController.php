<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\Utils;

class HomeController extends Controller
{

    use Utils;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.dashboard');
    }

    public function contact()
    {
        return view('layouts.contact');
    }

    public function getActivities(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' => $this->getActivity()]);
        }

        return response()->json(['data' => $this->getActivity()]);
    }
}
