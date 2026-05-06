<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'direccion',
        'responsable',
        'telefono',
        'email',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Residentes que pertenecen a este coto.
     */
    public function residentes()
    {
        return $this->hasMany(Residente::class);
    }

    /**
     * Total de pagos recibidos en este coto.
     */
    public function totalPagos(): float
    {
        return $this->residentes()
            ->with('pagos')
            ->get()
            ->sum(fn ($r) => $r->pagos->where('estado', 'pagado')->sum('monto'));
    }

    /**
     * Total de adeudos en este coto.
     */
    public function totalAdeudos(): float
    {
        return $this->residentes()
            ->with('pagos')
            ->get()
            ->sum(fn ($r) => $r->pagos->whereIn('estado', ['pendiente', 'vencido'])->sum('monto'));
    }
}
