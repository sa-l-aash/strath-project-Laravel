<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //here we will have the register,login and logout functions
    public function register(Request $request){
        $textField = $request->validate([
            'name'=> 'required|string',
            'email'=> 'required|string|unique:users,email',
            'country'=>'required|string',
            'waste_material_produced'=>'required|string',
            'phone_number'=>'required|unique:users,phone_number',
            'password'=> 'required|string|confirmed'
        ]);

        $user = User::create([
            'name'=> $textField['name'],
            'email'=> $textField['email'],
            'country'=> $textField['country'],
            'waste_material_produced'=> $textField['waste_material_produced'],
            'phone_number'=> $textField['phone_number'],
            'password'=>bcrypt($textField['password'])
        ]);
            //here we generate a token for the user that has just been created
        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            //this will return the user and his token 
            'user'=> $user,
            'token'=>$token
        ];
        //this will return the above response and also 201
        return response($response, 201);
    }

    
    public function login(Request $request){
        $textField = $request->validate([
            'email'=> 'required|string',
            'password'=> 'required|string'
        ]);

        //check email
        $user = User::where('email', $textField['email'])->first();

        //check password
        if(!$user || !Hash::check($textField['password'], $user->password)){
            return response([
                'message'=> 'Bad Credentials'
            ], 401);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user'=> $user,
            'token'=>$token
        ];

        return response($response, 201);
    }

    public function logout(Request $request){
        auth()->user()->token()->delete();

        
        return [
            'message'=> 'You have been logged Out' 
        ];
    }
}
