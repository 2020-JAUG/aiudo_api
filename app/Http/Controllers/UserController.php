<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Para listar todos los usuarios.
         * Guardo el token del user, mediante el método auth.
         */
        $user = auth()->user();
        $user = User::all();

        if($user->profile === 'is_admin') {
            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        }

        return response()->json([
            'success' => false,
            'data' => 'You do not have access'
        ], status: 406);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user()->find($id);

        if($user->id === $id) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => $user->toArray()
        ], status: 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $id)
    {
        //Pasamos el ID por parámetros lo localizamos y actualizamos los datos.
        $user = User::findOrFail($id);
        $user->update($request->all() );
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }


    public function logout(Request $request)
    {

        $token =  $request->user()->token();
        $token -> revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
     }
}
