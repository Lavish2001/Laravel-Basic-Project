<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // User Signup //
    function signup(Request $req){

        // Validate user info
        $validator = Validator::make($req->all(),[
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

            // If validation fails, return the errors
        if ($validator->fails()) {
        return response()->json(['status' => 'RXERROR', 'message' => $validator->errors()], 400);
    }
 
        // Create a new user
        $user = User::create([
            'username' => $req->input('username'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password')),
        ]);

        if($user){
            return response()->json(['status'=>'RXSUCCESS','message' => 'User created successfully.'], 201);
        }else{
            return response()->json(['status'=>'RXERROR','message' => 'User creation failed.'], 400);
        }
           
    }


    
    // User Login //
    function login(Request $req){
         // Validate user info
         $validator = Validator::make($req->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json(['status' => 'RXERROR', 'message' => $validator->errors()], 400);
        }

        $user = User::where(['email'=>$req->input(('email'))])->first();

        if($user && Hash::check($req->input('password'),$user->password)){
            $req->session()->put('user',$user);
            return response()->json(['status' => 'RXSUCCESS','message'=>'Login successfully.', 'data' => $user], 200);
        }else{
            return response()->json(['status' => 'RXERROR', 'message' => "Invaid email or password."], 400);
        }
    }



    // User Logout //
    function logout(){
        Session::flush();
        return response()->json(['status' => 'RXSUCCESS', 'message' => "User logout successfully."], 400);
    }



    // User Change Password //
    function ChangePassword(Request $req){
        // Validate user info
        $validator = Validator::make($req->all(),[
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        // If validation fails, return the errors
        if ($validator->fails()) {
        return response()->json(['status' => 'RXERROR', 'message' => $validator->errors()], 400);
    }

    $user = $req->session()->get('user');

    // Check Password
    $passwordMatch = Hash::check($req->input('current_password'), $user->password);
    if($passwordMatch){
        $new = Hash::make($req->input('new_password'));
        $databaseUser = User::where(['id'=> $user->id])->first();
        $databaseUser->password = $new;
        $databaseUser->save();
        $req->session()->put('user',$databaseUser);
        return response()->json(['status' => 'RXSUCCESS', 'message' => 'Password change successfully'], 200);
    }else{
        return response()->json(['status' => 'RXERROR', 'message' => 'Incorrect password'], 400);
    }

    }



    // User Account Deactivate //
    function DeactivateAccount(Request $req){
        $user = $req->session()->get('user');
        $deleteUser = User::where(['id'=> $user->id])->first();
        $deleteUser->delete();
        Session::flush();
        return response()->json(['status' => 'RXSUCCESS', 'message' => 'Account deactivated.'], 200);
    }

}
