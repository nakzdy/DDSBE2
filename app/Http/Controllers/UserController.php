<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Models\UserJob;
use DB;

class UserController extends Controller
{
    use ApiResponser;

    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    /* Return the list of users */
    public function index(){
        $users = User::all();
        return $this->successResponse($users);
    }

    /* Get all users */
    public function getUsers(){
        $users = User::all();
        return $this->successResponse($users);
    }

    /*Add a new user*/
    public function add(Request $request){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        $validator = $this->validate($request, $rules);

        if ($validator instanceof \Illuminate\Http\JsonResponse) {
            return $validator; // Return validation errors directly
        }

        // Validate if Jobid is found in the table tbluserjob
        try {
            UserJob::findOrFail($request->jobid);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Invalid job ID provided.', Response::HTTP_UNPROCESSABLE_ENTITY, 2); // Added site ID
        }

        $user = User::create($request->all()); // Include all fields from the request
        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    /*Show details of a single user*/
    public function show($id){
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND, 2); // Added site ID
        }

        return $this->successResponse($user);
    }

    /*Update an existing user*/
    public function update(Request $request, $id){
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        $validator = $this->validate($request, $rules);

        if ($validator instanceof \Illuminate\Http\JsonResponse) {
            return $validator; // Return validation errors directly
        }

        // Validate if Jobid is found in the table tbluserjob
        try {
            UserJob::findOrFail($request->jobid);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Invalid job ID provided.', Response::HTTP_UNPROCESSABLE_ENTITY, 2); // Added site ID
        }

        $user = User::findOrFail($id);

        $user->fill($request->all()); // Include all fields from the request

        // if no changes happen
        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY, 2); // Added site ID
        }

        $user->save();
        return $this->successResponse($user);
    }

    /* Delete a user */
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse('User ID does not exist', Response::HTTP_NOT_FOUND, 2); // Added site ID
        }

        $user->delete();
        return $this->successResponse(['message' => 'User deleted successfully']);
    }
}