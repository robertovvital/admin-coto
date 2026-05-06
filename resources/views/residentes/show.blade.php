@extends('layouts.app')
@section('title', $residente->nombre)
@section('header', $residente->nombre)
@section('subheader', 'Casa ' . $residente->casa . ' · ' . $residente->coto->nombre)
@section('actions')
    <a href="{{ route('pagos.create') }}?residente_id={{ $residente->id }}" class="btn-primary">+ Registrar pago</a>
    <a href="{{ route('residentes.edit', $residente) }}" class="btn-secondary">Editar</a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    <div class="lg:col-span-2 space-y-5">
        <div class="card">
            <div class="card-header"><h2 class="text-sm font-bold text-slate-700">Información personal</h2></div>
            <div class="card-body grid grid-cols-2 gap-4 text-sm">
                <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Correo</p><p class="font-medium text-slate-800">{{ $residente->email }}</p></div>
                <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Contacto</p><p class="font-medium text-slate-800">{{ $residente->contacto ?? '—' }}</p></div>
                <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Coto</p>
                    <a href="{{ route('cotos.show', $residente->coto) }}" class="font-semibold text-brand-600 hover:text-brand-800">{{ $residente->coto->nombre }}</a>
                </div>
                <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Estado</p>
                    @if($residente->activo)<span class="badge-success">Activo</span>@else<span class="badge-danger">Inactivo</span>@endif
                </div>
            </div>
        </div>

        @if($residente->pais)
        <div class="card">
            <div class="card-header">
                <h2 class="text-sm font-bold text-slate-700">Datos internacionales</h2>
                <span class="badge-info">REST Countries</span>
            </div>
            <div class="card-body">
                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-brand-50 to-violet-50 rounded-xl border border-brand-100 mb-5">
                    @if($residente->bandera_url)
                        <img src="{{ $residente->bandera_url }}" alt="{{ $residente->pais }}" class="w-20 h-12 object-cover rounded-lg shadow border border-white">
                    @endif
                    <div>
                        <p class="text-lg font-bold text-slate-900">{{ $residente->pais }}</p>
                        <p class="text-xs text-slate-500">Código: {{ $residente->pais_codigo }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Capital</p><p class="font-medium text-slate-800">{{ $residente->capital ?? '—' }}</p></div>
                    <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Moneda</p><p class="font-medium text-slate-800">{{ $residente->moneda ?? '—' }}</p></div>
                    <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Idioma(s)</p><p class="font-medium text-slate-800">{{ $residente->idioma ?? '—' }}</p></div>
                    <div><p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Zona horaria</p><p class="font-medium text-slate-800">{{ $residente->zona_horaria ?? '—' }}</p></div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-5">
        <div class="card">
            <div class="card-header"><h2 class="text-sm font-bold text-slate-700">Resumen financiero</h2></div>
            <div class="card-body space-y-3">
                <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-xl">
                    <span class="text-sm text-emerald-700 font-medium">Total pagado</span>
                    <span class="font-bold text-emerald-700">${{ number_format($residente->totalPagado(), 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-xl">
                    <span class="text-sm text-red-700 font-medium">Total adeudos</span>
                    <span class="font-bold text-red-700">${{ number_format($residente->totalAdeudos(), 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                    <span class="text-sm text-slate-600 font-medium">Total pagos</span>
                    <span class="font-bold text-slate-800">{{ $residente->pagos->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Historial de pagos --}}
<div class="card">
    <div class="card-header">
        <h2 class="text-sm font-bold text-slate-700">Historial de pagos</h2>
        <a href="{{ route('pagos.create') }}?residente_id={{ $residente->id }}" class="btn-primary btn-sm">+ Nuevo pago</a>
    </div>
    <div class="table-wrap">
        @if($residente->pagos->isEmpty())
            <div class="py-10 text-center text-slate-400 text-sm">No hay pagos registrados.</div>
        @else
        <table class="table">
            <thead><tr><th>Fecha</th><th>Periodo</th><th>Monto</th><th>Método</th><th>Estado</th><th class="text-right">Acciones</th></tr></thead>
            <tbody>
                @foreach($residente->pagos as $pago)
                <tr>
                    <td class="text-slate-600">{{ $pago->fecha->format('d/m/Y') }}</td>
                    <td class="text-slate-500">{{ $pago->periodo_mes->format('M Y') }}</td>
                    <td class="font-semibold text-slate-800">${{ number_format($pago->monto, 2) }}</td>
                    <td class="text-slate-500">{{ $pago->metodo_pago ?? '—' }}</td>
                    <td>
                        @if($pago->estado === 'pagado')<span class="badge-success">Pagado</span>
                        @elseif($pago->estado === 'pendiente')<span class="badge-warning">Pendiente</span>
                        @else<span class="badge-danger">Vencido</span>@endif
                    </td>
                    <td class="text-right"><a href="{{ route('pagos.show', $pago) }}" class="text-brand-600 hover:text-brand-800 text-xs font-semibold">Ver →</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
