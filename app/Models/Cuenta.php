<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function historial_de_pago()
    {
        return $this->hasOne(Historial_de_pago::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'tipo',
        'numero_de_cuenta',
        'user_id'
    ];


    /**
     * @param $value
     * @return void
     */
    public function setTipoAttribute($value)
    {
        $this->attributes['tipo'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getTipoAttribute($value)
    {
        return ucfirst($value);
    }
}
