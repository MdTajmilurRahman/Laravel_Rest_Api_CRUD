<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Usercontroller extends Controller
{

    // showing all users

    public function index() {
        $users=User::all();
        if ($users->count() >0) {
            return response()->json([
                'status'=>200,
                'users'=>$users
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No data found'
            ]);
        }

    }

    //Create new users
    public function store(Request $request) {
        $validator=Validator::make($request->all(), [
            'name'=>'required|max:200',
            'email'=>'required|email|max:200',
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

        if ($user) {
            return response()->json([
                'status'=>200,
                'message'=>'User added successfully'
            ],200);
        } else {
            return response()->json([
                'status'=>500,
                'message'=>'Something is worng'
            ],200);
        }


    }

    //showing specific user

    public function show($id) {
        $user=User::find($id);
        if ($user) {
            return response()->json([
                'status'=>200,
                'message'=>'User found successfully',
                'user'=>$user
            ],200);
        } else {
            return response()->json([
                'status'=>500,
                'message'=>'Something is worng'
            ],200);
        }
    }


    //update user data

    public function update(Request $request, $id){
        $validator=Validator::make($request->all(), [
            'name'=>'required|max:200',
            'email'=>'required|email|max:200',
            'password'=>'required|max:200'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],200);
        }

        $user=User::find($id);
        if ($user) {

            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            return response()->json([
                'status'=>200,
                'message'=>'User Updated successfully',
                'user'=>$user
            ],200);
        } else {
            return response()->json([
                'status'=>500,
                'message'=>'Something is worng'
            ],200);
        }


    }

    //delete user

    public function destroy($id) {
        $user=User::find($id);
        if ($user) {

            $user->delete();

            return response()->json([
                'status'=>200,
                'message'=>'User deleted successfully'
            ],200);
        } else {
            return response()->json([
                'status'=>500,
                'message'=>'Something is worng'
            ],200);
        }
    }

}
