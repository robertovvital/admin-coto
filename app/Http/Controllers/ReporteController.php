<?php

namespace App\Http\Controllers;

use App\Models\Coto;
use App\Models\Pago;
use App\Models\Residente;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Vista principal de reportes.
     */
    public function index()
    {
        return view('reportes.index');
    }

    /**
     * Reporte de pagos por rango de fechas.
     */
    public function pagos(Request $request)
    {
        $request->validate([
            'desde' => 'required|date',
            'hasta' => 'required|date|after_or_equal:desde',
        ]);

        $pagos = Pago::with(['residente.coto'])
            ->entreFechas($request->desde, $request->hasta)
            ->orderBy('fecha')
            ->get();

        $resumen = [
            'total_pagado'   => $pagos->where('estado', 'pagado')->sum('monto'),
            'total_pendiente' => $pagos->where('estado', 'pendiente')->sum('monto'),
            'total_vencido'  => $pagos->where('estado', 'vencido')->sum('monto'),
            'cantidad_pagos' => $pagos->count(),
        ];

        return view('reportes.pagos', compact('pagos', 'resumen', 'request'));
    }

    /**
     * Reporte de adeudos por coto.
     */
    public function adeudos(Request $request)
    {
        $cotos = Coto::with(['residentes.pagos' => fn ($q) => $q->adeudos()])
            ->get()
            ->map(function ($coto) {
                $coto->total_adeudos = $coto->residentes->sum(
                    fn ($r) => $r->pagos->sum('monto')
                );
                $coto->residentes_con_adeudo = $coto->residentes->filter(
                    fn ($r) => $r->pagos->isNotEmpty()
                )->count();
                return $coto;
            });

        return view('reportes.adeudos', compact('cotos'));
    }

    /**
     * Reporte financiero general.
     */
    public function financiero(Request $request)
    {
        $anio = $request->get('anio', now()->year);

        $meses = collect(range(1, 12))->map(function ($mes) use ($anio) {
            return [
                'mes'      => $mes,
                'nombre'   => now()->setMonth($mes)->translatedFormat('F'),
                'pagado'   => Pago::pagados()->whereMonth('fecha', $mes)->whereYear('fecha', $anio)->sum('monto'),
                'adeudos'  => Pago::adeudos()->whereMonth('fecha', $mes)->whereYear('fecha', $anio)->sum('monto'),
            ];
        });

        $anios = Pago::selectRaw('YEAR(fecha) as anio')
            ->distinct()
            ->orderBy('anio', 'desc')
            ->pluck('anio');

        return view('reportes.financiero', compact('meses', 'anio', 'anios'));
    }
}
