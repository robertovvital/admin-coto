@extends('layouts.app')
@section('title','Reporte de Adeudos')
@section('header','Reporte de Adeudos')
@section('subheader','Adeudos agrupados por coto residencial')
@section('actions')
    <a href="{{ route('reportes.index') }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
@if($cotos->isEmpty())
    <div class="card py-16 text-center"><p class="text-slate-400">No hay datos disponibles.</p></div>
@else
<div class="space-y-6">
    @foreach($cotos as $coto)
    @if($coto->total_adeudos > 0)
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-base font-bold text-slate-800">{{ $coto->nombre }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ $coto->residentes_con_adeudo }} residente(s) con adeudo</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-400">Total adeudado</p>
                <p class="text-xl font-bold text-red-600">${{ number_format($coto->total_adeudos, 2) }}</p>
            </div>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Residente</th><th>Casa</th><th>Periodo</th><th>Monto</th><th>Estado</th></tr></thead>
                <tbody>
                    @foreach($coto->residentes as $r)
                        @foreach($r->pagos as $pago)
                        <tr>
                            <td class="font-medium text-slate-800">{{ $r->nombre }}</td>
                            <td class="text-slate-500">{{ $r->casa }}</td>
                            <td class="text-slate-500">{{ $pago->periodo_mes->format('M Y') }}</td>
                            <td class="font-semibold text-red-600">${{ number_format($pago->monto, 2) }}</td>
                            <td>
                                @if($pago->estado === 'vencido')<span class="badge-danger">Vencido</span>
                                @else<span class="badge-warning">Pendiente</span>@endif
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endif
@endsection
