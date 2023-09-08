<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //this is a function that creates a new user
    function createNewUser(Request $request) {
        $request->validate(
            [
            //below are the fields that are required 
            //to be filled in order to add a new user
            'name'=>'required',
            'email'=>'required',
            'country'=>'required',
            'waste_material_produced'=>'required',
            'amount'=>'required',
            'phone_number'=>'required',
            'password'=>'required'
            ]
            );
            $user = User::create([
                //here we assigns the value of the name field from the incoming 
                // $request data to the 'name' column in the User table.
                'name'=>$request->name,
                'email'=>$request->email,
                'country'=>$request->country,
                'waste_material_produced'=>$request->waste_material_produced,
                'amount'=>$request->amount,
                'phone_number'=>$request->phone_number,
                'password'=>$request->password
            ]);
            //we then find the user using their id
            $user = User::find($user->id);
            //if the user is present it prints his/her details
            if($user){
                return response([
                    'message'=>'success',
                    'response'=>$user
                ]);
            };
    }
    //this function displays a certain user details using his/her id 
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
    //this function displays all users present in the users table
    function readAllUsers() {
        $allUsers = User::all();
        //checks whether the response exist or not
        if($allUsers){
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
    //the below update function is used to update the waste_material_produced and its amount
    function updateUser(Request $request) {
        $request->validate([
            'id'=> 'required',
           'waste_material_produced'=> 'required',
            'amount'=>'required',
        ]);
       $name = User::find($request->id);
    if($name) {
        //retrieve the user from the db
        //    '$updateUser'  hosts the user
        //here we update a section of the record
    $name-> amount = $request->amount;
    $name-> waste_material_produced = $request->waste_material_produced;
    // and save it
    $name->save();
    //here we retrieve the record again after update
    return response([
        'message'=>'success',
        'response'=> $name

    ]);
    }else{
        return response([
            'message'=>'failed',
            'response'=> 'update failed'

        ]);
    }

    }
    //here we delete a user using he/her id
    function deleteUser(Request $request){
        $request->validate([
            'id'=>'required'
        ]);
        $name = User::find($request->id);
//here we check if the record exists
        if($name){
            $deletedUser = $name;
            //then delete it
            $name->delete();
            return response([
                'message'=>'success',
                'response'=> $deletedUser
            ]);
        }else{
            return response([
                'message'=>'success',
                'response'=> 'user does not exist/delete failed'
            ]);
        }
    }
    //search for a specific user using their waste_material_produced
    function searchUsers(Request $request) {
        $request->validate([
            'query' => 'required|string',
        ]);
        //here we retrieve the 'query' parameter from 
        // the above request and assigns it to $query
        $query = $request->input('query');
    
        try {
            // Perform the search based on the 'waste_material_produced' field
            $users = User::where(function ($queryBuilder) use ($query) {
                $queryBuilder->Where('waste_material_produced', 'LIKE', "%$query%");
            })->get();
    
            if ($users->count() > 0) {
                return response([
                    'message' => 'success',
                    'response' => $users
                ]);
            } else {
                return response([
                    'message' => 'success',
                    'response' => 'No users found matching the query.'
                ]);
            }
            //here we catch exceptions
        } catch (\Exception $e) {
            return response([
                'message' => 'error',
                'response' => 'Error processing the request: ' . $e->getMessage()
            ], 500); // Internal Server Error
        }
    }
    
}
