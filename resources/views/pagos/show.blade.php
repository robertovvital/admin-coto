@extends('layouts.app')

@section('title', 'Detalle de Pago')
@section('header', 'Detalle de Pago')
@section('subheader', 'Pago #' . $pago->id)

@section('actions')
    <a href="{{ route('pagos.edit', $pago) }}" class="btn-secondary">Editar</a>
    <a href="{{ route('pagos.index') }}" class="btn-secondary">Volver</a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-700">Información del pago</h2>
            @if($pago->estado === 'pagado')
                <span class="badge-success text-sm px-3 py-1">Pagado</span>
            @elseif($pago->estado === 'pendiente')
                <span class="badge-warning text-sm px-3 py-1">Pendiente</span>
            @else
                <span class="badge-danger text-sm px-3 py-1">Vencido</span>
            @endif
        </div>
        <div class="card-body space-y-4 text-sm">

            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Residente</span>
                <a href="{{ route('residentes.show', $pago->residente) }}"
                   class="font-semibold text-primary-600 hover:text-primary-800">
                    {{ $pago->residente->nombre }}
                </a>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Coto</span>
                <span class="font-medium text-gray-900">{{ $pago->residente->coto->nombre }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Casa</span>
                <span class="font-medium text-gray-900">{{ $pago->residente->casa }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Monto</span>
                <span class="text-xl font-bold text-gray-900">${{ number_format($pago->monto, 2) }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Fecha de pago</span>
                <span class="font-medium text-gray-900">{{ $pago->fecha->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Periodo</span>
                <span class="font-medium text-gray-900">{{ $pago->periodo_mes->format('F Y') }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Método de pago</span>
                <span class="font-medium text-gray-900">{{ $pago->metodo_pago ?? '—' }}</span>
            </div>
            @if($pago->notas)
            <div class="py-3 border-b border-gray-100">
                <p class="text-gray-500 mb-1">Notas</p>
                <p class="text-gray-900">{{ $pago->notas }}</p>
            </div>
            @endif
            <div class="flex justify-between py-3">
                <span class="text-gray-500">Registrado por</span>
                <span class="font-medium text-gray-900">{{ $pago->registrador?->name ?? 'Sistema' }}</span>
            </div>

        </div>
    </div>

    <div class="mt-4 flex gap-3">
        <form method="POST" action="{{ route('pagos.destroy', $pago) }}"
              onsubmit="return confirm('¿Eliminar este pago? Esta acción no se puede deshacer.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger">Eliminar pago</button>
        </form>
    </div>
</div>
@endsection
