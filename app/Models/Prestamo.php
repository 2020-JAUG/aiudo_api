<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    //Un préstamo pertenece a una cuenta.
    public function cuenta()
    {
        return $this-> belongsTo(Cuenta::class);
    }

    //Un préstamo tiene un historial de pagos.
    public function historial ()
    {
        return $this-> hasOne(Historial_de_pago::class);
    }
}
