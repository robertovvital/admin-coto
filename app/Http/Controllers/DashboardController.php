<?php

namespace App\Http\Controllers;

use App\Models\Coto;
use App\Models\Pago;
use App\Models\Residente;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard general del sistema.
     */
    public function index()
    {
        $stats = [
            'total_cotos'       => Coto::count(),
            'total_residentes'  => Residente::count(),
            'total_pagos'       => Pago::pagados()->sum('monto'),
            'total_adeudos'     => Pago::adeudos()->sum('monto'),
            'pagos_este_mes'    => Pago::pagados()
                ->whereMonth('fecha', now()->month)
                ->whereYear('fecha', now()->year)
                ->sum('monto'),
            'residentes_con_adeudo' => Residente::whereHas('pagos', fn ($q) => $q->adeudos())->count(),
        ];

        $pagos_recientes = Pago::with(['residente.coto'])
            ->latest()
            ->take(5)
            ->get();

        $residentes_adeudo = Residente::with('coto')
            ->whereHas('pagos', fn ($q) => $q->adeudos())
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'pagos_recientes', 'residentes_adeudo'));
    }
}
