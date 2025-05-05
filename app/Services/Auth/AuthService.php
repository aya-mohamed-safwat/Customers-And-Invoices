<?php
namespace App\Services\Auth;

use Illuminate\Http\JsonResponse;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService{
    protected $cacheService;
    protected $otpService;

public function __construct(OtpService $otpService,CacheService $cacheService) {
        $this->otpService=$otpService;
        $this->cacheService=$cacheService;
    }


    public function register(String $email, array $data):JsonResponse{

        $this->cacheService->Store($email,$data);
        $this->otpService->generateSendOtp($email);

        return response()->json([
            'message' => 'Verification email sent.',
            'email' =>$email]);
    }


    public function confirmOtp(String $code,String $email):JsonResponse{
        
        $cachedData = $this->cacheService->get($email);

        if (!$cachedData || $cachedData['email'] !== $email) {
            return response()->json(['message' => 'Invalid email or OTP expired'], 400);
        }

        $otp = $this->otpService->validate($email, $code);

        if (!$otp) {
            return response()->json(['message' => 'Invalid OTP or it has expired'], 400);
        }

        $this->createUser($cachedData);
        $this->cacheService->forget($email);
        $otp->delete();

        return response()->json(['message' => 'User created and email verified successfully.']);
    }


    public function createUser(array $data): User{
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'email_verified_at' => now(),
        ]);
    }


    public function resendOtp(String $email):JsonResponse{

        if(User::where('email',$email)->exists()){
            return response()->json(['message' => 'Invalid email or OTP expired'], 400);
        }

        $cachedData = $this->cacheService->get($email);

        if (!$cachedData || $cachedData['email'] !== $email) {
            return response()->json(['message' => 'Invalid email or OTP expired'], 400);
        }

        $this->otpService->generateSendOtp($email);

        return response()->json(['message' => 'OTP resent. Please check your email.']);
    }


    public function forgetPassword(String $email):JsonResponse{
        if(!User::where('email',$email)->exists()){
            return response()->json(['message' => 'email not exists '], 400);
        }
        
        $this->otpService->generateSendOtp($email);

        return response()->json([
            'message' => 'OTP resent. Please check your email.',
            'email' =>$email]);
    }

    

    public function resetPasswordViaOtp(String $code,String $email,String $password):JsonResponse{
        $otp = $this->otpService->validate($email, $code);
        if (!$otp) {
            return response()->json(['message' => 'Invalid OTP or it has expired'], 400);
        }
        $user = User::where('email', $email)->first();
    
    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }
    $user->update([
        'password' => bcrypt($password), 
        'email_verified_at' => now(), 
    ]);
        $otp->delete();
        return response()->json(['message' => 'password is changed successfully'], 200);
    }

    public function login(array $data):JsonResponse{

        if (! $token = auth()->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout():JsonResponse{
        auth()->logout();
    
        return response()->json(['message' => 'Successfully logged out']);
    }
    

    public function refreshToken():JsonResponse{
        return response()->json([
            'access_token' => JWTAuth::refresh(),
        ]);
    }


}
