<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'address' => $request->address,
            'phone' => $request->phone,
            'dni' => $request->dni,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'password' =>  bcrypt($request->password)
        ]);

        //Se llama a la propiedad plainTextToken para acceder a su valor del texto sin formato de token.
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);

        return response($response, status: 201);
    }

    //Login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //Confirmamos el mail.
        $user = User::where('email', $data['email'])->first();

        //Confirmamos la contraseña.
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials.'
            ], status: 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, status: 201);
    }
}
