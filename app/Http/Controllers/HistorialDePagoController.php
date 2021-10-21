<?php

namespace App\Http\Controllers;

use App\Models\Historial_de_pago;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HistorialDePagoController extends Controller
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
            $payments = Historial_de_pago::all();

            return response()->json([
                'success' => true,
                'data' => $payments,
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
                'fecha_de_pago' => 'required',
                'metodo_de_pago' => 'required',
                'status' => 'required',
                'cuenta_id' => 'required',
                'prestamo_id' => 'required'
            ]);

            $payment = Historial_de_pago::create([
                'fecha_de_pago' => $request->fecha_de_pago,
                'metodo_de_pago' => $request->metodo_de_pago,
                'status' => $request->status,
                'cuenta_id' => $request->cuenta_id,
                'prestamo_id' => $request->prestamo_id
            ]);

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'data' => 'The payment was not processed.'
                ], status: 400);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $payment,
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
     * @param  \App\Models\Historial_de_pago  $historial_de_pago
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();

        //Función para hacer una doble búsqueda para devolver un dato en conjunto.
        $userPayments = DB::table('historial_de_pagos')
            ->join('cuentas', 'historial_de_pagos.cuenta_id', '=', 'cuentas.id')
            ->select('*')
            ->where('cuentas.user_id', '=', $user->id)
            ->select(['fecha_de_pago', 'metodo_de_pago', 'status', 'cuenta_id', 'user_id'])//Filtro los datos que quiero mostrar.
            ->orderBy('fecha_de_pago', 'desc')//Devuelve los pagos hechos recientemente.
            ->get();//Con get me devuelve el valor de la consulta.

        if ($user) {

            return response()->json([
                'success' => true,
                'data' => $userPayments,
            ], status: 200);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'You do not have access.',
            ], status: 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Historial_de_pago  $historial_de_pago
     * @return \Illuminate\Http\Response
     */
    public function edit(Historial_de_pago $historial_de_pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Historial_de_pago  $historial_de_pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historial_de_pago $historial_de_pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historial_de_pago  $historial_de_pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historial_de_pago $historial_de_pago)
    {
        //
    }
}
