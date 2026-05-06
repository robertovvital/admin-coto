<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Residente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coto_id',
        'nombre',
        'casa',
        'contacto',
        'email',
        'pais',
        'pais_codigo',
        'capital',
        'moneda',
        'idioma',
        'zona_horaria',
        'bandera_url',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Coto al que pertenece el residente.
     */
    public function coto()
    {
        return $this->belongsTo(Coto::class);
    }

    /**
     * Pagos del residente.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Verifica si el residente tiene adeudos.
     */
    public function tieneAdeudos(): bool
    {
        return $this->pagos()->whereIn('estado', ['pendiente', 'vencido'])->exists();
    }

    /**
     * Total de adeudos del residente.
     */
    public function totalAdeudos(): float
    {
        return $this->pagos()->whereIn('estado', ['pendiente', 'vencido'])->sum('monto');
    }

    /**
     * Total pagado por el residente.
     */
    public function totalPagado(): float
    {
        return $this->pagos()->where('estado', 'pagado')->sum('monto');
    }
}
