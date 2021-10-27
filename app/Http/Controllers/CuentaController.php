<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->is_admin == true) {
            $accounts = Cuenta::all();

            return response()->json([
                'success' => true,
                'data' => $accounts,
            ], status: 200);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'You do not have access.',
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        if ($user->is_admin == true) {

            $this->validate($request, [
                'numero_de_cuenta' => 'required|min:15',
                'tipo' => 'required',
                'user_id' => 'required'
            ]);

            $account = Cuenta::create([
                'numero_de_cuenta' => $request->numero_de_cuenta,
                'tipo' => $request->tipo,
                'user_id' => $request->user_id
            ]);

            if (!$account) {
                return response()->json([
                    'success' => false,
                    'data' => 'This action cannot be performed.'
                ], status: 400);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $account,
                ], status: 201);
            }
        } else {

            return response()->json([
                'success' => false,
                'message' => 'You must be an administrator.',
            ], status: 400);
        }
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
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function show(Cuenta $cuenta)
    {
        $user = auth()->user();

        if ($user) {

            $account = Cuenta::select(['tipo', 'numero_de_cuenta', 'user_id', 'created_at'])
                ->get();
            $account = Cuenta::where('user_id', $user->id)->get();

            if ($user && $account->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have an account yet",
                ], status: 400);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => "These are your accounts.",
                    'data' => $account,
                ], status: 200);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuenta $cuenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuenta $cuenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuenta $cuenta)
    {
        //
    }
}
