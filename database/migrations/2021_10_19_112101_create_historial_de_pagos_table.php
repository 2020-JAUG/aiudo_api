<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialDePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_de_pagos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_de_pago');
            $table->string('metodo_de_pago');
            $table->string('status');
            //Referencia al ID de la cuenta.
            $table->foreignId('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
            //Referencia al ID del préstamo.
            $table->foreignId('prestamo_id')->references('id')->on('prestamos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_de_pagos');
    }
}
