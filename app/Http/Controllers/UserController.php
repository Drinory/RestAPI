<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){
        //Validation
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        //End Validation

        $input = $request->only('name', 'email', 'password');	
        
        //Register User
        
        try{
            $user = new User;
    
            //$user->name = $request->input('name');
            //$user->email = $request->input('email');
            //$password = $request->input('password');
    
    
            $user->name = $input['name'];
            $user->email = $input['email'];
            $password = $input['password'];
    
            $user->password = app('hash')->make($password);
            //this will create hash encription
            
            //save user
            if( $user->save()) {
                // code 200 is when the http request is successful
                $code = 200;
                $output = [
                    'user' => $user,
                    'code' => $code,
                    'message' => 'User created successfully'
                ];
    
            } else {
                // code 500 is when the http request is not successful
                $code = 500;
                $output = [
                    'user' => $user,
                    'code' => $code,
                    'message' => 'An error occured while creating user'
                ];
    
            }
        } catch (Exception $e) {
            // code 500 is when the http request is not successful
            $code = 500;
            $output = [
                'code' => $code,
                'message' => 'An error occured while creating user'
            ];
        }
        //End register user
    
        //return respose (first data than http code as parameters)
        
        return response()->json($output, $code);
    }

    public function login(Request $request){
        //validate data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //end validation
        $input = $request->only('email', 'password');
        
        //Auth attempt will check if email and password are correct
        if( ! $authorized = Auth::attempt($input) ){
            $code = 401;
            $output = [
                'code' => $code,
                'message' => 'User is not authorized'
            ];
        } else {
            $code = 201;
            $token = $this->respondWithToken($authorized);
            //Respond with token is defined in controller php
            $output = [
                'code' => $code,
                'message' => 'User logged in successfully',
                'token' => $token
            ];
              
        }
        return response()->json($output, $code);
    }

    public function refresh()
    {
        //This invalidates current token and makes a new one
        try{
            $newToken = auth()->refresh();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
            
        return response()->json(['token' => $newToken]);
    }

}
