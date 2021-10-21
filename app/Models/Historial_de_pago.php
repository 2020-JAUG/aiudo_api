<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_de_pago extends Model
{
    use HasFactory;

    //Un hostorial de pago pertenece a una cuenta.
    public function cuenta()
    {
        return $this-> belongsTo(Cuenta::class);
    }

    //Un historial pertenece a un préstamo.
    public function prestamo ()
    {
        return $this-> belongsTo(Prestamo::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fecha_de_pago',
        'metodo_de_pago',
        'status',
        'cuenta_id',
        'prestamo_id'
    ];
}
