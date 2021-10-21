<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    //Register
    public function register(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:4',
            'lastName' => 'required',
            'address' => 'required|min:4',
            'phone' => 'required|min:9',
            'dni' => 'required|min:9',
            'birthday' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'address' => $request->address,
            'phone' => $request->phone,
            'dni' => $request->dni,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    //Login
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
