<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AuthServices;

class AuthController extends Controller
{
    protected $authServices;

    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function login(LoginRequest $loginRequest)
    {
        return $this->authServices->login($loginRequest->all());
    }

    public function register(RegisterRequest $registerRequest)
    {
        return $this->authServices->register($registerRequest->all());
    }

    public function refresh()
    {
        return $this->authServices->refresh();
    }

    public function forgetPassword(ForgetPasswordRequest $forgetPasswordRequest)
    {
        return $this->authServices->forgetPassword($forgetPasswordRequest->all());
    }

    public function resetPassword(ResetPasswordRequest $resetPasswordRequest)
    {
        return $this->authServices->resetPassword($resetPasswordRequest->all());
    }
}
