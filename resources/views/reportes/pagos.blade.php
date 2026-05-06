@extends('layouts.app')
@section('title','Reporte de Pagos')
@section('header','Reporte de Pagos')
@section('subheader','Del ' . \Carbon\Carbon::parse($request->desde)->format('d/m/Y') . ' al ' . \Carbon\Carbon::parse($request->hasta)->format('d/m/Y'))
@section('actions')
    <a href="{{ route('reportes.index') }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
<div class="card mb-5">
    <div class="card-body py-4">
        <form method="GET" action="{{ route('reportes.pagos') }}" class="flex flex-wrap gap-3 items-end">
            <div class="form-group">
                <label class="form-label">Desde</label>
                <input type="date" name="desde" value="{{ $request->desde }}" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Hasta</label>
                <input type="date" name="hasta" value="{{ $request->hasta }}" class="form-input">
            </div>
            <button type="submit" class="btn-primary">Generar</button>
        </form>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card p-5 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-wide">Total pagado</p>
        <p class="text-2xl font-bold text-emerald-600 mt-1">${{ number_format($resumen['total_pagado'], 2) }}</p>
    </div>
    <div class="card p-5 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-wide">Pendiente</p>
        <p class="text-2xl font-bold text-amber-600 mt-1">${{ number_format($resumen['total_pendiente'], 2) }}</p>
    </div>
    <div class="card p-5 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-wide">Vencido</p>
        <p class="text-2xl font-bold text-red-600 mt-1">${{ number_format($resumen['total_vencido'], 2) }}</p>
    </div>
    <div class="card p-5 text-center">
        <p class="text-xs text-slate-400 uppercase tracking-wide">Registros</p>
        <p class="text-2xl font-bold text-slate-800 mt-1">{{ $resumen['cantidad_pagos'] }}</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        @if($pagos->isEmpty())
            <div class="py-10 text-center text-slate-400 text-sm">No hay pagos en el rango seleccionado.</div>
        @else
        <table class="table">
            <thead><tr><th>Residente</th><th>Coto</th><th>Monto</th><th>Fecha</th><th>Periodo</th><th>Estado</th></tr></thead>
            <tbody>
                @foreach($pagos as $pago)
                <tr>
                    <td class="font-medium text-slate-800">{{ $pago->residente->nombre }}</td>
                    <td class="text-slate-500">{{ $pago->residente->coto->nombre }}</td>
                    <td class="font-semibold text-slate-800">${{ number_format($pago->monto, 2) }}</td>
                    <td class="text-slate-500">{{ $pago->fecha->format('d/m/Y') }}</td>
                    <td class="text-slate-500">{{ $pago->periodo_mes->format('M Y') }}</td>
                    <td>
                        @if($pago->estado === 'pagado')<span class="badge-success">Pagado</span>
                        @elseif($pago->estado === 'pendiente')<span class="badge-warning">Pendiente</span>
                        @else<span class="badge-danger">Vencido</span>@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50">
                <tr>
                    <td colspan="2" class="px-5 py-3 text-sm font-bold text-slate-700">Total</td>
                    <td class="px-5 py-3 font-bold text-slate-900">${{ number_format($pagos->sum('monto'), 2) }}</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
        @endif
    </div>
</div>
@endsection
