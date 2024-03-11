<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CuentaController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        try {
            if ($user->is_admin === true) {
                $accounts = Cuenta::all();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access.',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'This action cannot be performed.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $accounts,
        ], 200);
    }


    /**
     * @param Request $request
     * @return JsonResponse|string
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        DB::beginTransaction();
        try {
            $account = null;
            if (!$user->is_admin === true) {
                return ('You do not have access.');
            } else {

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
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            report($ex);
        }
        return response()->json([
            'success' => true,
            'data' => $account,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function show()
    {
        $user = auth()->user();
        try {
            $accounts = Cuenta::where('user_id', $user->id)->get();
        } catch (Exception $ex) {
            throw new $ex;
        }
        return response()->json([
            'success' => true,
            'message' => "These are your accounts.",
            'data' => $accounts,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Cuenta $cuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuenta $cuenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cuenta $cuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuenta $cuenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cuenta $cuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuenta $cuenta)
    {
        //
    }
}
