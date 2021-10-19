<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    //Una cuenta pertenece a un solo usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Una cuenta puede tener muchos prestamos.
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
