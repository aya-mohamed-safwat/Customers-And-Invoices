<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request){
        $user=User::Create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
        ]);

        if($request['role']=='admin'){
        $token=$user->createToken('adminToken',['create','update','delete'])->plainTextToken;
        }

        else
        {
            $token = $user->createToken('basicToken')->plainTextToken;
        }
        return response()->json([
            'user'=>$user,
        'token'=>$token]);
    }

    
    public function login(Request $request){
        $userDetals=$request->only('email','password');

        if(Auth::attempt($userDetals)){
            $user = Auth::user();
            $role = $user->role;
            if($role=='admin'){
                /** @var \App\Models\MyUserModel $user **/
                $token=$user->createToken('adminToken',['create','update','delete'])->plainTextToken;
                }
                else
                {
                    /** @var \App\Models\MyUserModel $user **/
                    $token = $user->createToken('basicToken')->plainTextToken;
                }
                return response()->json([
                'token'=>$token]);
            }
            else
            {
                return response()->json([
                    'User not registed']);
            }

        }
    
    
    public function destroy(User $user)
    {}
}
