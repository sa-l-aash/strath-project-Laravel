<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    function createNewUser(Request $request) {
        $request->validate(
            [
'name'=>'required',
'email'=>'required',

'country'=>'required',
'waste_material_produced'=>'required',
'phone_number'=>'required',
'password'=>'required'

            ]
            );
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                
                'country'=>$request->country,
                'waste_material_produced'=>$request->waste_material_produced,
                'phone_number'=>$request->phone_number,
                'password'=>$request->password
            ]);
            $user = User::find($user->id);
            if($user){
                return response([
                    'message'=>'success',
                    'response'=>$user
                ]);
            };
    }
    function readOneUser(Request $request){
        $request->validate([
            'id'=> 'required'
        ]);
        $readUser = User::find($request->id);
        if($readUser){
            return response ([
                'message'=>'success',
                'response'=> $readUser
            ]);
        }else{
            return response([
                'message' => 'success',
                'response'=> 'this user does not exist'
            ]);
        }
    }
    function readAllUsers() {
        $allUsers = User::all();
        //checks whether the response exist or not
        if($allUsers){
            //response is taken as an array
            return response ([
                'message'=>'Success',
                'response'=> $allUsers

            ]);
        }else{
            return response([
                'message' => 'success',
                'response'=> 'no user available'
            ]);
        }
    }
    //the below update function can be used to update a users password
    function updateUser(Request $request) {
        $request->validate([
            'id'=> 'required',
            'name'=> 'required'
        ]);
       $name = User::find($request->id);
    if($name) {
        //retrieve the user from the db
        //    '$updateUser'  hosts the user
        //here we update a section of the record
    $name-> name = $request->name;
    // and update it
    $name->save();
    //here we retrieve the record again after update
    return response([
        'message'=>'success',
        'response'=> $name

    ]);
    }else{
        return response([
            'message'=>'failed',
            'response'=> 'Subcounty not does not exist'

        ]);
    }

    }
    function deleteUser(Request $request){
        //validate
        $request->validate([
            'id'=>'required'
        ]);
        //retrieve the record 
        $name = User::find($request->id);
//here we check if the record exists
        if($name){
            $deletedUser = $name;
            //delete
            $name->delete();
            return response([
                'message'=>'success',
                'response'=> $deletedUser
            ]);
        }else{
            return response([
                'message'=>'success',
                'response'=> 'deleted user not found or does not exist'
            ]);
        }

    }
}
