<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $response = [];
    private $validation_rules = [
        'name' => 'required|max:255',
        'email' => 'required|unique:users|max:255',
        'password' => 'required'
    ];

    private function basicResponse()
    {
        return [
            'timestamp' => Carbon::now()->toDateTimeString(),
            'status' => 200,
            'message' => '',
            'result' => []
        ];
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->response = $this->basicResponse();
    }

    public function index()
    {
        try {
            $this->response['result'] = User::all();
        } catch (\Throwable $throwable) {
            $this->response['status'] = 500;
            $this->response['message'] = $throwable->getMessage();
        }

        return response()->json($this->response);
    }

    public function create(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);
        if ($validator->fails()) {
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else{
            try {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = app('hash')->make($request->password);

                if ($user->save()){
                    $this->response['message'] = 'data saved successfully!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'data failed to save!';
                }
            }catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }

    public function show($id)
    {
        $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
        if ($validator->fails()){
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $this->response['result'] = User::find($id);
            } catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }

    public function update(Request $request, $id)
    {
        $this->validation_rules['email'] = 'required';
        $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);

        if ($validator->fails()){
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $user = User::find($id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = app('hash')->make($request->password);

                if ($user->save()){
                    $this->response['message'] = 'user data has been successfully updated!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'user data failed to update!';
                }
            } catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }

    public function destroy($id)
    {
        $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
        if ($validator->fails()){
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $user = User::find($id);
                if ($user->delete()){
                    $this->response['message'] = 'user data removed successfully!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'user data failed to remove!';
                }
            } catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }
}
