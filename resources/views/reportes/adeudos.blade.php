@extends('layouts.app')

@section('title', 'Reporte de Adeudos')
@section('header', 'Reporte de Adeudos')
@section('subheader', 'Adeudos agrupados por coto residencial')

@section('actions')
    <a href="{{ route('reportes.index') }}" class="btn-secondary">Volver</a>
@endsection

@section('content')

@if($cotos->isEmpty())
    <div class="card p-12 text-center">
        <p class="text-gray-400 text-sm">No hay datos de adeudos disponibles.</p>
    </div>
@else
    <div class="space-y-6">
        @foreach($cotos as $coto)
        @if($coto->total_adeudos > 0)
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">{{ $coto->nombre }}</h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $coto->residentes_con_adeudo }} residente(s) con adeudo</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Total adeudado</p>
                    <p class="text-xl font-bold text-red-600">${{ number_format($coto->total_adeudos, 2) }}</p>
                </div>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Residente</th>
                            <th>Casa</th>
                            <th>Periodo</th>
                            <th>Monto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($coto->residentes as $residente)
                            @foreach($residente->pagos as $pago)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $residente->nombre }}</td>
                                <td class="text-gray-500">{{ $residente->casa }}</td>
                                <td class="text-gray-500">{{ $pago->periodo_mes->format('M Y') }}</td>
                                <td class="font-semibold text-red-600">${{ number_format($pago->monto, 2) }}</td>
                                <td>
                                    @if($pago->estado === 'vencido')
                                        <span class="badge-danger">Vencido</span>
                                    @else
                                        <span class="badge-warning">Pendiente</span>
                                    @endif
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
