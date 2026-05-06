@extends('layouts.app')
@section('title','Reportes')
@section('header','Reportes')
@section('subheader','Consulta y analiza la información financiera del sistema')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

    <a href="{{ route('reportes.pagos') }}?desde={{ now()->startOfMonth()->format('Y-m-d') }}&hasta={{ now()->format('Y-m-d') }}"
       class="card-hover group">
        <div class="card-body flex flex-col items-center text-center py-10">
            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-emerald-100 transition-colors">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800 mb-1">Reporte de Pagos</h3>
            <p class="text-sm text-slate-400">Consulta pagos por rango de fechas</p>
            <span class="mt-4 text-xs font-semibold text-emerald-600 group-hover:text-emerald-700">Abrir reporte →</span>
        </div>
    </a>

    <a href="{{ route('reportes.adeudos') }}" class="card-hover group">
        <div class="card-body flex flex-col items-center text-center py-10">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-red-100 transition-colors">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800 mb-1">Reporte de Adeudos</h3>
            <p class="text-sm text-slate-400">Adeudos agrupados por coto</p>
            <span class="mt-4 text-xs font-semibold text-red-600 group-hover:text-red-700">Abrir reporte →</span>
        </div>
    </a>

    <a href="{{ route('reportes.financiero') }}" class="card-hover group">
        <div class="card-body flex flex-col items-center text-center py-10">
            <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-brand-100 transition-colors">
                <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800 mb-1">Reporte Financiero</h3>
            <p class="text-sm text-slate-400">Resumen mensual por año</p>
            <span class="mt-4 text-xs font-semibold text-brand-600 group-hover:text-brand-700">Abrir reporte →</span>
        </div>
    </a>

</div>
@endsection
