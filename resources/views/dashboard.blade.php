@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Bienvenido, ' . auth()->user()->name . '. Aquí está el resumen del sistema.')

@section('content')

{{-- ── Stat Cards (Componente Tailwind #2: Cards) ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">

    {{-- Cotos --}}
    <div class="stat-card">
        <div class="stat-icon bg-brand-50">
            <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Cotos registrados</p>
            <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_cotos'] }}</p>
            <a href="{{ route('cotos.index') }}" class="text-xs text-brand-600 hover:text-brand-800 font-medium mt-1 inline-block">Ver cotos →</a>
        </div>
    </div>

    {{-- Residentes --}}
    <div class="stat-card">
        <div class="stat-icon bg-violet-50">
            <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Residentes</p>
            <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total_residentes'] }}</p>
            <a href="{{ route('residentes.index') }}" class="text-xs text-violet-600 hover:text-violet-800 font-medium mt-1 inline-block">Ver residentes →</a>
        </div>
    </div>

    {{-- Total cobrado --}}
    <div class="stat-card">
        <div class="stat-icon bg-emerald-50">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Total cobrado</p>
            <p class="text-3xl font-bold text-slate-900 mt-1">${{ number_format($stats['total_pagos'], 0) }}</p>
            <p class="text-xs text-slate-400 mt-1">Pagos confirmados</p>
        </div>
    </div>

    {{-- Adeudos --}}
    <div class="stat-card border-l-4 border-l-red-400">
        <div class="stat-icon bg-red-50">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Total adeudos</p>
            <p class="text-3xl font-bold text-red-600 mt-1">${{ number_format($stats['total_adeudos'], 0) }}</p>
            <a href="{{ route('pagos.adeudos') }}" class="text-xs text-red-600 hover:text-red-800 font-medium mt-1 inline-block">Ver adeudos →</a>
        </div>
    </div>

    {{-- Pagos este mes --}}
    <div class="stat-card">
        <div class="stat-icon bg-sky-50">
            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Cobrado este mes</p>
            <p class="text-3xl font-bold text-slate-900 mt-1">${{ number_format($stats['pagos_este_mes'], 0) }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ now()->translatedFormat('F Y') }}</p>
        </div>
    </div>

    {{-- Con adeudo --}}
    <div class="stat-card">
        <div class="stat-icon bg-amber-50">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Residentes con adeudo</p>
            <p class="text-3xl font-bold text-amber-600 mt-1">{{ $stats['residentes_con_adeudo'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Requieren atención</p>
        </div>
    </div>

</div>

{{-- ── Tablas de actividad reciente ── --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    {{-- Pagos recientes --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Pagos recientes</h2>
                <p class="text-xs text-slate-400 mt-0.5">Últimos 5 movimientos</p>
            </div>
            <a href="{{ route('pagos.index') }}" class="btn-secondary btn-sm">Ver todos</a>
        </div>
        @if($pagos_recientes->isEmpty())
            <div class="py-12 text-center">
                <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-sm text-slate-400">Sin pagos registrados</p>
            </div>
        @else
        <div class="table-wrap">
            <table class="table">
                <thead><tr>
                    <th>Residente</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr></thead>
                <tbody>
                    @foreach($pagos_recientes as $pago)
                    <tr>
                        <td>
                            <p class="font-medium text-slate-800">{{ $pago->residente->nombre }}</p>
                            <p class="text-xs text-slate-400">{{ $pago->residente->coto->nombre }}</p>
                        </td>
                        <td class="font-semibold text-slate-800">${{ number_format($pago->monto, 2) }}</td>
                        <td class="text-slate-500">{{ $pago->fecha->format('d/m/Y') }}</td>
                        <td>
                            @if($pago->estado === 'pagado') <span class="badge-success">Pagado</span>
                            @elseif($pago->estado === 'pendiente') <span class="badge-warning">Pendiente</span>
                            @else <span class="badge-danger">Vencido</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Residentes con adeudo --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Residentes con adeudo</h2>
                <p class="text-xs text-slate-400 mt-0.5">Pagos pendientes o vencidos</p>
            </div>
            <a href="{{ route('pagos.adeudos') }}" class="btn-secondary btn-sm">Ver todos</a>
        </div>
        @if($residentes_adeudo->isEmpty())
            <div class="py-12 text-center">
                <svg class="w-10 h-10 text-emerald-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-slate-400">Sin adeudos pendientes</p>
            </div>
        @else
        <div class="table-wrap">
            <table class="table">
                <thead><tr>
                    <th>Residente</th>
                    <th>Casa</th>
                    <th>Coto</th>
                    <th></th>
                </tr></thead>
                <tbody>
                    @foreach($residentes_adeudo as $r)
                    <tr>
                        <td class="font-medium text-slate-800">{{ $r->nombre }}</td>
                        <td class="text-slate-500">{{ $r->casa }}</td>
                        <td class="text-slate-500">{{ $r->coto->nombre }}</td>
                        <td>
                            <a href="{{ route('residentes.show', $r) }}"
                               class="text-brand-600 hover:text-brand-800 text-xs font-semibold">Ver →</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection
