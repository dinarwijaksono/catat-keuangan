<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LoginService;
use App\Services\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Validate;

class AuthController extends Controller
{
    protected $registerService;
    protected $loginService;

    public function __construct(RegisterService $registerService, LoginService $loginService)
    {
        $this->registerService = $registerService;
        $this->loginService = $loginService;
    }

    public function doRegister(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|min:4',
            'password' => 'required|min:4',
            'password_confirm' => 'required|same:password'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
            ], 400);
        }

        $register = $this->registerService->register($request->name, $request->email, $request->password);

        if (is_null($register)) {
            return response()->json([
                'errors' => [
                    "message" => "Email has already exist."
                ]
            ], 400);
        }

        return response()->json([
            'data' => [
                'api-token' => $register['api_token'],
                'email' => $request['email'],
                'name' => $request['name']
            ]
        ], 201);
    }

    public function doLogin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $response = $this->loginService->login($request->email, $request->password);

        if (is_null($response)) {
            return response()->json([
                'errors' => [
                    'message' => 'Email or password is wrong.'
                ]
            ], 400);
        }

        return response()->json([
            'data' => [
                'api-token' => $response->api_token,
                'token-expired' => $response->token_expired,
                'email' => $response->email,
            ]
        ], 200);
    }
}
