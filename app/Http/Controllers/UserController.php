<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHelper;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class UserController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->is_admin == true) {
            $users = User::all();

            return response()->json([
                'success' => true,
                'data' => $users
            ],200);
        }

        return response()->json([
            'success' => false,
            'data' => 'You do not have access.'
        ],406);
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
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $user = auth()->user()->find($id);

        if ($user->id === $id) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ],400);
        }

        return response()->json([
            'success' => true,
            'message' => $user->toArray()
        ],200);
    }


    /**
     * @return JsonResponse
     */
    public function group()
    {
        $user = auth()->user();

        if($user->is_admin == true) {
            $query = User::join('cuentas', 'users.id', '=', 'cuentas.id')
            ->select('users.id', 'users.name', 'users.phone', 'cuentas.tipo', 'cuentas.numero_de_cuenta')
            ->get();

            return response()->json([
                'success' => true,
                'message' => "These are the user's data.",
                'data' => $query
            ],200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access.',
            ],400);
        }
    }


    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user()->find($id);
        DB::beginTransaction();
        try {

            if ($user->id !== $id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bad credentials.'
                ],400);
            }

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ],400);
            }

            $updated = $user->fill($request->all())->save();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            report($ex);
            throw new Exception(ExceptionHelper::formatExceptionMessage($ex));
        }
        return response()->json([
            'success' => true,
            'message' => 'User updated.',
            'data' => $updated
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
    }


    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'logged-out.'
        ],200);
    }

    public function search($name)
    {
        return User::where('name', 'like', '%' . $name . '%')->get();
    }
}
