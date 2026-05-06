@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Resumen general del sistema')

@section('content')

{{-- Cards de estadísticas (Componente Tailwind #2) --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    {{-- Card: Total Cotos --}}
    <div class="card">
        <div class="card-body flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Cotos</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_cotos'] }}</p>
            </div>
        </div>
    </div>

    {{-- Card: Total Residentes --}}
    <div class="card">
        <div class="card-body flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Residentes</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_residentes'] }}</p>
            </div>
        </div>
    </div>

    {{-- Card: Total Pagos --}}
    <div class="card">
        <div class="card-body flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Cobrado</p>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($stats['total_pagos'], 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Card: Total Adeudos --}}
    <div class="card">
        <div class="card-body flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Adeudos</p>
                <p class="text-3xl font-bold text-red-600">${{ number_format($stats['total_adeudos'], 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Card: Pagos este mes --}}
    <div class="card">
        <div class="card-body flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Pagos este mes</p>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($stats['pagos_este_mes'], 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Card: Residentes con adeudo --}}
    <div class="card">
        <div class="card-body flex items-center">
            <div class="flex-shrink-0 w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Con adeudo</p>
                <p class="text-3xl font-bold text-orange-600">{{ $stats['residentes_con_adeudo'] }}</p>
            </div>
        </div>
    </div>

</div>

{{-- Tablas de resumen --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Pagos recientes --}}
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Pagos recientes</h2>
            <a href="{{ route('pagos.index') }}" class="text-sm text-primary-600 hover:text-primary-800">Ver todos</a>
        </div>
        <div class="overflow-x-auto">
            @if($pagos_recientes->isEmpty())
            <div class="p-6 text-center text-gray-400 text-sm">No hay pagos registrados aún.</div>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Residente</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pagos_recientes as $pago)
                    <tr>
                        <td>
                            <div class="font-medium text-gray-900">{{ $pago->residente->nombre }}</div>
                            <div class="text-xs text-gray-500">{{ $pago->residente->coto->nombre }}</div>
                        </td>
                        <td class="font-semibold">${{ number_format($pago->monto, 2) }}</td>
                        <td class="text-gray-500">{{ $pago->fecha->format('d/m/Y') }}</td>
                        <td>
                            @if($pago->estado === 'pagado')
                                <span class="badge-success">Pagado</span>
                            @elseif($pago->estado === 'pendiente')
                                <span class="badge-warning">Pendiente</span>
                            @else
                                <span class="badge-danger">Vencido</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    {{-- Residentes con adeudo --}}
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Residentes con adeudo</h2>
            <a href="{{ route('pagos.adeudos') }}" class="text-sm text-primary-600 hover:text-primary-800">Ver todos</a>
        </div>
        <div class="overflow-x-auto">
            @if($residentes_adeudo->isEmpty())
            <div class="p-6 text-center text-gray-400 text-sm">No hay adeudos pendientes.</div>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Residente</th>
                        <th>Casa</th>
                        <th>Coto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($residentes_adeudo as $residente)
                    <tr>
                        <td>
                            <a href="{{ route('residentes.show', $residente) }}"
                               class="font-medium text-primary-600 hover:text-primary-800">
                                {{ $residente->nombre }}
                            </a>
                        </td>
                        <td class="text-gray-500">{{ $residente->casa }}</td>
                        <td class="text-gray-500">{{ $residente->coto->nombre }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>

@endsection
