<?php

namespace App\Http\Controllers\Api;

use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginRequest,RegisterRequest,ResetPasswordRequest,OtpRequest};
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => 
        ['login','register','confirmOtp','resendOtp','forgetPassword','resetPassword']]);
    }

    public function register(RegisterRequest $request){
        return $this->authService->register($request->email,$request->validated());
    }

    public function confirmOtp(OtpRequest $request){
        return $this->authService->confirmOtp($request->otp,$request->email);
    }

    public function resendOtp(Request $request){
        return $this->authService->resendOtp($request->email);
    }

    public function forgetPassword(Request $request){
        return $this->authService->forgetPassword($request->email);
    }

    public function resetPassword(ResetPasswordRequest $request){
        return $this->authService->resetPasswordViaOtp($request->code ,$request->email, $request->password);
    }

    public function login(LoginRequest $request){
        return $this->authService->login($request->only('email', 'password'));
    }

    public function logout() {
        return $this->authService->logout();
    }

    public function refresh(){
         return $this->authService->refreshToken();
    }



}
