@extends('layouts.app')

@section('title', 'Reportes')
@section('header', 'Reportes')
@section('subheader', 'Consulta y exporta información financiera del sistema')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

    {{-- Reporte de pagos --}}
    <a href="{{ route('reportes.pagos') }}?desde={{ now()->startOfMonth()->format('Y-m-d') }}&hasta={{ now()->format('Y-m-d') }}"
       class="card hover:shadow-md transition-shadow duration-200 group">
        <div class="card-body flex flex-col items-center text-center py-8">
            <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">Reporte de Pagos</h3>
            <p class="text-sm text-gray-500">Consulta pagos por rango de fechas</p>
        </div>
    </a>

    {{-- Reporte de adeudos --}}
    <a href="{{ route('reportes.adeudos') }}"
       class="card hover:shadow-md transition-shadow duration-200 group">
        <div class="card-body flex flex-col items-center text-center py-8">
            <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-red-200 transition-colors">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">Reporte de Adeudos</h3>
            <p class="text-sm text-gray-500">Adeudos agrupados por coto</p>
        </div>
    </a>

    {{-- Reporte financiero --}}
    <a href="{{ route('reportes.financiero') }}"
       class="card hover:shadow-md transition-shadow duration-200 group">
        <div class="card-body flex flex-col items-center text-center py-8">
            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">Reporte Financiero</h3>
            <p class="text-sm text-gray-500">Resumen mensual por año</p>
        </div>
    </a>

</div>

@endsection
