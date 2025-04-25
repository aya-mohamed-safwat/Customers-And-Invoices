<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/setup', function(){
// $userDate=[
//     'email'=>'admin@admin.com',
//     'password'=>'password'
// ];

// if(!Auth::attempt($userDate)){
//     $user = \App\Models\User::where('email', $userDate['email'])->first();


//     $user->name='Admin';
//     $user->email=$userDate['email'];
//     $user->password=Hash::make($userDate['password']);

//     $user->save();
// }

//     if(Auth::attempt($userDate)){
//         $user=Auth::user();

//         $adminToken = $user->createToken('adminToken',['create','update','delete']);
//         $updateToken = $user->createToken('updateToken',['create','update']);
//         $basicToken = $user->createToken('basicToken');

//         return[
//             'admin'=>$adminToken->plainTextToken,
//             'update'=>$updateToken->plainTextToken,
//             'basic'=>$basicToken->plainTextToken,
//         ];
//     }
// return response()->json([
//     'message' => 'User already exists and is authenticated.',
// ]);
// });
