<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;

use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //Un usuario puede tener muchas cuentas.
    public function cuenta()
    {
        return $this->hasMany(Cuenta::class);
    }

    //Un usuario puede tener muchos prestamos.
    public function prestamo()
    {
        return $this->hasMany(Prestamo::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'is_admin',
        'name',
        'lastName',
        'address',
        'phone',
        'dni',
        'birthday',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
     */
    //Para personalizar el correo electrónico.
    public function sendPasswordResetNotification($token)
    {
        $url = 'https://example.com/reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }
}
