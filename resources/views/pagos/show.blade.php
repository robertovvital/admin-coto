@extends('layouts.app')
@section('title','Detalle de Pago')
@section('header','Detalle de Pago #' . $pago->id)
@section('subheader', $pago->residente->nombre . ' · ' . $pago->residente->coto->nombre)
@section('actions')
    <a href="{{ route('pagos.edit', $pago) }}" class="btn-secondary">Editar</a>
    <a href="{{ route('pagos.index') }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
<div class="max-w-lg">
    <div class="card">
        <div class="card-header">
            <h2 class="text-sm font-bold text-slate-700">Información del pago</h2>
            @if($pago->estado === 'pagado')<span class="badge-success text-sm px-3 py-1">✅ Pagado</span>
            @elseif($pago->estado === 'pendiente')<span class="badge-warning text-sm px-3 py-1">⏳ Pendiente</span>
            @else<span class="badge-danger text-sm px-3 py-1">❌ Vencido</span>@endif
        </div>

        {{-- Monto destacado --}}
        <div class="px-6 py-6 bg-gradient-to-r from-brand-50 to-violet-50 border-b border-slate-100 text-center">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Monto</p>
            <p class="text-4xl font-bold text-slate-900">${{ number_format($pago->monto, 2) }}</p>
            <p class="text-sm text-slate-500 mt-1">{{ $pago->periodo_mes->format('F Y') }}</p>
        </div>

        <div class="card-body space-y-0 divide-y divide-slate-50">
            @php
                $rows = [
                    ['Residente', $pago->residente->nombre],
                    ['Coto', $pago->residente->coto->nombre],
                    ['Casa', $pago->residente->casa],
                    ['Fecha de pago', $pago->fecha->format('d/m/Y')],
                    ['Método de pago', $pago->metodo_pago ?? '—'],
                    ['Registrado por', $pago->registrador?->name ?? 'Sistema'],
                ];
            @endphp
            @foreach($rows as [$label, $value])
            <div class="flex justify-between items-center py-3">
                <span class="text-sm text-slate-500">{{ $label }}</span>
                <span class="text-sm font-semibold text-slate-800">{{ $value }}</span>
            </div>
            @endforeach
            @if($pago->notas)
            <div class="py-3">
                <p class="text-sm text-slate-500 mb-1">Notas</p>
                <p class="text-sm text-slate-700">{{ $pago->notas }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ route('pagos.destroy', $pago) }}" onsubmit="return confirm('¿Eliminar este pago?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger btn-sm">Eliminar pago</button>
        </form>
    </div>
</div>
@endsection
