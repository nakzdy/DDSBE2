<?php

namespace App\Http\Controllers;
use App\Models\UserJob;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserJobController extends Controller
{
    use ApiResponser;

    private $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the list of user jobs
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $usersjob = UserJob::all();
        return $this->successResponse($usersjob);
    }

    /**
     * Obtains and shows one user job
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userjob = UserJob::findOrFail($id);
        return $this->successResponse($userjob);
    }
}