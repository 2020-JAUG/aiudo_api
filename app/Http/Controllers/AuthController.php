<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {

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

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            report($ex);
            throw new $ex;
        }

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string'
            ]);

            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response([
                    'message' => 'Bad credentials.'
                ],401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $response = [
                'token' => $token,
                'user' => $user
            ];

            return response($response, 201);
        } catch (Exception $ex) {
            report($ex);
            throw new $ex;
        }
    }
}
