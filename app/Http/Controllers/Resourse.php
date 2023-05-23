<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class Resourse extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
