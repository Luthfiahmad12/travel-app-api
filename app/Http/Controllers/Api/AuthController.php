<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(protected AuthService $authService)
    {
        //
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        return $this->SuccessResponse($result, 'login successfully', 200);
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());
        return $this->SuccessResponse($result, 'register successfully', 200);
    }
}
