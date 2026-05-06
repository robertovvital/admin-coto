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

    {{-- Datos del residente --}}
    <div class="lg:col-span-2 space-y-6">

        <div class="card">
            <div class="card-header"><h2 class="text-sm font-semibold text-gray-700">Información personal</h2></div>
            <div class="card-body grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Correo electrónico</p>
                    <p class="font-medium text-gray-900">{{ $residente->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Contacto</p>
                    <p class="font-medium text-gray-900">{{ $residente->contacto ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Coto</p>
                    <a href="{{ route('cotos.show', $residente->coto) }}"
                       class="font-medium text-primary-600 hover:text-primary-800">
                        {{ $residente->coto->nombre }}
                    </a>
                </div>
                <div>
                    <p class="text-gray-500">Estado</p>
                    @if($residente->activo)
                        <span class="badge-success">Activo</span>
                    @else
                        <span class="badge-danger">Inactivo</span>
                    @endif
                </div>
            </div>
        </div>

        @if($residente->pais)
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-700">Datos internacionales</h2>
                <span class="badge-info">REST Countries</span>
            </div>
            <div class="card-body">
                <div class="flex items-center gap-4 mb-4">
                    @if($residente->bandera_url)
                        <img src="{{ $residente->bandera_url }}" alt="{{ $residente->pais }}"
                             class="w-20 h-12 object-cover rounded-lg shadow">
                    @endif
                    <div>
                        <p class="text-lg font-bold text-gray-900">{{ $residente->pais }}</p>
                        <p class="text-sm text-gray-500">Código: {{ $residente->pais_codigo }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Capital</p>
                        <p class="font-medium text-gray-900">{{ $residente->capital ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Moneda</p>
                        <p class="font-medium text-gray-900">{{ $residente->moneda ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Idioma(s)</p>
                        <p class="font-medium text-gray-900">{{ $residente->idioma ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Zona horaria</p>
                        <p class="font-medium text-gray-900">{{ $residente->zona_horaria ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- Resumen financiero --}}
    <div class="space-y-4">
        <div class="card">
            <div class="card-header"><h2 class="text-sm font-semibold text-gray-700">Resumen financiero</h2></div>
            <div class="card-body space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Total pagado</span>
                    <span class="font-bold text-green-600">${{ number_format($residente->totalPagado(), 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Total adeudos</span>
                    <span class="font-bold text-red-600">${{ number_format($residente->totalAdeudos(), 2) }}</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                    <span class="text-sm text-gray-500">Total pagos</span>
                    <span class="font-bold text-gray-900">{{ $residente->pagos->count() }}</span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Historial de pagos --}}
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-700">Historial de pagos</h2>
        <a href="{{ route('pagos.create') }}?residente_id={{ $residente->id }}" class="text-sm text-primary-600 hover:text-primary-800">+ Nuevo pago</a>
    </div>
    <div class="table-container">
        @if($residente->pagos->isEmpty())
            <div class="p-8 text-center text-gray-400 text-sm">No hay pagos registrados para este residente.</div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Periodo</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estado</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($residente->pagos as $pago)
                    <tr>
                        <td>{{ $pago->fecha->format('d/m/Y') }}</td>
                        <td class="text-gray-500">{{ $pago->periodo_mes->format('M Y') }}</td>
                        <td class="font-semibold">${{ number_format($pago->monto, 2) }}</td>
                        <td class="text-gray-500">{{ $pago->metodo_pago ?? '—' }}</td>
                        <td>
                            @if($pago->estado === 'pagado')
                                <span class="badge-success">Pagado</span>
                            @elseif($pago->estado === 'pendiente')
                                <span class="badge-warning">Pendiente</span>
                            @else
                                <span class="badge-danger">Vencido</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('pagos.show', $pago) }}"
                               class="text-primary-600 hover:text-primary-800 text-sm font-medium">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
