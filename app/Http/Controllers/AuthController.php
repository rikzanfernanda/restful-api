<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
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
        $this->response = $this->basicResponse();
    }

    public function register(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);
        if ($validator->fails()) {
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = app('hash')->make($request->password);

                if ($user->save()) {
                    $this->response['message'] = 'data saved successfully!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'data failed to save!';
                }
            } catch (\Throwable $throwable) {
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }

    public function login(Request $request)
    {
        unset($this->validation_rules['name']);
        $this->validation_rules['email'] = 'required';
        $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);
        if ($validator->fails()) {
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $credentials = $request->only(['email', 'password']);
                $token = Auth::attempt($credentials);

                if ($token) {
                    $this->response['message'] = 'login successfully';
                    $this->response['token'] = $token;
                    $this->response['token_type'] = 'bearer';
                } else {
                    $this->response['message'] = 'email or password is incorrect';
                }
            } catch (\Throwable $throwable) {
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }
}
