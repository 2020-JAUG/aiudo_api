<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->is_admin == true) { //Nos trae todos los préstamos.
            $loans = Prestamo::all();

            return response()->json([
                'success' => true,
                'data' => $loans,
            ], status: 200);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'You do not have access.',
            ], status: 400);
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
                'tipo' => 'required',
                'deuda_total' => 'required',
                'cantidad_pagada' => 'required',
                'cuotas' => 'required',
                'fecha_de_inicio' => 'required',
                'fecha_de_fin' => 'required',
                'user_id' => 'required'
            ]);

            $loan = Prestamo::create([
                'tipo' => $request->tipo,
                'deuda_total' => $request->deuda_total,
                'cantidad_pagada' => $request->cantidad_pagada,
                'cuotas' => $request->cuotas,
                'fecha_de_inicio' => $request->fecha_de_inicio,
                'fecha_de_fin' => $request->fecha_de_fin,
                'user_id' => $request->user_id
            ]);

            if (!$loan) {
                return response()->json([
                    'success' => false,
                    'data' => 'The loan is not accepted.'
                ], status: 400);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $loan,
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function show(Prestamo $prestamo)
    {
        $user = auth()->user();

        if ($user) {

            //Filtramos los campos que se le va a mostrar al usuario.
            $loans = Prestamo::select(['tipo', 'deuda_total', 'cantidad_pagada', 'cuotas', 'fecha_de_inicio', 'fecha_de_fin', 'user_id', 'created_at'])
                ->get();

            //Confirmamos el id del usuario para traer sus préstamos.
            $loans = Prestamo::where('user_id', '=', $user->id)->get();

            if ($loans->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Do not have any loans.',
                ], status: 400);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'These are your loans.',
                    'data' => $loans,
                ], status: 200);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Prestamo $prestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestamo $prestamo)
    {
        //
    }
}
