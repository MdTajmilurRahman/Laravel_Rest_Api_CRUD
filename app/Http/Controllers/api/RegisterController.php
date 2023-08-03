<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except'=> ['login','register']]);
    }

    public function login(Request $request) {
         $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $user = Auth::user();
            $token = auth()->user()->createToken('Tajmilur')->accessToken;
            return response()->json([
                'token' => $token,
                'user' => $user
        ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

    }

    public function register(Request $request)
    {

        $validator=Validator::make($request->all(), [
            'name'=>'required|max:200',
            'email'=>'required|email|unique:users|max:200',
            'password'=>'required|max:200'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],200);
        }

        $user =User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);


        return response()->json([
            'message' => 'Regitered  successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
