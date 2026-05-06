<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'activo'            => 'boolean',
        ];
    }

    /**
     * Verifica si el usuario es administrador.
     */
    public function esAdministrador(): bool
    {
        return $this->role === 'administrador';
    }

    /**
     * Verifica si el usuario es empleado.
     */
    public function esEmpleado(): bool
    {
        return $this->role === 'empleado';
    }

    /**
     * Verifica si el usuario es residente.
     */
    public function esResidente(): bool
    {
        return $this->role === 'residente';
    }

    /**
     * Pagos registrados por este usuario.
     */
    public function pagosRegistrados()
    {
        return $this->hasMany(Pago::class, 'registrado_por');
    }
}
