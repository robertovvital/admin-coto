<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'residente_id',
        'monto',
        'fecha',
        'periodo_mes',
        'estado',
        'metodo_pago',
        'notas',
        'registrado_por',
    ];

    protected $casts = [
        'fecha'       => 'date',
        'periodo_mes' => 'date',
        'monto'       => 'decimal:2',
    ];

    /**
     * Residente al que pertenece el pago.
     */
    public function residente()
    {
        return $this->belongsTo(Residente::class);
    }

    /**
     * Usuario que registró el pago.
     */
    public function registrador()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Scope: solo pagos realizados.
     */
    public function scopePagados($query)
    {
        return $query->where('estado', 'pagado');
    }

    /**
     * Scope: solo adeudos (pendiente o vencido).
     */
    public function scopeAdeudos($query)
    {
        return $query->whereIn('estado', ['pendiente', 'vencido']);
    }

    /**
     * Scope: filtrar por rango de fechas.
     */
    public function scopeEntreFechas($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha', [$desde, $hasta]);
    }
}
