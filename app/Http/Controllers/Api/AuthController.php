<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\LoginException;
use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Services\LoginService;
use App\Services\RegisterService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $registerService;
    protected $loginService;
    protected $userService;

    public function __construct(
        RegisterService $registerService,
        LoginService $loginService,
        UserService $userService
    ) {
        $this->registerService = $registerService;
        $this->loginService = $loginService;
        $this->userService = $userService;
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
                    "general" => "Email has already exist."
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

    public function getCurrentUser(Request $request)
    {
        try {
            $api_token = $request->header('api-token');

            $key = $this->userService->getByToken($api_token);

            Log::info('/api/curent-user success', [
                'api-token' => $api_token
            ]);

            return response()->json([
                'data' => [
                    'name' => $key->name,
                    'email' => $key->email,
                    'start_date' => $key->start_date,
                    'created_at' => $key->created_at,
                    'updated_at' => $key->updated_at,
                ]
            ], 200);
        } catch (\Throwable $th) {
            $api_token = $request->header('api-token');

            Log::error('/api/curent-user/{api_token} failed', [
                'api-token' => $api_token,
                'message' => $th->getMessage()
            ]);

            return response()->json([
                'message' => 'user unauthorize'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('api-token');

        ApiToken::where('token', $token)->delete();

        Log::info('Logout success', [
            'token' => $token
        ]);

        return response()->json([
            'message' => 'Berhasil'
        ], 200);
    }
}
